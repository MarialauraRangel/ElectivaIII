<div class="hero-wrap hero-bread" @if(!is_null($banner) && !empty($banner)) style="background-image: url({{ image_exist('/admins/img/settings/', $banner) }});" @endif>
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Inicio</a></span> <i class="fa fa-angle-right mx-2"></i> <span>{{ $title }}</span></p>
				<h1 class="mb-0 bread text-serif">{{ $title }}</h1>
			</div>
		</div>
	</div>
</div>