<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use App\Subcategory;
use App\Product;
use App\Setting;
use App\Http\Requests\DiscountUpdateRequest;
use App\Http\Requests\DeliveryUpdateRequest;
use App\Http\Requests\AboutUpdateRequest;
use App\Http\Requests\TermUpdateRequest;
use App\Http\Requests\PoliticUpdateRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Requests\ContactStoreRequest;
use Illuminate\Http\Request;
use App\Notifications\MessageContactNotification;

use App\Imports\ProductsImport;
use Illuminate\Support\Str;
use Excel;
use App\Disease;
use App\Operation;

class SettingController extends Controller
{
    public function editDiscounts() {
        $setting=Setting::where('id', 1)->firstOrFail();
        $categories=Category::all();
        $subcategories=Subcategory::all();
        return view('admin.settings.discounts', compact("setting", "categories", "subcategories"));
    }

    public function updateDiscounts(DiscountUpdateRequest $request) {
        $setting=Setting::where('id', 1)->firstOrFail();

        if (request('type')==1) {
            $products=Product::all();
            foreach ($products as $product) {
                $product->fill(['discount' => request('discount')])->save();
            }
            $setting->fill($request->all())->save();
        } elseif (request('type')==2) {
            foreach (request("category_id") as $category) {
                $category=Category::where('slug', $category)->first();
                if (!is_null($category)) {
                    foreach ($category->subcategories()->with('products')->get()->pluck('products')->collapse()->unique('id')->values() as $product) {
                        $product->fill(['discount' => request('category_discount')])->save();
                    }
                }
            }
        } else {
            foreach (request("subcategory_id") as $subcategory) {
                $subcategory=Subcategory::where('slug', $subcategory)->first();
                if (!is_null($subcategory)) {
                    foreach ($subcategory->products as $product) {
                        $product->fill(['discount' => request('subcategory_discount')])->save();
                    }
                }
            }
        }

        if ($setting) {
            return redirect()->route('descuentos.edit')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'Los descuentos han sido editados exitosamente.']);
        } else {
            return redirect()->route('descuentos.edit')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    public function editDeliveries() {
        $setting=Setting::where('id', 1)->firstOrFail();
        return view('admin.settings.deliveries', compact("setting"));
    }

    public function updateDeliveries(DeliveryUpdateRequest $request) {
        $setting=Setting::where('id', 1)->firstOrFail();
        $setting->fill($request->all())->save();

        if ($setting) {
            return redirect()->route('envios.edit')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'Los envíos han sido editados exitosamente.']);
        } else {
            return redirect()->route('envios.edit')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    public function editAbouts() {
        $setting=Setting::where('id', 1)->firstOrFail();
        return view('admin.settings.abouts', compact("setting"));
    }

    public function updateAbouts(AboutUpdateRequest $request) {

        $setting=Setting::where('id', 1)->firstOrFail();
        $setting->fill($request->all())->save();

        if ($setting) {
            return redirect()->route('nosotros.edit')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La sección nosotros ha sido editada exitosamente.']);
        } else {
            return redirect()->route('nosotros.edit')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    public function editTerms() {
        $setting=Setting::where('id', 1)->firstOrFail();
        return view('admin.settings.terms', compact("setting"));
    }

    public function updateTerms(TermUpdateRequest $request) {

        $setting=Setting::where('id', 1)->firstOrFail();
        $setting->fill($request->all())->save();

        if ($setting) {
            return redirect()->route('terminos.edit')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'Los términos y condiciones han sido editados exitosamente.']);
        } else {
            return redirect()->route('terminos.edit')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    public function editPolitics() {
        $setting=Setting::where('id', 1)->firstOrFail();
        return view('admin.settings.politics', compact("setting"));
    }

    public function updatePolitics(PoliticUpdateRequest $request) {

        $setting=Setting::where('id', 1)->firstOrFail();
        $setting->fill($request->all())->save();

        if ($setting) {
            return redirect()->route('politicas.edit')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'Las políticas han sido editadas exitosamente.']);
        } else {
            return redirect()->route('politicas.edit')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    public function editContacts() {
        $setting=Setting::where('id', 1)->firstOrFail();
        return view('admin.settings.contacts', compact("setting"));
    }

    public function updateContacts(ContactUpdateRequest $request) {
        $setting=Setting::where('id', 1)->firstOrFail();
        $data=array('map' => request('map'), 'phone' => request('phone'), 'email' => request('email'), 'address' => request('address'), 'facebook' => request('facebook'), 'twitter' => request('twitter'), 'instagram' => request('instagram'));

        // Mover imagen a carpeta settings y extraer nombre
        if ($request->hasFile('banner')) {
            $file=$request->file('banner');
            $data['banner']=store_files($file, 'banner-secundario', '/admins/img/settings/');
        }

        $setting->fill($data)->save();

        if ($setting) {
            return redirect()->route('contactos.edit')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'Los ajustes de contacto han sido editados exitosamente.']);
        } else {
            return redirect()->route('contactos.edit')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    public function send(ContactStoreRequest $request) {
        $setting=Setting::where('id', 1)->firstOrFail();

        $contact=new User;
        $contact->email=$setting->email;
        $contact->name=request('name');
        $contact->email_contact=request('email');
        $contact->message= request('message');
        $contact->notify(new MessageContactNotification());

        if ($contact) {
            return redirect()->back()->with(['alert' => 'lobibox', 'type' => 'success', 'title' => 'Envio exitoso', 'msg' => 'El mensaje ha sido enviado exitosamente.']);
        } else {
            return redirect()->back()->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Envio fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }





















    public function importProducts() {
        return view('admin.settings.imports.products');
    }

    public function importProductsData(Request $request) {
        $max=ini_get('max_execution_time');
        ini_set('max_execution_time', 360);

        $collection=Excel::toCollection(new ProductsImport, request()->file('excel'));

        $num=1;
        $data="";

        // dd($collection[0]->whereNotNull(0));

        // foreach ($collection[0] as $item) {

            // Productos
            // if($item[0]!="CODIGO") {
                // dd($item);

                // $count=Product::where('name', $item[1])->count();
                // $slug=Str::slug($item[1], '-');
                // if ($count>0) {
                //     $slug=$slug."-".$count;
                // }

                // // Validación para que no se repita el slug
                // $num2=0;
                // while (true) {
                //     $count2=Product::where('slug', $slug)->count();
                //     if ($count2>0) {
                //         $slug=Str::slug($item[1], '-')."-".$num2;
                //         $num2++;
                //     } else {
                //         break;
                //     }
                // }

                // $data.="['id' => ".$num.", 'name' => '".Str::ucfirst($item[1])."', 'slug' => '".$slug."', 'code' => '".$item[0]."', 'description' => 'description-product', 'qty' => 100, 'price' => ".$item[2].", 'discount' => ".$item[6].", 'min' => ".$item[11].", 'max' => ".$item[12].", 'state' => '1'],<br>";
                // $num++;
            // }
        // }

        // ini_set('max_execution_time', $max);

        return $data;



        

        // ['id' => 1, 'name' => 'Camisa de verano', 'slug' => 'camisa-de-verano', 'code' => '15GHHH', 'description' => $description, 'qty' => 100, 'price' => 100.00, 'discount' => 0, 'min' => 0, 'max' => 0, 'state' => '1'],

        // if ($collection) {
        //     return redirect()->route('importar.products')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'Los ajustes de contacto han sido editados exitosamente.']);
        // } else {
        //     return redirect()->route('importar.products')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        // }
    }
}
