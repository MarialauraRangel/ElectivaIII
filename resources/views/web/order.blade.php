@extends('layouts.web')

@section('title', 'Detalles de Compra')

@section('content')

@include('web.partials.banner', ['title' => 'Detalles de Compra', 'banner' => $setting->banner])

<section class="ftco-section bg-light ftco-no-pt">
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
							<p><strong>Dirección:</strong> {{ $order->address }}</p>
						</div>
						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Cantidad de Productos:</strong> {{ $order->items->sum('qty') }}</p>
						</div>
						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Estado del Pedido:</strong> {!! stateOrder($order->state) !!}</p>
						</div>

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
							<p><strong>Total:</strong> {{ "$".number_format($order->payment->total, 2, ",", ".") }}</p>
						</div>
						<div class="col-lg-6 col-md-6 col-12">
							<p><strong>Estado del Pago:</strong> {!! statePayment($order->payment->state) !!}</p>
						</div>

						<div class="col-12">
							<a href="{{ route('web.profile') }}" class="btn btn-dark">Volver</a>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12 mt-4">
				<div class="cart-list">
					<table class="table">
						<thead class="thead-primary">
							<tr class="text-center">
								<th>#</th>
								<th>Producto</th>
								<th>Cantidad</th>
								<th>Precio</th>
								<th>Subtotal</th>
							</tr>
						</thead>
						<tbody>
							@foreach($order->items as $item)
							<tr>
								<td>{{ $num++ }}</td>
								<td>{{ $item->product->name }}@if(!is_null($item->size)){{ " (Talla ".$item->size->name.")" }}@endif @if(!is_null($item->color))<br><i class="fa fa-square" style="color: {{ $item->color->color }};"></i> {{ $item->color->color }}@endif</td>
								<td>{{ $item->qty }}</td>
								<td>{{ "$".number_format($item->price, 2, ",", ".") }}</td>
								<td>{{ "$".number_format($item->subtotal, 2, ",", ".") }}</td>
							</tr>
							@endforeach
						</tbody>
						<tfooter>
							<tr class="bg-primary">
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
</section>

@endsection

@section('script')
<script src="{{ asset('/admins/vendors/datatables/jquery.dataTables.min.js') }}"></script>
@endsection