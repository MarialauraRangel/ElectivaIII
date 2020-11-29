<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $payments=Payment::orderBy('id', 'DESC')->get();
        $num=1;
        return view('admin.payments.index', compact('payments', 'num'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug) {
        $payment=Payment::where('slug', $slug)->firstOrFail();
        return view('admin.payments.show', compact('payment'));
    }

    public function deactivate(Request $request, $slug) {

        $payment=Payment::where('slug', $slug)->firstOrFail();
        $payment->fill(['state' => "0"])->save();

        if ($payment) {
            return redirect()->route('pagos.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El pago ha sido rechazado exitosamente.']);
        } else {
            return redirect()->route('pagos.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, $slug) {

        $payment=Payment::where('slug', $slug)->firstOrFail();
        $payment->fill(['state' => "1"])->save();

        if ($payment) {
            return redirect()->route('pagos.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El pago ha sido confirmado exitosamente.']);
        } else {
            return redirect()->route('pagos.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
