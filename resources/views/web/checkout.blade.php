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
						<span class="text-dark font-weight-bold">Subtotal</span>
						<span class="text-right" id="subtotal" subtotal="{{ $subtotal }}">{{ "$".number_format($subtotal, 2, ",", ".") }}</span>
					</p>
					<hr>
					<p class="d-flex total-price">
						<span class="text-dark font-weight-bold">Envío</span>
						<span class="text-right" id="delivery" delivery="{{ $delivery }}">{{ "$".number_format($delivery, 2, ",", ".") }}</span>
					</p>
					<hr>
					<p class="d-flex total-price">
						<span class="text-dark font-weight-bold">Descuento</span>
						<span class="text-right" id="discount" discount="{{ $discount }}">{{ "- $".number_format($discount, 2, ",", ".") }}</span>
					</p>
					<hr>
					<p class="d-flex total-price">
						<span class="text-dark font-weight-bold">Total</span>
						<span class="text-right" id="total" total="{{ $total }}"  delivery="{{ $delivery }}">{{ "$".number_format($total, 2, ",", ".") }}</span>
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

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="phone">Teléfono<b class="text-danger">*</b></label>
							<input type="text" class="form-control @error('phone') is-invalid @enderror" required name="phone" placeholder="Introduzca su número telefónico" @if(!is_null(Auth::user()->phone)) value="{{ Auth::user()->phone }}" @endif>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="delivery">Método de Entrega<b class="text-danger">*</b></label>
							<select class="form-control" required name="delivery" id="selectDelivery">
								<option @if(old('delivery')==1) selected @endif value="1">Envío</option>
								<option @if(old('delivery')==2) selected @endif value="2">Recoger en Tienda</option>
							</select>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="country">País</label>
							<input type="text" class="form-control" disabled value="Venezuela">
						</div>

						{{-- <div class="form-group col-lg-6 col-md-6 col-12">
							<label for="state_id">Estado</label>
							<select class="form-control @error('state_id') is-invalid @enderror" required name="state_id" id="selectStates">
								<option value="">Seleccione</option>
								@foreach($states as $state)
								<option @if(!is_null(Auth::user()->location_id) && Auth::user()->location()->withTrashed()->first()->municipality()->withTrashed()->first()->state_id==$state->id || old('state_id')==$state->id) selected @endif value="{{ $state->id }}">{{ $state->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="municipality_id">Ciudad / Municipio</label>
							<select class="form-control @error('municipality_id') is-invalid @enderror" required name="municipality_id" id="selectMunicipalities">
								<option value="">Seleccione</option>
								@if(count($municipalities)>0)
								@foreach($municipalities as $municipality)
								<option @if(!is_null(Auth::user()->location_id) && Auth::user()->location()->withTrashed()->first()->municipality_id==$municipality->id) selected @endif value="{{ $municipality->id }}">{{ $municipality->name }}</option>
								@endforeach
								@endif
							</select>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="location_id">Localidad</label>
							<select class="form-control @error('location_id') is-invalid @enderror" required name="location_id" id="selectLocations">
								<option value="">Seleccione</option>
								@if(count($locations)>0)
								@foreach($locations as $location)
								<option @if(!is_null(Auth::user()->location_id) && Auth::user()->location_id==$location->id) selected @endif value="{{ $location->id }}">{{ $location->name }}</option>
								@endforeach
								@endif
							</select>
						</div> --}}

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="street">Calle</label>
							<input type="text" name="street" class="form-control @error('street') is-invalid @enderror" required placeholder="Introduzca su calle" @if(!is_null(Auth::user()->street)) value="{{ Auth::user()->street }}" @endif>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="house">Número de Casa</label>
							<input type="text" name="house" class="form-control number @error('house') is-invalid @enderror" required placeholder="Introduzca su número de casa" @if(!is_null(Auth::user()->house)) value="{{ Auth::user()->house }}" @endif>
						</div>

						<div class="form-group col-12">
							<label for="address">Dirección (Información Adicional)</label>
							<input type="text" name="address" class="form-control @error('address') is-invalid @enderror" required placeholder="Introduzca su dirección" @if(!is_null(Auth::user()->address)) value="{{ Auth::user()->address }}" @endif>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label for="method">Método de Pago<b class="text-danger">*</b></label>
							<select class="form-control @error('method') is-invalid @enderror" required name="method" id="selectMethod">
								<option @if(old('method')==1) selected @endif value="1">Transferencia Bancaria</option>
							</select>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12 @if(!is_null(old('method')) && old('method')!=1) d-none @endif" id="transfer">
							<label for="reference">Referencia</label>
							<input type="text" class="form-control @error('reference') is-invalid @enderror" required name="reference" placeholder="Introduzca una refencia" @if(!is_null(old('method')) && old('method')!=1) disabled @endif value="{{ old('reference') }}">
						</div>

						<div class="form-group col-12" id="div-coupon">
							@if(!session()->has('coupon'))
							<div>
								<a href="javascript:void(0);" id="btn-coupon">Agregar cupón de descuento</a>
								<div class="row" style="display: none;" id="card-add-coupon">
									<div class="form-group col-lg-8 col-md-8 col-12">
										<input type="text" class="form-control" name="coupon" placeholder="Introduzca un coupon" id="input-coupon">
										<p class="text-danger font-weight-bold d-none mb-0">Este campo es requerido</p>
									</div>
									<div class="form-group col-lg-4 col-md-4 col-12">
										<button type="button" class="btn btn-dark rounded w-100" id="btn-add-coupon">Agregar</button>
									</div>
								</div>
							</div>
							@else
							<div class="alert alert-success">
								<p class="mb-1">El cupón de descuendo ha sido agregado</p>
								<a href="javascript:void(0);" id="remove-coupon">Quitar cupón</a>
							</div>
							@endif
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