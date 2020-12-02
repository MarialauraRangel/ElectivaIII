@extends('layouts.web')

@section('title', 'Politícas de Privacidad')

@section('content')

@include('web.partials.banner', ['title' => 'Politícas de Privacidad', 'banner' => $setting->banner])

<section class="ftco-section pt-5">
	<div class="container">
		<div class="row">
			<div class="col-12 h4 text-serif">
				{!! $setting->privacity !!}
			</div>
		</div>
	</div>
</section>

@endsection