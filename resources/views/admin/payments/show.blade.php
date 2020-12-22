@extends('layouts.admin')

@section('title', 'Detalle del Pago')

@section('links')
<link href="{{ asset('/admins/css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />
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
					<img src="{{ image_exist('/admins/img/admins/', $payment->user()->withTrashed()->first()->photo, true) }}" width="90" height="90" alt="Foto de perfil">
					<p class="">{{ $payment->user()->withTrashed()->first()->name." ".$payment->user()->withTrashed()->first()->lastname }}</p>
				</div>
				<div class="user-info-list">
					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2">
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Teléfono:</b> @if(!is_null($payment->user()->withTrashed()->first()) && !empty($payment->user()->withTrashed()->first()->phone)){{ $payment->user()->withTrashed()->first()->phone }}@else{{ "No Ingresado" }}@endif</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Email:</b> {{ $payment->user()->withTrashed()->first()->email }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Estado:</b> @if(!is_null($payment->user()->first())){!! state($payment->user->state) !!}@else{!! '<span class="badge badge-danger">Eliminado</span>' !!}@endif</span>
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
					<h3 class="pb-3">Datos del Pago</h3>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2">
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Fecha:</b> {{ $payment->created_at->format("d-m-Y H:i a") }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Método de Pago:</b> {{ methodPayment($payment->method) }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Motivo:</b> {{ $payment->subject }}</span>
							</li>
							@if(!is_null($payment->transfer))
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Codigo de Referencia:</b> {{ $payment->transfer->reference }}</span>
							</li>
							@endif
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Subtotal:</b> {{ "$".number_format($payment->subtotal, 2, ",", ".") }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Envío:</b> {{ "$".number_format($order->payment->delivery, 2, ",", ".") }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Descuento:</b> <b class="text-danger">{{ "-$".number_format($payment->discount, 2, ",", ".") }}</b></span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Comisión:</b> <b class="text-danger">{{ "-$".number_format($payment->fee, 2, ",", ".") }}</b></span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Balance:</b> {{ "$".number_format($payment->balance, 2, ",", ".") }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Estado:</b> {!! statePayment($payment->state) !!}</span>
							</li>
							<li class="contacts-block__item">
								<a href="{{ route('pagos.index') }}" class="btn btn-secondary">Volver</a>
							</li>
						</ul>
					</div>                                    
				</div>
			</div>
		</div>
	</div>
	
</div>

@endsection