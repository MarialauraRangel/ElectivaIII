<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $coupons=Coupon::orderBy('id', 'DESC')->get();
        $num=1;
        return view('admin.coupons.index', compact('coupons', 'num'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponStoreRequest $request) {
        // Validación para que no se repita el slug
        $code=Str::random(8);
        $slug="cupon-".Str::slug($code, '-');
        while (true) {
            $count2=Coupon::where('slug', $slug)->count();
            if ($count2>0) {
                $slug="cupon-".$num;
                $num++;
            } else {
                $data=array('code' => $code, 'slug' => $slug, 'discount' => request('discount'), 'limit' => request('limit'));
                break;
            }
        }

        $coupon=Coupon::create($data);

        if ($coupon) {
            return redirect()->route('cupones.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'El cupon ha sido registrado exitosamente.']);
        } else {
            return redirect()->route('cupones.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug) {
        $coupon=Coupon::where('slug', $slug)->firstOrFail();
        return view('admin.coupons.edit', compact("coupon"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponUpdateRequest $request, $slug) {

        $coupon=Coupon::where('slug', $slug)->firstOrFail();
        $data=array('discount' => request('discount'), 'limit' => request('limit'));

        $coupon->fill($data)->save();

        if ($coupon) {
            return redirect()->route('cupones.edit', ['slug' => $slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El cupon ha sido editado exitosamente.']);
        } else {
            return redirect()->route('cupones.edit', ['slug' => $slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $coupon=Coupon::where('slug', $slug)->firstOrFail();
        $coupon->delete();

        if ($coupon) {
            return redirect()->route('cupones.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'El cupon ha sido eliminado exitosamente.']);
        } else {
            return redirect()->route('cupones.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
