<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Product;
use App\Color;
use App\Size;
use App\ProductSize;
use App\ColorProduct;
use App\Category;
use App\Subcategory;
use App\Payment;
use App\Transfer;
use App\Order;
use App\Item;
use App\Setting;
use App\Http\Requests\CartAddProductRequest;
use App\Http\Requests\CartQtyProductRequest;
use App\Http\Requests\SaleStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;

class WebController extends Controller
{
    public function index() {
    	$products=Product::where([['qty', '>', 0], ['state', '1']])->orderBy('id', 'DESC')->limit(8)->get();
        $banners=Banner::where('state', '1')->get();
        $num=0;
        return view('web.home', compact('banners', 'products', 'num'));
    }

    public function about() {
        $setting=Setting::first();
        return view('web.about', compact('setting'));
    }

    public function shop(Request $request) {
        $categories=Category::all();
        $subcategories=[];
        
        if ($request->has('page')) {
            $offset=20*(request('page')-1);
        } else {
            $offset=0;
        }

        if (is_null(request('category'))) {
            $products=Product::where('qty', '>', 0)->where('state', "1")->orderBy('id', 'DESC')->offset($offset)->limit(20)->get();
            $total=Product::where('qty', '>', 0)->where('state', "1")->get();
        } else {
            $category=Category::where('slug', request('category'))->firstOrFail();
            $subcategories=$category->subcategories;
            if (is_null(request('subcategory'))) {
                $products=$category->subcategories()->with('products')->get()->pluck('products')->collapse()->unique('id')->values()->where('qty', '>', 0)->where('state', "1")->slice($offset)->take(20)->sortByDesc('id');
                $total=$category->subcategories()->with('products')->get()->pluck('products')->collapse()->unique('id')->values()->where('qty', '>', 0)->where('state', "1");
            } else {
                $subcategory=Subcategory::where('slug', request('subcategory'))->firstOrFail();
                $products=$subcategory->products->where('qty', '>', 0)->where('state', "1")->slice($offset)->take(20)->sortByDesc('id');
                $total=$subcategory->products->where('qty', '>', 0)->where('state', "1");
            }
        }

        if (!is_null(request('min'))) {
            $products=$products->where('price', '>', request('min'));
        }

        if (!is_null(request('max'))) {
            $products=$products->where('price', '<', request('max'));
        }
        $search=request()->all();

        $varPage='page';
        $page=Paginator::resolveCurrentPage($varPage);
        $pagination=new LengthAwarePaginator($products, $total=count($total), $perPage = 20, $page, ['path' => Paginator::resolveCurrentPath(), 'pageName' => $varPage]);

        return view('web.shop', compact('products', 'categories', 'subcategories', 'pagination', 'search'));
    }

    public function product($slug) {
        $product=Product::where('slug', $slug)->firstOrFail();
        $products=Product::where([['id', '!=', $product->id], ['qty', '>', 0], ['state', '1']])->limit(4)->get();
        return view('web.product', compact('product', 'products'));
    }

    public function contact() {
        $setting=Setting::first();
        return view('web.contact', compact('setting'));
    }

    public function cart(Request $request) {
        $total=0;
        $products=[];
        if ($request->session()->has('cart')) {
            $cart=session('cart');
            $request->session()->forget('cart');
            $num=0;
            foreach ($cart as $item) {
                $product=Product::where('slug', $item['product']->slug)->first();
                if (!is_null($product) && $product->qty>0) {
                    $color=(!is_null($item['color'])) ? Color::where('slug', $item['color']->slug)->first() : NULL ;
                    $size=(!is_null($item['size'])) ? Size::where('slug', $item['size']->slug)->first() : NULL ;

                    $products[$num]['product']=$product;
                    $products[$num]['code']=$item['code'];
                    if (!is_null($color)) {
                        $products[$num]['color']=($color->products->where('id', $product->id)->isNotEmpty()) ? $color : NULL;
                    } else {
                        $products[$num]['color']=NULL;
                    }
                    if (!is_null($size)) {
                        $products[$num]['size']=($size->products->where('id', $product->id)->isNotEmpty()) ? $size : NULL;
                    } else {
                        $products[$num]['size']=NULL;
                    }
                    $products[$num]['qty']=($product->qty>=$item['qty']) ? $item['qty'] : $product->qty;
                    if ($product->discount>0) {
                        $subtotal=($product->price-(($product->price*$product->discount)/100))*$products[$num]['qty'];
                        $price=($product->price-(($product->price*$product->discount)/100));
                    } else {
                        $subtotal=$product->price*$products[$num]['qty'];
                        $price=$product->price;
                    }
                    $products[$num]['discount']=$product->discount;
                    $products[$num]['subtotal']=number_format($subtotal, 2, ',', '.');
                    $total+=$subtotal;

                    if ($num==0) {
                        $request->session()->put('cart', array(0 => ['product' => $product, 'qty' => $item['qty'], 'subtotal' => number_format($subtotal, 2, ',', '.'), 'price' => $price, 'size' => $size, 'color' => $color, 'code' => $item['code']]));
                    } else {
                        $request->session()->push('cart', array('product' => $product, 'qty' => $item['qty'], 'subtotal' => number_format($subtotal, 2, ',', '.'), 'price' => $price, 'size' => $size, 'color' => $color, 'code' => $item['code']));
                    }
                    $num++;
                }
            }
        }

        return view('web.cart', compact("products", "total"));
    }

