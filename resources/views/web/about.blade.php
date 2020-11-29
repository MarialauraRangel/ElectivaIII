@extends('layouts.web')

@section('title', 'Nosotros')

@section('content')

<div class="hero-wrap hero-bread" style="background-image: url('web/images/bg_2.jpg');">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Inicio</a></span> <i class="fa fa-angle-right mx-2"></i> <span>Nosotros</span></p>
				<h1 class="mb-0 bread text-serif">Nosotros</h1>
			</div>
		</div>
	</div>
</div>

<section class="ftco-section pt-5">
	<div class="container">
		<div class="row">
			<div class="col-12 h4 text-serif">
				{!! $setting->about !!}
			</div>
		</div>
	</div>
</section>

@endsection