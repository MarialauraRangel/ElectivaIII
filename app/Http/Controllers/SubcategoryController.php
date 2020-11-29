<?php

namespace App\Http\Controllers;

use App\Category;
use App\Subcategory;
use App\Http\Requests\SubcategoryStoreRequest;
use App\Http\Requests\SubcategoryUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $subcategories=Subcategory::orderBy('id', 'DESC')->get();
        $num=1;
        return view('admin.subcategories.index', compact('subcategories', 'num'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories=Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubcategoryStoreRequest $request) {
        $count=Subcategory::where('name', request('name'))->count();
        $slug=Str::slug(request('name'), '-');
        if ($count>0) {
            $slug=$slug."-".$count;
        }

        // Validación para que no se repita el slug
        $num=0;
        while (true) {
            $count2=Subcategory::where('slug', $slug)->count();
            if ($count2>0) {
                $slug=Str::slug(request('name'), '-')."-".$num;
                $num++;
            } else {
                $category=Category::where('slug', request('category_id'))->firstOrFail();
                $data=array('name' => request('name'), 'slug' => $slug, 'category_id' => $category->id);
                break;
            }
        }

        $subcategory=Subcategory::create($data);

        if ($subcategory) {
            return redirect()->route('subcategorias.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'La subcategoría ha sido registrada exitosamente.']);
        } else {
            return redirect()->route('subcategorias.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug) {
        $subcategory=Subcategory::where('slug', $slug)->firstOrFail();
        $categories=Category::all();
        return view('admin.subcategories.edit', compact("subcategory", "categories"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubcategoryUpdateRequest $request, $slug) {

        $subcategory=Subcategory::where('slug', $slug)->firstOrFail();
        $category=Category::where('slug', request('category_id'))->firstOrFail();
        $data=array('name' => request('name'), 'category_id' => $category->id);

        $subcategory->fill($data)->save();

        if ($subcategory) {
            return redirect()->route('subcategorias.edit', ['slug' => $slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La subcategoría ha sido editada exitosamente.']);
        } else {
            return redirect()->route('subcategorias.edit', ['slug' => $slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $subcategory=Subcategory::where('slug', $slug)->firstOrFail();
        $subcategory->delete();

        if ($subcategory) {
            return redirect()->route('subcategorias.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'La subcategoría ha sido eliminada exitosamente.']);
        } else {
            return redirect()->route('subcategorias.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function addSubcategories(Request $request) {
        $num=0;
        $subcategoriesSelect=[];
        $category=Category::where('slug', request('slug'))->first();
        if (!is_null($category)) {
            $subcategories=Subcategory::where('category_id', $category->id)->orderBy('name', 'DESC')->get();   
            foreach ($subcategories as $subcategory) {
                $subcategoriesSelect[$num]=['slug' => $subcategory->slug, 'name' => $subcategory->name];
                $num++;
            }

            return response()->json(["state" => true, "data" => $subcategoriesSelect]);
        }

        return response()->json(["state" => false]);
    }
}
