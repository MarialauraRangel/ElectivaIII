<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Srmklive\PayPal\Services\AdaptivePayments;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaymentController extends Controller
{
    /**
     * @var ExpressCheckout
     */
    protected $provider;

    public function __construct()
    {
        $this->provider=new ExpressCheckout();
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

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getExpressCheckout(Request $request)
    {
        $recurring=($request->get('mode')==='recurring') ? true : false;
        $cart=$this->getCheckoutData($recurring);

        try {
            $response=$this->provider->setExpressCheckout($cart, $recurring);

            return redirect($response['paypal_link']);
        } catch (\Exception $e) {
            $invoice = $this->createInvoice($cart, 'Invalid');

            session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
        }
    }

    /**
     * Set cart data for processing payment on PayPal.
     *
     * @param bool $recurring
     *
     * @return array
     */
    protected function getCheckoutData($recurring = false)
    {
        $data = [];

        $order_id = Invoice::all()->count() + 1;

        if ($recurring === true) {
            $data['items'] = [
                [
                    'name'  => 'Monthly Subscription '.config('paypal.invoice_prefix').' #'.$order_id,
                    'price' => 0,
                    'qty'   => 1,
                ],
            ];

            $data['return_url'] = url('/paypal/ec-checkout-success?mode=recurring');
            $data['subscription_desc'] = 'Monthly Subscription '.config('paypal.invoice_prefix').' #'.$order_id;
        } else {
            $data['items'] = [
                [
                    'name'  => 'Product 1',
                    'price' => 9.99,
                    'qty'   => 1,
                ],
                [
                    'name'  => 'Product 2',
                    'price' => 4.99,
                    'qty'   => 2,
                ],
            ];

            $data['return_url'] = url('/paypal/ec-checkout-success');
        }

        $data['invoice_id'] = config('paypal.invoice_prefix').'_'.$order_id;
        $data['invoice_description'] = "Order #$order_id Invoice";
        $data['cancel_url'] = url('/');

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;

        return $data;
    }

    /**
     * Process payment on PayPal.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getExpressCheckoutSuccess(Request $request)
    {
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');

        $cart = $this->getCheckoutData($recurring);

        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            if ($recurring === true) {
                $response = $this->provider->createMonthlySubscription($response['TOKEN'], 9.99, $cart['subscription_desc']);
                if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                    $status = 'Processed';
                } else {
                    $status = 'Invalid';
                }
            } else {
                // Perform transaction on PayPal
                $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
                $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
            }

            $invoice = $this->createInvoice($cart, $status);

            if ($invoice->paid) {
                session()->put(['code' => 'success', 'message' => "Order $invoice->id has been paid successfully!"]);
            } else {
                session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
            }

            return redirect('/');
        }
    }

    /**
     * Create invoice.
     *
     * @param array  $cart
     * @param string $status
     *
     * @return \App\Invoice
     */
    protected function createInvoice($cart, $status)
    {
        $invoice = new Invoice();
        $invoice->title = $cart['invoice_description'];
        $invoice->price = $cart['total'];
        if (!strcasecmp($status, 'Completed') || !strcasecmp($status, 'Processed')) {
            $invoice->paid = 1;
        } else {
            $invoice->paid = 0;
        }
        $invoice->save();

        collect($cart['items'])->each(function ($product) use ($invoice) {
            $item = new Item();
            $item->invoice_id = $invoice->id;
            $item->item_name = $product['name'];
            $item->item_price = $product['price'];
            $item->item_qty = $product['qty'];

            $item->save();
        });

        return $invoice;
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
            $size_id=(!is_null($item['size'])) ? Size::where('slug', $item['size']->slug)->first()->id : NULL;
            $color_id=(!is_null($item['color'])) ? Color::where('slug', $item['color']->slug)->first()->id : NULL;

            $data=array('price' => $item['price'], 'qty' => $item['qty'], 'subtotal' => number_format(floatval($item['subtotal']), 2, ".", ""), 'product_id' => $item['product']->id, 'size_id' => $size_id, 'color_id' => $color_id, 'order_id' => $order->id);
            Item::create($data)->save();
        }

        if ($order) {
            $request->session()->forget('cart');
            return redirect()->route('web.profile')->with(['alert' => 'lobibox', 'type' => 'success', 'title' => 'Compra exitosa', 'msg' => 'La compra ha finalizado exitosamente.']);
        } else {
            return redirect()->route('checkout')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Compra fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
