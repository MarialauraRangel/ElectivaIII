<?php

namespace App\Http\Controllers;

use App\Product;
use App\Color;
use App\Size;
use App\Item;
use App\Order;
use App\Payment;
use App\Paypal;
use App\Transfer;
use Illuminate\Http\Request;
use App\Http\Requests\SaleStoreRequest;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment as PaymentPaypal;
use PayPal\Exception\PayPalConnectionException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Auth;

class PaymentController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $configPaypal=Config::get('paypal');
        $this->apiContext=new ApiContext(
            new OAuthTokenCredential(
                $configPaypal['client_id'],
                $configPaypal['secret']
            )
        );
    }

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

    public function pay(SaleStoreRequest $request) {
        $total=0;
        foreach (session('cart') as $item) {
            $total+=floatval($item['subtotal']);
        }

        if (request('method')=='1') {
            $data=array('total' => $total, 'fee' => 0.00, 'balance' => $total, 'currency' => 'USD', 'method' => '1', 'reference' => request('reference'), 'phone' => request('phone'), 'address' => request('address'));
            $order=$this->storePayment($data, 'transfer', session('cart'));
            if ($order) {
                $request->session()->forget('cart');
                return redirect()->route('web.profile')->with(['alert' => 'lobibox', 'type' => 'success', 'title' => 'Compra exitosa', 'msg' => 'La compra ha finalizado exitosamente.']);
            } else {
                return redirect()->route('checkout')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Compra fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
            }

        } elseif (request('method')=='2') {
            $response=$this->payWithPaypal($total);
            if ($response['status']) {
                $request->session()->put('aditional_info', array(0 => ['phone' => request('phone'), 'address' => request('address')]));
                return redirect()->away($response['url']);
            } else {
                return redirect()->route('checkout')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Compra fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
            }

        } elseif (request('method')=='3') {
            $data=array('total' => $total, 'fee' => 0.00, 'balance' => $total, 'currency' => 'USD', 'method' => '3', 'phone' => request('phone'), 'address' => request('address'));
            $order=$this->storePayment($total, 'openpay', session('cart'));
            if ($order) {
                $request->session()->forget('cart');
                return redirect()->route('web.profile')->with(['alert' => 'lobibox', 'type' => 'success', 'title' => 'Compra exitosa', 'msg' => 'La compra ha finalizado exitosamente.']);
            } else {
                return redirect()->route('checkout')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Compra fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
            }
        }

        return redirect()->route('checkout')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Compra fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
    }

    public function payWithPaypal($total) {
        $payer=new Payer();
        $payer->setPaymentMethod('paypal');

        $amount=new Amount();
        $amount->setTotal($total);
        $amount->setCurrency('USD');

        $transaction=new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('Compra en supertecpan.com');

        $callbackUrlStatus=url('/paypal/estado');
        $callbackUrlCancel=url('/paypal/cancelado');
        $redirectUrls=new RedirectUrls();
        $redirectUrls->setReturnUrl($callbackUrlStatus)
        ->setCancelUrl($callbackUrlCancel);

        $payment=new PaymentPaypal();
        $payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions(array($transaction))
        ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return array('status' => true, 'url' => $payment->getApprovalLink());
        } catch (PayPalConnectionException $e) {
            return array('status' => false, 'message' => $e->getData());
        }
    }

    public function paypalStatus(Request $request) {
        if (!request()->has('paymentId') || !request()->has('PayerID') || !request()->has('token')) {
            return redirect()->route('checkout')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Pago Fallido', 'msg' => 'No se ha podido realizar el pago con Paypal, intentelo nuevamente.']);
        }

        $payment=PaymentPaypal::get(request('paymentId'), $this->apiContext);
        $execution=new PaymentExecution();
        $execution->setPayerId(request('PayerID'));
        $result=$payment->execute($execution, $this->apiContext);
        $balance=$result->transactions[0]->related_resources[0]->sale->amount->total-$result->transactions[0]->related_resources[0]->sale->transaction_fee->value;
        
        if ($result->getState()==='approved') {
            $data=array('total' => $result->transactions[0]->related_resources[0]->sale->amount->total, 'fee' => $result->transactions[0]->related_resources[0]->sale->transaction_fee->value, 'balance' => $balance, 'currency' => $result->transactions[0]->related_resources[0]->sale->amount->currency, 'method' => '2', 'paypal_payer_id' => request('PayerID'), 'paypal_payment_id' => request('paymentId'), 'phone' => session('aditional_info')[0]['phone'], 'address' => session('aditional_info')[0]['address']);
            $order=$this->storePayment($data, 'paypal', session('cart'));
            if ($order) {
                $request->session()->forget('cart');
                return redirect()->route('web.profile')->with(['alert' => 'lobibox', 'type' => 'success', 'title' => 'Compra exitosa', 'msg' => 'La compra ha finalizado exitosamente.']);
            } else {
                return redirect()->route('checkout')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => '´Compra fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
            }
        } else {
            return redirect()->route('checkout')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => '´Compra fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function paypalCancel(Request $request) {
        return redirect()->route('checkout')->with(['alert' => 'lobibox', 'type' => 'warning', 'title' => 'Pago Cancelado', 'msg' => 'Has cancelado el pago con Paypal.']);
    }

    public function storePayment($data_array, $type, $cart) {
        // Validación para que no se repita el slug
        $slug="pago";
        $num=0;
        while (true) {
            $count2=Payment::where('slug', $slug)->count();
            if ($count2>0) {
                $slug="pago-".$num;
                $num++;
            } else {
                $state=($type=="transfer") ? "2" : "1";
                $data=array('slug' => $slug, 'subject' => 'Compra en supertecpan.com', 'total' => $data_array['total'], 'fee' => $data_array['fee'], 'balance' => $data_array['balance'], 'method' => $data_array['method'], 'currency' => $data_array['currency'], 'state' => $state, 'user_id' => Auth::user()->id);
                break;
            }
        }

        $payment=Payment::create($data);

        if ($type=="transfer") {
            $data=array('reference' => $data_array['reference'], 'payment_id' => $payment->id);
            Transfer::create($data);
        }

        if ($type=="paypal") {
            $data=array('paypal_payer_id' => $data_array['paypal_payer_id'], 'paypal_payment_id' => $data_array['paypal_payment_id'], 'payment_id' => $payment->id);
            Paypal::create($data);
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
                $data=array('slug' => $slug, 'total' => $data_array['total'], 'phone' => $data_array['phone'], 'address' => $data_array['address'], 'state' => $state, 'user_id' => Auth::user()->id, 'payment_id' => $payment->id); 
                break;
            }

        }

        $order=Order::create($data);

        foreach ($cart as $item) {
            $product_id=(!is_null($item['product'])) ? Product::where('slug', $item['product']->slug)->first()->id : NULL;
            $size_id=(!is_null($item['size'])) ? Size::where('slug', $item['size']->slug)->first()->id : NULL;
            $color_id=(!is_null($item['color'])) ? Color::where('slug', $item['color']->slug)->first()->id : NULL;

            $data=array('price' => $item['price'], 'qty' => $item['qty'], 'subtotal' => number_format(floatval($item['subtotal']), 2, ".", ""), 'product_id' => $product_id, 'size_id' => $size_id, 'color_id' => $color_id, 'order_id' => $order->id);
            Item::create($data)->save();
        }

        return $order;
    }
}