    public function cartAdd(CartAddProductRequest $request) {
        $product=Product::where('slug', request('product'))->first();
        if (!is_null($product) && $product->qty>0) {
            $color=Color::where('slug', request('color'))->first();
            $size=Size::where('slug', request('size'))->first();
            $code=$product->slug;
            if (!is_null($color)) {
                $code.=($color->products->where('id', $product->id)->isNotEmpty()) ? "-".$color->slug : "";
            }
            if (!is_null($size)) {
                $code.=($size->products->where('id', $product->id)->isNotEmpty()) ? "-".$size->slug : "";
            }

            if ($request->session()->has('cart')) {
                $cart=session('cart');

                if (array_search($code, array_column($cart, 'code'))!==false) {

                    $key=array_search($code, array_column($cart, 'code'));
                    $cart[$key]['product']=$product;
                    $cart[$key]['qty']=($product->qty>=($cart[$key]['qty']+request('qty'))) ? $cart[$key]['qty']+request('qty') : $product->qty;
                    if ($product->discount>0) {
                        $subtotal=($product->price-(($product->price*$product->discount)/100))*$cart[$key]['qty'];
                        $cart[$key]['price']=($product->price-(($product->price*$product->discount)/100));
                    } else {
                        $subtotal=$product->price*$cart[$key]['qty'];
                        $cart[$key]['price']=$product->price;
                    }
                    $cart[$key]['discount']=$product->discount;
                    $cart[$key]['subtotal']=number_format($subtotal, 2, ',', '.');
                    $request->session()->put('cart', $cart);

                    return response()->json(['status' => true, 'qty' => count(session('cart'))]);

                } else {
                    $qty=($product->qty>=request('qty')) ? request('qty') : $product->qty;
                    if ($product->discount>0) {
                        $subtotal=($product->price-(($product->price*$product->discount)/100))*$qty;
                        $price=($product->price-(($product->price*$product->discount)/100));
                    } else {
                        $subtotal=$product->price*$qty;
                        $price=$product->price;
                    }
                    $request->session()->push('cart', array('product' => $product, 'qty' => $qty, 'subtotal' => number_format($subtotal, 2, ',', '.'), 'price' => $price, 'discount' => $product->discount, 'size' => $size, 'color' => $color, 'code' => $code));

                    return response()->json(['status' => true, 'qty' => count(session('cart'))]);
                }
            } else {
                $qty=($product->qty>=request('qty')) ? request('qty') : $product->qty;
                if ($product->discount>0) {
                    $subtotal=($product->price-(($product->price*$product->discount)/100))*$qty;
                    $price=($product->price-(($product->price*$product->discount)/100));
                } else {
                    $subtotal=$product->price*$qty;
                    $price=$product->price;
                }
                $request->session()->push('cart', array('product' => $product, 'qty' => $qty, 'subtotal' => number_format($subtotal, 2, ',', '.'), 'price' => $price, 'discount' => $product->discount, 'size' => $size, 'color' => $color, 'code' => $code));

                return response()->json(['status' => true, 'qty' => count(session('cart'))]);
            }
        }

        return response()->json(['status' => false]);
    }

    public function cartRemove(Request $request) {
        if ($request->session()->has('cart')) {
            $cart=session('cart');

            if (array_search(request('code'), array_column($cart, 'code'))!==false) {
                $request->session()->forget('cart');
                foreach ($cart as $item) {
                    if (request('code')!=$item['code']) {
                        if (!$request->session()->has('cart')) {
                            $request->session()->put('cart', array(0 => $item));
                        } else {
                            $request->session()->push('cart', $item);
                        }
                    }
                }
                $qty=($request->session()->has('cart')) ? count(session('cart')) : 0;

                return response()->json(['status' => true, 'qty' => $qty]);
            }
        }

        return response()->json(['status' => false]);
    }

    public function cartQty(CartQtyProductRequest $request) {
        $product=Product::where('slug', request('slug'))->first();
        if (!is_null($product) && $product->qty>0) {
            $cart=session('cart');
            if (array_search(request('code'), array_column($cart, 'code'))!==false) {
                $key=array_search(request('code'), array_column($cart, 'code'));
                $cart[$key]['product']=$product;
                $cart[$key]['qty']=($product->qty>=request('qty')) ? request('qty') : $product->qty;
                if ($cart[$key]['product']->discount>0) {
                    $subtotal=($cart[$key]['product']->price-(($cart[$key]['product']->price*$cart[$key]['product']->discount)/100))*$cart[$key]['qty'];
                    $cart[$key]['price']=($cart[$key]['product']->price-(($cart[$key]['product']->price*$cart[$key]['product']->discount)/100));
                } else {
                    $subtotal=$cart[$key]['product']->price*$cart[$key]['qty'];
                    $cart[$key]['price']=$cart[$key]['product']->price;
                }
                $cart[$key]['discount']=$cart[$key]['product']->discount;
                $cart[$key]['subtotal']=number_format($subtotal, 2, ',', '.');
                $request->session()->put('cart', $cart);

                return response()->json(['status' => true, 'subtotal' => number_format($subtotal, 2, ',', '.')]);
            }
        }

        return response()->json(['status' => false]);
    }

