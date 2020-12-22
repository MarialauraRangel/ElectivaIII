<?php

namespace App\Http\Controllers;

use App\Setting;
use App\State;
use App\Municipality;
use App\Location;
use App\User;
use App\Banner;
use App\Product;
use App\Color;
use App\Size;
use App\Category;
use App\Subcategory;
use App\Coupon;
use App\Order;
use App\Http\Requests\ProfileWebUpdateRequest;
use App\Http\Requests\CartAddProductRequest;
use App\Http\Requests\CartQtyProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;

class WebController extends Controller
{
    private $categories, $setting;

    public function __construct()
    {
        $this->categories=Category::orderBy('name', 'ASC')->get();
        $this->setting=Setting::first();
    }

    public function index() {
        $categories_menu=$this->categories;
        $products=Product::where([['qty', '>', 0], ['state', '1']])->orderBy('id', 'DESC')->limit(8)->get();
        $banners=Banner::where('state', '1')->get();
        $num=0;
        return view('web.home', compact('categories_menu', 'banners', 'products', 'num'));
    }

    public function about() {
        $categories_menu=$this->categories;
        $setting=$this->setting;
        return view('web.about', compact('categories_menu', 'setting'));
    }

    public function shop(Request $request) {
        $categories_menu=$this->categories;
        $setting=$this->setting;
        $categories=Category::all();
        $subcategories=[];
        
        if ($request->has('page')) {
            $offset=24*(request('page')-1);
        } else {
            $offset=0;
        }

        if (is_null(request('category'))) {
            $products=Product::where('qty', '>', 0)->where('state', "1")->orderBy('id', 'DESC')->offset($offset)->limit(24)->get();
            $total=Product::where('qty', '>', 0)->where('state', "1")->limit(200)->get();
        } else {
            $category=Category::where('slug', request('category'))->firstOrFail();
            $subcategories=$category->subcategories;
            if (is_null(request('subcategory'))) {
                $products=$category->subcategories()->with('products')->get()->pluck('products')->collapse()->unique('id')->values()->where('qty', '>', 0)->where('state', "1")->slice($offset)->take(24)->sortByDesc('id');
                $total=$category->subcategories()->with('products')->get()->pluck('products')->collapse()->unique('id')->values()->where('qty', '>', 0)->where('state', "1")->take(200);
            } else {
                $subcategory=Subcategory::where('slug', request('subcategory'))->firstOrFail();
                $products=$subcategory->products->where('qty', '>', 0)->where('state', "1")->slice($offset)->take(24)->sortByDesc('id');
                $total=$subcategory->products->where('qty', '>', 0)->where('state', "1")->take(200);
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
        $pagination=new LengthAwarePaginator($products, $total=count($total), $perPage = 24, $page, ['path' => Paginator::resolveCurrentPath(), 'pageName' => $varPage]);

        return view('web.shop', compact('categories_menu', 'setting', 'products', 'categories', 'subcategories', 'pagination', 'search'));
    }

    public function product($slug) {
        $categories_menu=$this->categories;
        $product=Product::where('slug', $slug)->firstOrFail();
        $products=Product::where([['id', '!=', $product->id], ['qty', '>', 0], ['state', '1']])->limit(4)->get();
        return view('web.product', compact('categories_menu', 'product', 'products'));
    }

    public function contact() {
        $categories_menu=$this->categories;
        $setting=$this->setting;
        return view('web.contact', compact('categories_menu', 'setting'));
    }

    public function terms() {
        $categories_menu=$this->categories;
        $setting=$this->setting;
        return view('web.terms', compact('categories_menu', 'setting'));
    }

    public function privacity() {
        $categories_menu=$this->categories;
        $setting=$this->setting;
        return view('web.privacity', compact('categories_menu', 'setting'));
    }

    public function cart(Request $request) {
        $categories_menu=$this->categories;
        $setting=$this->setting;
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
                        $request->session()->put('cart', array(0 => ['product' => $product, 'qty' => $item['qty'], 'subtotal' => number_format($subtotal, 2, ',', '.'), 'price' => $price, 'discount' => $product->discount, 'size' => $size, 'color' => $color, 'code' => $item['code']]));
                    } else {
                        $request->session()->push('cart', array('product' => $product, 'qty' => $item['qty'], 'subtotal' => number_format($subtotal, 2, ',', '.'), 'price' => $price, 'discount' => $product->discount, 'size' => $size, 'color' => $color, 'code' => $item['code']));
                    }
                    $num++;
                }
            }
        }

        return view('web.cart', compact('categories_menu', 'setting', "products", "total"));
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
        $categories_menu=$this->categories;
        $request->session()->forget('aditional_info');
        $total=0;
        $products=[];
        if ($request->session()->has('cart')) {
            $cart=session('cart');
            $request->session()->forget('cart');
            $num=0;
            foreach ($cart as $item) {
                $product=Product::where('slug', $item['product']->slug)->first();
                if (!is_null($product) && $product->qty>0) {
                    $color=(!is_null($item['color'])) ? Color::where('slug', $item['color']->slug)->first() : NULL;
                    $size=(!is_null($item['size'])) ? Size::where('slug', $item['size']->slug)->first() : NULL;
                    if (!is_null($color)) {
                        $color=($color->products->where('id', $product->id)->isNotEmpty()) ? $color : NULL;
                    }
                    if (!is_null($size)) {
                        $size=($size->products->where('id', $product->id)->isNotEmpty()) ? $size : NULL;
                    }

                    $qty=($product->qty>=$item['qty']) ? $item['qty'] : $product->qty;
                    if ($product->discount>0) {
                        $subtotal=($product->price-(($product->price*$product->discount)/100))*$qty;
                        $price=($product->price-(($product->price*$product->discount)/100));
                    } else {
                        $subtotal=$product->price*$qty;
                        $price=$product->price;
                    }
                    $products[$num]['subtotal']=number_format($subtotal, 2, ',', '.');
                    $total+=$subtotal;

                    if ($num==0) {
                        $request->session()->put('cart', array(0 => ['product' => $product, 'qty' => $qty, 'subtotal' => number_format($subtotal, 2, ',', '.'), 'price' => $price, 'discount' => $product->discount, 'size' => $size, 'color' => $color, 'code' => $item['code']]));
                    } else {
                        $request->session()->push('cart', array('product' => $product, 'qty' => $qty, 'subtotal' => number_format($subtotal, 2, ',', '.'), 'price' => $price, 'discount' => $product->discount, 'size' => $size, 'color' => $color, 'code' => $item['code']));
                    }
                    $num++;
                }
            }
            $subtotal=$total;
            $delivery=($this->setting->max_value_delivery>$subtotal) ? $this->setting->min_delivery_price : 0.00;
            $discount=(session()->has('coupon')) ? ($total*session('coupon')->discount)/100 : 0.00;
            $total=$subtotal+$delivery-$discount;
            $states=State::orderBy('name', 'ASC')->get();
            $municipalities=[];
            $locations=[];
            if (!is_null(Auth::user()->location_id)) {
                $municipalities=Municipality::where('state_id', Auth::user()->location()->withTrashed()->first()->municipality()->withTrashed()->first()->state_id)->get();
                $locations=Location::where('municipality_id', Auth::user()->location()->withTrashed()->first()->municipality_id)->get();
            }

            return view('web.checkout', compact('categories_menu', 'states', 'municipalities', 'locations', 'subtotal', 'delivery', 'discount', 'total'));
        }

        return redirect()->route('cart.index');
    }

    public function couponAdd(Request $request) {
        $coupon=Coupon::where('code', request('coupon'))->first();
        if (!is_null($coupon)) {
            if ($coupon->orders->where('user_id', Auth::id())->count()==0) {
                if ($coupon->limit>$coupon->use) {
                    if (!session()->has('coupon')) {
                        $request->session()->put('coupon', $coupon);
                        return response()->json(["state" => true, "discount" => $coupon->discount]);
                    }

                    return response()->json(["state" => false, "title" => "Límite Alcanzado", "message" => "Ya has usado un cupón para esta compra."]);
                }

                return response()->json(["state" => false, "title" => "Cupón Expirado", "message" => "Este cupón ha expirado."]);
            }

            return response()->json(["state" => false, "title" => "Cupón No Disponible", "message" => "Ya has utilizado este cupón."]);
        }

        return response()->json(["state" => false, "title" => "Cupón Incorrecto", "message" => "Este cupón no es correcto."]);
    }

    public function couponRemove(Request $request) {
        $request->session()->forget('coupon');
        return response()->json(["state" => true]);
    }

    public function profile() {
        $categories_menu=$this->categories;
        $setting=$this->setting;
        $states=State::orderBy('name', 'ASC')->get();
        $municipalities=[];
        $locations=[];
        if (!is_null(Auth::user()->location_id)) {
            $municipalities=Municipality::where('state_id', Auth::user()->location()->withTrashed()->first()->municipality()->withTrashed()->first()->state_id)->get();
            $locations=Location::where('municipality_id', Auth::user()->location()->withTrashed()->first()->municipality_id)->get();
        }
        $orders=Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        $num=1;
        return view('web.profile', compact('categories_menu', 'setting', 'states', 'municipalities', 'locations', 'orders', 'num'));
    }

    public function profileUpdate(ProfileWebUpdateRequest $request) {
        $user=User::where('slug', Auth::user()->slug)->firstOrFail();
        $location=Location::where('id', request('location_id'))->firstOrFail();
        $data=array('name' => request('name'), 'lastname' => request('lastname'), 'phone' => request('phone'), 'location_id' => $location->id, 'street' => request('street'), 'house' => request('house'), 'address' => request('address'));

        if (!is_null(request('password'))) {
            $data['password']=Hash::make(request('password'));
        }

        // Mover imagen a carpeta admins y extraer nombre
        if ($request->hasFile('photo')) {
            $file=$request->file('photo');
            $data['photo']=store_files($file, $slug, '/admins/img/admins/');
        }

        $user->fill($data)->save();

        if ($user) {
            if ($request->hasFile('photo')) {
                Auth::user()->photo=$data['photo'];
            }
            Auth::user()->name=request('name');
            Auth::user()->lastname=request('lastname');
            Auth::user()->phone=request('phone');
            Auth::user()->location_id=$location->id;
            Auth::user()->street=request('street');
            Auth::user()->house=request('house');
            Auth::user()->address=request('address');
            if (!is_null(request('password'))) {
                Auth::user()->password=Hash::make(request('password'));
            }
            return redirect()->back()->with(['alert' => 'lobibox', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El perfil ha sido editado exitosamente.']);
        } else {
            return redirect()->back()->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    public function order($slug) {
        $order=Order::where('slug', $slug)->firstOrFail();
        if ($order->user_id!=Auth::id()) {
            return redirect()->route('web.profile');
        }

        $categories_menu=$this->categories;
        $setting=$this->setting;
        $num=1;
        return view('web.order', compact('categories_menu', 'setting', 'order', 'num'));
    }
}