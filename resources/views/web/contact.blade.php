@extends('layouts.web')

@section('title', 'Contacto')

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="hero-wrap hero-bread" style="background-image: url('web/images/bg_2.jpg');">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Inicio</a></span> <i class="fa fa-angle-right mx-2"></i> <span>Contacto</span></p>
				<h1 class="mb-0 bread text-serif">Contacto</h1>
			</div>
		</div>
	</div>
</div>

<section class="ftco-section pt-4">
	<div class="container">
		<div class="row">
			@if(!is_null($setting->map) && !empty($setting->map))
			<div class="col-12" id="map-contact">
				{!! $setting->map !!}
			</div>
			@endif
			<div class="col-lg-8 col-12 pt-4">

				@include('admin.partials.errors')

				<form action="{{ route('contact.send') }}" method="POST" class="form" id="formContactWeb">
					@csrf
					<div class="row">
						<div class="form-group col-12">
							<p class="h3 text-serif font-weight-bold">Contactános</p>
						</div>

						<div class="form-group col-xl-6 col-lg-6 col-md-6 col-12">
							<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required placeholder="Introduzca un nombre" value="{{ old('name') }}">
						</div>

						<div class="form-group col-xl-6 col-lg-6 col-md-6 col-12">
							<input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required placeholder="Introduzca un correo electrónico" value="{{ old('email') }}">
						</div>

						<div class="form-group col-12">
							<textarea class="form-control @error('message') is-invalid @enderror" name="message" required placeholder="Introduzca un mensaje" rows="5">{{ old('message') }}</textarea>
						</div>

						<div class="form-group col-12">
							<button type="submit" class="btn btn-primary rounded px-4 py-2" action="contact">Enviar</button>
						</div> 
					</div>
				</form>
			</div>
			<div class="col-lg-4 col-12 pt-4">
				<div class="row">
					@if(!is_null($setting->address) && !empty($setting->address))
					<div class="col-lg-12 col-md-4 col-12">
						<p class="h5 font-weight-bold text-serif"><i class="fa fa-map text-primary mr-2"></i> Dirección</p>
						<p class="text-dark"> {{ $setting->address }}</p>
					</div>
					@endif
					@if(!is_null($setting->phone) && !empty($setting->phone))
					<div class="col-lg-12 col-md-4 col-12">
						<p class="h5 font-weight-bold text-serif"><i class="fa fa-phone-alt text-primary mr-2"></i> Teléfono</p>
						<p class="text-dark"> {{ $setting->phone }}</p>
					</div>
					@endif
					@if(!is_null($setting->email) && !empty($setting->email))
					<div class="col-lg-12 col-md-4 col-12">
						<p class="h5 font-weight-bold text-serif"><i class="fa fa-envelope text-primary mr-2"></i> Email</p>
						<p class="text-dark"> {{ $setting->email }}</p>
					</div>
					@endif
				</div>
			</div>
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