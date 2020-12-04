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
					<img src="{{ image_exist('/admins/img/admins/', $payment->user->photo, true) }}" width="90" height="90" alt="Foto de perfil">
					<p class="">{{ $payment->user->name." ".$payment->user->lastname }}</p>
				</div>
				<div class="user-info-list">
					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2">
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Teléfono:</b> {{ $payment->user->phone }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Email:</b> {{ $payment->user->email }}</span>
							</li>
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Estado:</b> {!! state($payment->user->state) !!}</span>
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
								<span class="h6 text-black"><b>Total:</b> {{ "$".number_format($payment->total, 2, ",", ".") }}</span>
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