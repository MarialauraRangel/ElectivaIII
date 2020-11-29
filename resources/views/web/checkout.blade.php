@extends('layouts.web')

@section('title', 'Comprar')

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<section class="ftco-section pt-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-12 order-lg-1 order-xl-1 mb-4">
				<div class="cart-detail cart-total bg-light p-3 p-md-4">
					<h3 class="billing-heading text-dark text-serif font-weight-bold mb-4">Detalles del Pedido</h3>
					<hr>
					<p class="d-flex">
						<span class="font-weight-bold">Producto</span>
						<span class="text-right font-weight-bold">Precio</span>
					</p>
					<hr>
					@foreach(session('cart') as $item)
					<p class="d-flex">
						<span>{{ $item['product']->name." x ".$item['qty'] }}</span>
						<span class="text-right">{{ "$".$item['subtotal'] }}</span>
					</p>
					@endforeach
					<hr>
					<p class="d-flex total-price">
						<span class="text-dark font-weight-bold">Total</span>
						<span class="text-right" id="total" total="{{ $total }}">{{ "$".number_format($total, 2, ",", ".") }}</span>
					</p>
				</div>
			</div>

			<div class="col-12">
				@include('admin.partials.errors')
			</div>

			@guest
			<div class="col-lg-6 col-md-6 col-12 order-lg-0 order-xl-0 mb-3">
				<form action="{{ route('login') }}" method="POST" id="formLogin">
					@csrf
					<div class="row align-items-end">
						<div class="col-12">
							<div class="cart-detail cart-total bg-light p-3 p-md-4 bg-white">
								<p class="h4 text-center mt-2">Iniciar Sesión</p>
								<div class="row">
									<div class="form-group col-12">
										<label>Correo Electrónico</label>
										<input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required placeholder="{{ 'ejemplo@gmail.com' }}" value="{{ old('email') }}">
									</div>
									<div class="form-group col-12">
										<label>Contraseña</label>
										<input class="form-control @error('password') is-invalid @enderror" type="password" required name="password" placeholder="********">
									</div>
									<div class="form-group text-center col-12">
										<button class="btn btn-primary rounded" type="submit" action="login">Ingresar</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="col-lg-6 col-md-6 col-12 order-lg-0 order-xl-0 mb-3">
				<form action="{{ route('register') }}" method="POST" id="formRegister">
					@csrf
					<div class="row align-items-end">
						<div class="col-12">
							<div class="cart-detail cart-total bg-light p-3 p-md-4 bg-white">
								<p class="h4 text-center mt-2">Registrate</p>
								<div class="row">
									<div class="form-group col-lg-6 col-md-6 col-12">
										<label>Nombre</label>
										<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required placeholder="Ejm: Juan" value="{{ old('name') }}" autocomplete="name" autofocus>
									</div>
									<div class="form-group col-lg-6 col-md-6 col-12">
										<label>Apellido</label>
										<input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" required placeholder="Ejm: Lopez" value="{{ old('lastname') }}" autocomplete="lastname">
									</div>
									<div class="form-group col-12">
										<label>Correo Electrónico</label>
										<input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required placeholder="{{ 'ejemplo@gmail.com' }}" value="{{ old('email') }}">
									</div>
									<div class="form-group col-lg-6 col-md-6 col-12">
										<label>Contraseña</label>
										<input class="form-control @error('password') is-invalid @enderror" type="password" required name="password" placeholder="********" id="password">
									</div>
									<div class="form-group col-lg-6 col-md-6 col-12">
										<label>Confirmar Contraseña</label>
										<input class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="********">
									</div>
									<div class="form-group text-center col-12">
										<button class="btn btn-primary rounded" type="submit" action="register">Registrate</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			@else
			<div class="col-lg-6 col-12 order-lg-0 order-xl-0 mb-4">
				<form action="{{ route('pay') }}" method="POST" id="formSale" class="billing-form">
					@csrf
					<h3 class="text-serif billing-heading mb-4">Detalles de la Compra</h3>
					<div class="row">
						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="firstname">Nombre y Apellido</label>
							<input type="text" class="form-control" disabled value="{{ Auth::user()->name.' '.Auth::user()->lastname }}">
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="emailaddress">Correo Electrónico</label>
							<input type="text" class="form-control" disabled value="{{ Auth::user()->email }}">
						</div>

						<div class="form-group col-12">
							<label for="streetaddress">Dirección</label>
							<input type="text" name="address" class="form-control" required placeholder="Introduzca su dirección (calle, número de casa, avenida, etc)">
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="phone">Teléfono</label>
							<input type="text" class="form-control" required name="phone" placeholder="Introduzca su número telefónico" @if(!is_null(Auth::user()->phone)) value="{{ Auth::user()->phone }}" @endif>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="method">Método de Pago</label>
							<select class="form-control" required name="method" id="selectMethod">
								<option @if(old('method')==1) selected @endif value="1">Transferencia Bancaria</option>
								<option @if(old('method')==2) selected @endif value="2">Paypal</option>
								<option @if(old('method')==3) selected @endif value="3">Openpay</option>
							</select>
						</div>

						<div class="col-12 @if(!is_null(old('method')) && old('method')!=1) d-none @endif" id="transfer">
							<div class="row">
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label for="reference">Referencia</label>
									<input type="text" class="form-control" required name="reference" placeholder="Introduzca una refencia" @if(!is_null(old('method')) && old('method')!=1) disabled @endif value="{{ old('reference') }}">
								</div>
							</div>
						</div>

						<div class="form-group col-12">
							<button type="submit" action="sale" class="btn btn-dark py-3 px-4">Finalizar Compra</button>
							<a href="{{ route('shop') }}" class="btn btn-primary py-3 px-4">Seguir Comprando</a>
						</div>
					</div>
				</form>
			</div>
			@endguest
		</div>
	</div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection