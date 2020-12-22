@extends('layouts.web')

@section('title', 'Detalles de Compra')

@section('content')

@include('web.partials.banner', ['title' => 'Detalles de Compra', 'banner' => $setting->banner])

<section class="ftco-section bg-light ftco-no-pt ftco-no-pb">
	<div class="container">
		<div class="row">
			<div class="col-12 mt-4">
				<div class="cart-detail p-3 p-md-4 bg-white">
					<div class="row">
						<div class="col-12">
							<p class="h4 text-serif font-weight-bold">Datos del Pedido</p>
						</div>

						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Fecha del Pedido:</strong> {{ $order->created_at->format("d-m-Y H:i a") }}</p>
						</div>

						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Teléfono:</strong> {{ $order->phone }}</p>
						</div>

						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Cantidad de Productos:</strong> {{ $order->items->sum('qty') }}</p>
						</div>

						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Estado del Pedido:</strong> {!! stateOrder($order->state) !!}</p>
						</div>

						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Tipo de Entrega:</strong> {{ typeDelivery($order->type_delivery, 0) }}</p>
						</div>

						@if($order->type_delivery==1)
						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Dirección de Envío:</strong> {{ $order->shipping->location()->withTrashed()->first()->municipality()->withTrashed()->first()->state()->withTrashed()->first()->country()->withTrashed()->first()->name.", ".$order->shipping->location()->withTrashed()->first()->municipality()->withTrashed()->first()->state()->withTrashed()->first()->name.", ".$order->shipping->location()->withTrashed()->first()->municipality()->withTrashed()->first()->name.", ".$order->shipping->location()->withTrashed()->first()->name.", ".$order->shipping->street.", casa número ".$order->shipping->house }}</p>
						</div>

						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Información Adicional de la Dirección:</strong> {{ $order->shipping->address }}</p>
						</div>
						@endif

						<div class="col-12">
							<p class="h4 text-serif font-weight-bold">Datos del Pago</p>
						</div>

						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Método de Pago:</strong> {{ methodPayment($order->payment->method) }}</p>
						</div>

						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Motivo:</strong> {{ $order->payment->subject }}</p>
						</div>

						@if(!is_null($order->payment->transfer))
						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Codigo de Referencia:</strong> {{ $order->payment->transfer->reference }}</p>
						</div>
						@endif

						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Total Pagado:</strong> {{ "$".number_format($order->payment->total, 2, ",", ".") }}</p>
						</div>

						@if(!is_null($order->coupon))
						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Descuento de Cupón:</strong> {{ $order->coupon->discount."%" }}</p>
						</div>
						@endif

						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Estado del Pago:</strong> {!! statePayment($order->payment->state) !!}</p>
						</div>

						<div class="col-12">
							<a href="{{ route('web.profile') }}" class="btn btn-dark rounded">Volver</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section bg-light ftco-no-pt">
	<div class="container">
		<div class="row">
			<div class="col-12 mt-4">
				<div class="cart-detail p-3 p-md-4 bg-white">
					<div class="row">
						<div class="col-12">
							<p class="h4 text-serif font-weight-bold">Productos del Pedido</p>
							<div class="cart-list">
								<table class="table">
									<thead class="thead-primary">
										<tr class="text-center">
											<th>#</th>
											<th>Producto</th>
											<th>Cantidad</th>
											<th>Precio</th>
											<th>Descuento</th>
											<th>Subtotal</th>
										</tr>
									</thead>
									<tbody>
										@foreach($order->items as $item)
										<tr>
											<td>{{ $num++ }}</td>
											<td>{{ $item->product->name }}@if(!is_null($item->size()->withTrashed()->first())){{ " (Talla ".$item->size()->withTrashed()->first()->name.")" }}@endif @if(!is_null($item->color()->withTrashed()->first()))<br><i class="fa fa-square" style="color: {{ $item->color()->withTrashed()->first()->color }};"></i> {{ $item->color()->withTrashed()->first()->color }}@endif</td>
											<td>{{ $item->qty }}</td>
											<td>{{ "$".number_format($item->price, 2, ",", ".") }}</td>
											<td>{{ $item->discount."%" }}</td>
											<td>{{ "$".number_format($item->subtotal, 2, ",", ".") }}</td>
										</tr>
										@endforeach
									</tbody>
									<tfooter>
										<tr class="bg-primary">
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td class="text-white text-uppercase">Envío</td>
											<td class="text-white font-weight-bold">{{ "$".number_format($order->delivery, 2, ",", ".") }}</td>
										</tr>
										<tr class="bg-primary">
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td class="text-white text-uppercase">Descuento</td>
											<td class="text-white font-weight-bold">{{ "- $".number_format($order->discount, 2, ",", ".") }}</td>
										</tr>
										<tr class="bg-primary">
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td class="text-white text-uppercase">Total</td>
											<td class="text-white font-weight-bold">{{ "$".number_format($order->total, 2, ",", ".") }}</td>
										</tr>
									</tfooter>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection