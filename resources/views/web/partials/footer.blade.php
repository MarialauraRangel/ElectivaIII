<div class="ftco-footer ftco-section border-dark border-5 pt-5 pb-0">
	<div class="container">
		<div class="row mb-4">
			<div class="col-lg-3 col-12">
				<div class="ftco-footer-widget">
					<a href="{{ route('home') }}">
						<span>ELECTIVA III</span>
					</a>
					<p>Compra tu despensa desde la comodidad de tu hogar en "ELECTIVA III" puedes pasar por tus compras o solicitar que se te envien de una forma facil y segura.</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-12">
				<div class="ftco-footer-widget">
					<h2 class="ftco-heading-2 text-uppercase font-weight-bold">Acerca de</h2>
					<ul class="list-unstyled">
						<li><a href="{{ route('home') }}" class="py-0 d-block font-weight-normal">Inicio</a></li>
					</ul>
				</div>
			</div>

			<div class="col-lg-3 col-md-4 col-sm-6 col-12">
				<div class="ftco-footer-widget">
					<h2 class="ftco-heading-2 text-uppercase font-weight-bold">Categorías</h2>
					<ul class="list-unstyled">
						@foreach($categories_menu as $category)
						<li><a class="py-0 d-block" href="{{ route('shop', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
						@endforeach
					</ul>
				</div>
			</div>

			<div class="col-lg-3 col-md-4 col-sm-6 col-12">
				<div class="ftco-footer-widget">
					<h2 class="ftco-heading-2 text-uppercase font-weight-bold">Tienda</h2>
					<ul class="list-unstyled">
						<li><a href="{{ route('cart.index') }}" class="py-0 d-block">Carrito de compras</a></li>
						@guest
						<li><a href="{{ route('login') }}" class="py-0 d-block">Ingresar</a></li>
						<li><a href="{{ route('register') }}" class="py-0 d-block">Registrarse</a></li>
						@else
						<li><a href="{{ route('web.profile') }}" class="py-0 d-block">Mi Cuenta</a></li>
						<li><a href="{{ route('logout') }}" class="py-0 d-block" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a></li>
						@endguest
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
