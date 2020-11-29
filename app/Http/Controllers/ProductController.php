<?php

namespace App\Http\Controllers;

use App\Category;
use App\Subcategory;
use App\Product;
use App\Image;
use App\Color;
use App\Size;
use App\ProductSubcategory;
use App\ColorProduct;
use App\ProductSize;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $products=Product::orderBy('id', 'DESC')->get();
        $num=1;
        return view('admin.products.index', compact('products', 'num'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $subcategories=Subcategory::all();
        $colors=Color::all();
        $sizes=Size::all();
        return view('admin.products.create', compact('subcategories', 'colors', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request) {
        $count=Product::where('name', request('name'))->count();
        $slug=Str::slug(request('name'), '-');
        if ($count>0) {
            $slug=$slug."-".$count;
        }

        // Validación para que no se repita el slug
        $num=0;
        while (true) {
            $count2=Product::where('slug', $slug)->count();
            if ($count2>0) {
                $slug=Str::slug(request('name'), '-')."-".$num;
                $num++;
            } else {

                $data=array('name' => request('name'), 'slug' => $slug, 'code' => request('code'), 'description' => request('description'), 'qty' => request('qty'), 'price' => request('price'), 'discount' => request('discount'));
                break;
            }
        }

        $product=Product::create($data);

        // Mover imagen a carpeta products y extraer nombre
        if ($request->has('files')) {
            foreach (request('files') as $file) {
                Image::create(['image' => $file, 'product_id' => $product->id])->save();
            }
        }

        if (!is_null(request('subcategory_id')) && is_array(request('subcategory_id'))) {
            foreach (request('subcategory_id') as $value) {
                $subcategory=Subcategory::where('slug', $value)->first();
                if (!is_null($subcategory)) {
                    $data=array('product_id' => $product->id, 'subcategory_id' => $subcategory->id);
                    ProductSubcategory::create($data);
                }
            }
        }

        if (!is_null(request('size_id')) && is_array(request('size_id'))) {
            foreach (request('size_id') as $value) {
                $size=Size::where('slug', $value)->first();
                if (!is_null($size)) {
                    $data=array('product_id' => $product->id, 'size_id' => $size->id);
                    ProductSize::create($data);
                }
            }
        }

        if (!is_null(request('color_id')) && is_array(request('color_id'))) {
            foreach (request('color_id') as $value) {
                $color=Color::where('slug', $value)->first();
                if (!is_null($color)) {
                    $data=array('product_id' => $product->id, 'color_id' => $color->id);
                    ColorProduct::create($data);
                }
            }
        }

        if ($product) {
            return redirect()->route('productos.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'El producto ha sido registrado exitosamente.']);
        } else {
            return redirect()->route('productos.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug) {
        $product=Product::where('slug', $slug)->firstOrFail();
        $subcategories=Subcategory::all();
        $colors=Color::all();
        $sizes=Size::all();
        $num=0;
        return view('admin.products.edit', compact("subcategories", "product", "colors", "sizes", "num"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $slug) {

        $product=Product::where('slug', $slug)->firstOrFail();
        $data=array('name' => request('name'), 'code' => request('code'), 'description' => request('description'), 'qty' => request('qty'), 'price' => request('price'), 'discount' => request('discount'));

        $product->fill($data)->save();

        $categories=ProductSubcategory::where('product_id', $product->id)->delete();
        $sizes=ProductSize::where('product_id', $product->id)->delete();
        $colors=ColorProduct::where('product_id', $product->id)->delete();

        if (!is_null(request('subcategory_id')) && is_array(request('subcategory_id'))) {
            foreach (request('subcategory_id') as $value) {
                $subcategory=Subcategory::where('slug', $value)->first();
                if (!is_null($subcategory)) {
                    $data=array('product_id' => $product->id, 'subcategory_id' => $subcategory->id);
                    ProductSubcategory::create($data);
                }
            }
        }

        if (!is_null(request('size_id')) && is_array(request('size_id'))) {
            foreach (request('size_id') as $value) {
                $size=Size::where('slug', $value)->first();
                if (!is_null($size)) {
                    $data=array('product_id' => $product->id, 'size_id' => $size->id);
                    ProductSize::create($data);
                }
            }
        }

        if (!is_null(request('color_id')) && is_array(request('color_id'))) {
            foreach (request('color_id') as $value) {
                $color=Color::where('slug', $value)->first();
                if (!is_null($color)) {
                    $data=array('product_id' => $product->id, 'color_id' => $color->id);
                    ColorProduct::create($data);
                }
            }
        }

        if ($product) {
            return redirect()->route('productos.edit', ['slug' => $slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El producto ha sido editado exitosamente.']);
        } else {
            return redirect()->route('productos.edit', ['slug' => $slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $product=Product::where('slug', $slug)->firstOrFail();
        $product->delete();

        if ($product) {
            return redirect()->route('productos.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'El producto ha sido eliminado exitosamente.']);
        } else {
            return redirect()->route('productos.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, $slug) {

        $product=Product::where('slug', $slug)->firstOrFail();
        $product->fill(['state' => "0"])->save();

        if ($product) {
            return redirect()->route('productos.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El producto ha sido desactivado exitosamente.']);
        } else {
            return redirect()->route('productos.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, $slug) {
        $product=Product::where('slug', $slug)->firstOrFail();
        $product->fill(['state' => "1"])->save();

        if ($product) {
            return redirect()->route('productos.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El producto ha sido activado exitosamente.']);
        } else {
            return redirect()->route('productos.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function file(Request $request) {
        if ($request->hasFile('file')) {
            $file=$request->file('file');
            $name=time().'_'.Str::slug($file->getClientOriginalName(), "-").".".$file->getClientOriginalExtension();
            $file->move(public_path().'/admins/img/products/', $name);
            
            return response()->json(['status' => true, 'name' => $name]);
        }

        return response()->json(['status' => false]);
    }

    public function fileEdit(Request $request) {
        $product=Product::where('slug', request('slug'))->first();
        if (!is_null($product)) {
            if ($request->hasFile('file')) {
                $file=$request->file('file');
                $name=time().'_'.$product->slug.".".$file->getClientOriginalExtension();
                $file->move(public_path().'/admins/img/products/', $name);

                $image=Image::create(['product_id' => $product->id, 'image' => $name]);
                if ($image) {
                    return response()->json(['status' => true, 'name' => $name, 'slug' => $product->slug]);
                }
            }
        }

        return response()->json(['status' => false]);
    }

    public function fileDestroy(Request $request) {
        $product=Product::where('slug', request('slug'))->first();
        if (!is_null($product)) {
            $image=Image::where('product_id', $product->id)->where('image', request('url'))->first();
            if (!is_null($image)) {
                $image->delete();

                if ($image) {
                    if (file_exists(public_path().'/admins/img/products/'.request('url'))) {
                        unlink(public_path().'/admins/img/products/'.request('url'));
                    }

                    return response()->json(['status' => true]);
                }
            }
        }

        return response()->json(['status' => false]);
    }
}