    public function checkout(Request $request)
    {
        $total=0;
        $products=[];
        if ($request->session()->has('cart')) {
            $cart=session('cart');
            $request->session()->forget('cart');
            $num=0;
            foreach ($cart as $item) {
                $size=Size::where('slug', $item['size']->slug)->first();
                $color=Color::where('slug', $item['color']->slug)->first();
                $product=Product::where('slug', $item['product']->slug)->first();

                $productSize=ProductSize::where([['product_id', $product->id], ['size_id', $size->id]])->first();
                $productColor=ColorProduct::where([['product_id', $product->id], ['color_id', $color->id]])->first();

                if (!is_null($productColor) && !is_null($productSize)) {
                    if ($product->discount>0) {
                        $subtotal=($product->price-(($product->price*$product->discount)/100))*$item['qty'];
                        $price=($product->price-(($product->price*$product->discount)/100));
                    } else {
                        $subtotal=$product->price*$item['qty'];
                        $price=$product->price;
                    }
                    $products[$num]['subtotal']=number_format($subtotal, 2, ',', '.');
                    $total+=$subtotal;

                    if ($num==0) {
                        $request->session()->put('cart', array(0 => ['product' => $product, 'qty' => $item['qty'], 'subtotal' => number_format($subtotal, 2, ',', '.'), 'price' => $price, 'size' => $size, 'color' => $color, 'code' => $item['code']]));
                    } else {
                        $request->session()->push('cart', array('product' => $product, 'qty' => $item['qty'], 'subtotal' => number_format($subtotal, 2, ',', '.'), 'price' => $price, 'size' => $size, 'color' => $color, 'code' => $item['code']));
                    }
                    $num++;
                }
            }

            return view('web.checkout', compact('total'));
        }

        return redirect()->route('cart.index');
    }

    public function pay(SaleStoreRequest $request) {
        $total=0;
        foreach (session('cart') as $item) {
            $total+=floatval($item['subtotal']);
        }

        // Validación para que no se repita el slug
        $slug="pago";
        $num=0;
        while (true) {
            $count2=Payment::where('slug', $slug)->count();
            if ($count2>0) {
                $slug="pago-".$num;
                $num++;
            } else {
                if (request('method')==1) {
                    $state=2;
                } else {
                    $state=1;
                }
                $data=array('slug' => $slug, 'subject' => 'Compra en línea', 'total' => $total, 'method' => request('method'), 'currency' => 'USD', 'state' => $state, 'user_id' => Auth::user()->id); 
                break;
            }

        }

        $payment=Payment::create($data);

        if (request('method')==1) {
            $data=array('reference' => request('reference'), 'payment_id' => $payment->id);
            Transfer::create($data);
        }

        // Validación para que no se repita el slug
        $slug="pedido";
        $num=0;
        while (true) {
            $count2=Order::where('slug', $slug)->count();
            if ($count2>0) {
                $slug="pedido-".$num;
                $num++;
            } else {
                $data=array('slug' => $slug, 'total' => $total, 'phone' => request('phone'), 'address' => request('address'), 'state' => $state, 'user_id' => Auth::user()->id, 'payment_id' => $payment->id); 
                break;
            }

        }

        $order=Order::create($data);

        foreach (session('cart') as $item) {
            $product=Product::where('slug', $item['product']->slug)->first();
            $size=Size::where('slug', $item['size']->slug)->first();
            $color=Color::where('slug', $item['color']->slug)->first();
            $product_id=(is_null($product)) ? NULL : $product->id;
            $size_id=(is_null($size)) ? NULL : $size->id;
            $color_id=(is_null($color)) ? NULL : $color->id;

            $data=array('price' => $item['price'], 'qty' => $item['qty'], 'subtotal' => number_format(floatval($item['subtotal']), 2, ".", ""), 'product_id' => $product_id, 'size_id' => $size_id, 'color_id' => $color_id, 'order_id' => $order->id);
            Item::create($data)->save();
        }

        if ($order) {
            $request->session()->forget('cart');
            return redirect()->route('orders')->with(['alert' => 'lobibox', 'type' => 'success', 'title' => 'Compra exitosa', 'msg' => 'La compra ha finalizado exitosamente.']);
        } else {
            return redirect()->route('checkout')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Compra fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function orders() {
        $orders=Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        $num=1;
        return view('web.orders', compact('orders', 'num'));
    }

    public function order($slug) {
        $order=Order::where('slug', $slug)->firstOrFail();
        $num=1;
        return view('web.order', compact('order', 'num'));
    }
}