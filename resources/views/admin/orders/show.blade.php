@extends('layouts.admin')

@section('title', 'Detalle del Pedido')

@section('links')
<link href="{{ asset('/admins/css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/dt-global_style.css') }}">
@endsection

@section('content')

<div class="row">
	<div class="col-xl-5 col-lg-5 col-md-6 col-12 layout-top-spacing">

		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area">
				<div class="d-flex justify-content-between">
					<h3 class="pb-3">Datos del Usuario</h3>
				</div>
				<div class="text-center user-info">
					<img src="{{ image_exist('/admins/img/admins/', $order->user()->withTrashed()->first()->photo, true) }}" width="90" height="90" alt="Foto de perfil">
					<p class="">{{ $order->user()->withTrashed()->first()->name." ".$order->user()->withTrashed()->first()->lastname }}</p>
				</div>
				<div class="user-info-list">
					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2">
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Teléfono:</b> @if(!is_null($order->user()->withTrashed()->first()) && !empty($order->user()->withTrashed()->first()->phone)){{ $order->user()->withTrashed()->first()->phone }}@else{{ $order->phone }}@endif</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Email:</b> {{ $order->user()->withTrashed()->first()->email }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Estado:</b> @if(!is_null($order->user()->first())){!! state($order->user->state) !!}@else{!! '<span class="badge badge-danger">Eliminado</span>' !!}@endif</span>
							</li>
						</ul>
					</div>                                    
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-7 col-lg-7 col-md-6 col-12 layout-top-spacing">

		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area">
				<div class="d-flex justify-content-between">
					<h3 class="pb-3">Datos del Pedido</h3>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2">
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Fecha:</b> {{ $order->created_at->format("d-m-Y H:i a") }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Teléfono:</b> {{ $order->phone }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Cantidad de Productos:</b> {{ $order->items->sum('qty') }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Total Pagado:</b> {{ "$".number_format($order->total, 2, ",", ".") }}</span>
							</li>
							@if(!is_null($order->coupon))
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Cupón de Descuento:</b> {{ $order->coupon->discount."%" }}</span>
							</li>
							@endif
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Estado:</b> {!! stateOrder($order->state) !!}</span>
							</li>
							<div class="col-lg-6 col-md-6 col-12">
								<p><strong>Tipo de Entrega:</strong> {{ typeDelivery($order->type_delivery, 0) }}</p>
							</div>
							@if($order->type_delivery==1)
							<div class="col-lg-6 col-md-6 col-12">
								<p><strong>Dirección de Envío:</strong> {{ $order->shipping->location()->withTrashed()->first()->municipality()->withTrashed()->first()->state()->withTrashed()->first()->country()->withTrashed()->first()->name.", ".$order->shipping->location()->withTrashed()->first()->municipality()->withTrashed()->first()->state()->withTrashed()->first()->name.", ".$order->shipping->location()->withTrashed()->first()->municipality()->withTrashed()->first()->name.", ".$order->shipping->location()->withTrashed()->first()->name.", ".$order->shipping->street.", casa número ".$order->shipping->house }}</p>
							</div>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Información Adicional de la Dirección:</b> {{ $order->shipping->address }}</span>
							</li>
							@endif
							<li class="contacts-block__item">
								<a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Volver</a>
							</li>
						</ul>
					</div>                                    
				</div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-top-spacing">

		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area">
				<div class="d-flex justify-content-between">
					<h3 class="pb-3">Productos del Pedido</h3>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2">
							<li class="contacts-block__item">
								<div class="table-responsive">
									<table class="table table-normal table-hover">
										<thead>
											<tr>
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
												<td>{{ $item->product()->withTrashed()->first()->name }}@if(!is_null($item->size()->withTrashed()->first())){{ " (Talla ".$item->size()->withTrashed()->first()->name.")" }}@endif @if(!is_null($item->color()->withTrashed()->first()))<br><i class="fa fa-square" style="color: {{ $item->color()->withTrashed()->first()->color }};"></i> {{ $item->color()->withTrashed()->first()->color }}@endif</td>
												<td>{{ $item->qty }}</td>
												<td>{{ "$".number_format($item->price, 2, ",", ".") }}</td>
												<td>{{ $item->discount."%" }}</td>
												<td>{{ "$".number_format($item->subtotal, 2, ",", ".") }}</td>
											</tr>
											@endforeach
										</tbody>
										<tfooter>
											<tr>
												<td colspan="5" class="text-primary text-uppercase font-weight-bold">Envío</td>
												<td class="text-primary text-uppercase font-weight-bold">{{ "$".number_format($order->delivery, 2, ",", ".") }}</td>
											</tr>
											<tr>
												<td colspan="5" class="text-primary text-uppercase font-weight-bold">Descuento</td>
												<td class="text-primary text-uppercase font-weight-bold">{{ "-$".number_format($order->discount, 2, ",", ".") }}</td>
											</tr>
											<tr>
												<td colspan="5" class="text-primary text-uppercase font-weight-bold">Total</td>
												<td class="text-primary text-uppercase font-weight-bold">{{ "$".number_format($order->total, 2, ",", ".") }}</td>
											</tr>
										</tfooter>
									</table>
								</div>
							</li>
						</ul>
					</div>                                    
				</div>
			</div>
		</div>
	</div>

	@if(!is_null($order->payment))
	<div class="col-xl-5 col-lg-5 col-md-6 col-12 layout-top-spacing">

		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area">
				<div class="d-flex justify-content-between">
					<h3 class="pb-3">Datos del Pago</h3>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2">
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Fecha:</b> {{ $order->payment->created_at->format("d-m-Y H:i a") }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Método de Pago:</b> {{ methodPayment($order->payment->method) }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Motivo:</b> {{ $order->payment->subject }}</span>
							</li>
							@if(!is_null($order->payment->transfer))
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Codigo de Referencia:</b> {{ $order->payment->transfer->reference }}</span>
							</li>
							@endif
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Subtotal:</b> {{ "$".number_format($order->payment->subtotal, 2, ",", ".") }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Envío:</b> {{ "$".number_format($order->payment->delivery, 2, ",", ".") }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Descuento:</b> <b class="text-danger">{{ "-$".number_format($order->payment->discount, 2, ",", ".") }}</b></span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Comisión:</b> <b class="text-danger">{{ "-$".number_format($order->payment->fee, 2, ",", ".") }}</b></span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Balance:</b> {{ "$".number_format($order->payment->balance, 2, ",", ".") }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Estado:</b> {!! statePayment($order->payment->state) !!}</span>
							</li>
						</ul>
					</div>                                    
				</div>
			</div>
		</div>
	</div>
	@endif
</div>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/table/datatable/datatables.js') }}"></script>
@endsection