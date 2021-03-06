@extends('layouts.web')

@section('title', 'Nosotros')

@section('content')

@include('web.partials.banner', ['title' => 'Nosotros', 'banner' => $setting->banner])

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