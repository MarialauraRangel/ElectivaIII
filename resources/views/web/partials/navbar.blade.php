<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar ftco-navbar-light shadow px-4">
	<a class="navbar-brand ml-2" href="{{ route('home') }}"><img src="{{ asset('/web/img/logo.png') }}" width="120" alt="Logo"></a>
	<div class="d-flex">
		<div class="d-flex align-items-center position-relative d-lg-none mr-2">
			<a href="{{ route('cart.index') }}" class="btn btn-outline-secondary rounded-circle small"><i class="fa fa-sm fa-shopping-cart"></i></a>
			<div class="position-absolute top-n-10 right-n-5">
				<span class="badge badge-primary rounded-pill count-cart px-2">@if(session()->has('cart')){{ count(session('cart')) }}@else{{ "0" }}@endif</span>
			</div>
		</div>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="fa fa-2x fa-bars"></span>
		</button>
	</div>

	<div class="collapse navbar-collapse" id="ftco-nav">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item {{ active('/') }}"><a href="{{ route('home') }}" class="nav-link">Inicio</a></li>
			<li class="nav-item {{ active('nosotros') }}"><a href="{{ route('about') }}" class="nav-link">Nosotros</a></li>
			<li class="nav-item dropdown">
				<a href="javascript:void(0);" class="nav-link dropdown-toggle" id="category-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categorías</a>
				<div class="dropdown-menu dropdown-user" aria-labelledby="category-dropdown">
					@foreach($categories_menu as $category)
					<a class="dropdown-item" href="{{ route('shop', ['category' => $category->slug]) }}">{{ $category->name }}</a>
					@endforeach
				</div>
			</li>
			<li class="nav-item {{ active('tienda') }}"><a href="{{ route('shop') }}" class="nav-link">Tienda</a></li>
			<li class="nav-item {{ active('contacto') }}"><a href="{{ route('contact') }}" class="nav-link">Contacto</a></li>
			<li class="nav-item {{ active('carrito') }} align-items-center position-relative d-none d-lg-flex mr-2">
				<a href="{{ route('cart.index') }}" class="btn btn-outline-secondary rounded-circle small"><i class="fa fa-sm fa-shopping-cart"></i></a>
				<div class="position-absolute top right-n-5 pt-1">
					<span class="badge badge-primary rounded-pill count-cart px-2">@if(session()->has('cart')){{ count(session('cart')) }}@else{{ "0" }}@endif</span>
				</div>
			</li>
			@guest
			<li class="nav-item d-none d-lg-flex align-items-center mr-2">
				<a href="{{ route('login') }}" class="btn btn-primary text-uppercase px-3">Ingresar</a>
			</li>
			<li class="nav-item d-none d-lg-flex align-items-center">
				<a href="{{ route('register') }}" class="btn btn-primary text-uppercase px-3">Registrarse</a>
			</li>
			<li class="nav-item d-lg-none"><a href="{{ route('login') }}" class="nav-link">Ingresar</a></li>
			<li class="nav-item d-lg-none"><a href="{{ route('register') }}" class="nav-link">Registrarse</a></li>
			@else
			<li class="nav-item {{ active('perfil') }} dropdown">
				<a href="javascript:void(0);" class="nav-link dropdown-toggle" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
				<div class="dropdown-menu dropdown-user" aria-labelledby="dropdown05">
					@if(Auth::user()->type==1)
					<a class="dropdown-item" href="{{ route('admin') }}">Panel Administrativo</a>
					@endif
					<a class="dropdown-item {{ active('perfil') }}" href="{{ route('web.profile') }}">Mi Cuenta</a>
					<hr class="w-75 my-0">
					<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
						@csrf
					</form>
				</div>
			</li>
			@endguest
		</ul>
	</div>
</nav>