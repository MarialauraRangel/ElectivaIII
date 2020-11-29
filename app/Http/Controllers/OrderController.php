<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $orders=Order::orderBy('id', 'DESC')->get();
        $num=1;
        return view('admin.orders.index', compact('orders', 'num'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug) {
        $order=Order::where('slug', $slug)->firstOrFail();
        $num=1;
        return view('admin.orders.show', compact('order', 'num'));
    }

    public function deactivate(Request $request, $slug) {

        $order=Order::where('slug', $slug)->firstOrFail();
        $order->fill(['state' => "0"])->save();

        if ($order) {
            return redirect()->route('pedidos.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El pedido ha sido rechazado exitosamente.']);
        } else {
            return redirect()->route('pedidos.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, $slug) {

        $order=Order::where('slug', $slug)->firstOrFail();
        $order->fill(['state' => "1"])->save();

        if ($order) {
            return redirect()->route('pedidos.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El pedido ha sido confirmado exitosamente.']);
        } else {
            return redirect()->route('pedidos.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
