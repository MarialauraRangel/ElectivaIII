@extends('layouts.web')

@section('title', 'Términos y Condiciones')

@section('content')

@include('web.partials.banner', ['title' => 'Términos y Condiciones', 'banner' => $setting->banner])

<section class="ftco-section pt-5">
	<div class="container">
		<div class="row">
			<div class="col-12 h4 text-serif">
				{!! $setting->terms !!}
			</div>
		</div>
	</div>
</section>

@endsection