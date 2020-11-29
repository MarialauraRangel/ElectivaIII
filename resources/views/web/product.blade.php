@extends('layouts.web')

@section('title', $product->name)

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/lightslider/lightslider.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/lightgallery/lightgallery.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<section class="ftco-section py-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mb-4">
				<ul id="lightgallery-product">
					@forelse($product->images as $image)
					<li href="{{ image_exist('/admins/img/products/', $image->image, false, false) }}" data-thumb="{{ image_exist('/admins/img/products/', $image->image, false, false) }}">
						<img src="{{ image_exist('/admins/img/products/', $image->image, false, false) }}" alt="{{ $product->name }}" />
					</li>
					@empty
					<li href="{{ image_exist('/admins/img/products/', 'image.jpg', false, false) }}" data-thumb="{{ image_exist('/admins/img/products/', 'image.jpg', false, false) }}">
						<img src="{{ image_exist('/admins/img/products/', 'image.jpg', false, false) }}" alt="{{ $product->name }}" />
					</li>
					@endforelse
				</ul>
			</div>

			<div class="col-lg-6">
				<h3>{{ $product->name }} @if($product->discount>0)<span class="badge badge-danger rounded-pill text-white px-2 ml-2">{{ "-".$product->discount."%" }}</span>@endif</h3>
				@if($product->discount==0)
				<p class="h4 text-dark font-weight-bold">{{ "$".number_format($product->price, 2, ",", ".") }}</p>
				@else
				<div class="d-flex justify-content-start">
					<p class="h4 text-dark font-weight-bold mr-3">{{ "$".number_format($product->price-(($product->price*$product->discount)/100), 2, ",", ".") }}</p>
					<p class="h4 text-danger font-weight-bold"><del>{{ "$".number_format($product->price, 2, ",", ".") }}</del></p>
				</div>
				@endif
				<div class="rating d-flex">
					<p class="text-left text-dark">Subcategorías:
						<span>
							@foreach($product->subcategories as $subcategory)
							{{ $subcategory->name }}@if(!$loop->last){{ ", " }}@endif
							@endforeach
						</span>
					</p>
				</div>
				<div class="row">
					@if(isset($product->colors[0]))
					<div class="col-12">
						<div class="form-group">
							<label class="col-form-label">Colores</label>
							<div class="d-flex flex-wrap" id="selectColors">
								@foreach($product->colors as $color)
								<div class="square-color @if($loop->first) active @endif rounded mr-3" style="background-color: {{ $color->color }};" slug="{{ $color->slug }}" data-toggle="tooltip" title="{{ $color->name }}"></div>
								@endforeach
							</div>
						</div>
					</div>
					@endif

					@if(isset($product->sizes[0]))
					<div class="col-lg-6 col-md-6 col-12">
						<div class="form-group">
							<label class="col-form-label">Tallas</label>
							<select class="form-control" id="product-size-cart">
								@foreach($product->sizes as $size)
								<option value="{{ $size->slug }}">{{ $size->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					@endif

					<div class="col-lg-6 col-md-6 col-12">
						<div class="form-group">
							<label class="col-form-label">Cantidad</label>
							<input type="text" class="form-control qty-max number" placeholder="Introduzca una cantidad" min="1" max="{{ $product->qty }}" value="1" price="@if($product->discount==0){{ number_format($product->price, 2, ".", "") }}@else{{ number_format($product->price-(($product->price*$product->discount)/100), 2, ".", "") }}@endif" id="product-qty-cart">
						</div>
					</div>

					<div class="col-12 mt-3">
						<a class="btn btn-dark text-white p-3 mr-3 mb-3" id="product-add-cart" slug="{{ $product->slug }}"><span id="price-product-add-cart">@if($product->discount==0){{ "$".number_format($product->price, 2, ",", ".") }}@else{{ "$".number_format($product->price-(($product->price*$product->discount)/100), 2, ",", ".") }}@endif</span> Agregar al carrito</a>
						<a href="{{ route('shop') }}" class="btn btn-outline-primary p-3 mb-3">Seguir Comprando</a>
					</div>
				</div>
			</div>
			<div class="col-12">
				<p class="h3 text-serif font-weight-bold">Descripción</p>
				<p>{{ $product->description }}</p>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section ftco-no-pt">
	<div class="container">
		<div class="col-12 heading-section text-center">
			<h2 class="text-serif mb-4">Productos Relacionados</h2>
		</div>		
	</div>
	<div class="container">
		<div class="row">
			@foreach($products as $product)
			<div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                <div class="card card-product border-0">
                    <a href="{{ route('product', ['slug' => $product->slug]) }}" class="position-relative overflow-hidden bg-light">
                        <img src="@if(isset($product->images[0])){{ image_exist('/admins/img/products/', $product->images[0]->image) }}@else{{ image_exist('/admins/img/template/', 'imagen.jpg') }}@endif" class="card-img-top zoom" alt="{{ $product->name }}">
                        @if($product->discount>0)
                        <div class="position-absolute top left pl-3 pt-2">
                            <span class="badge badge-danger text-white rounded-pill px-2">{{ "-".$product->discount."%" }}</span>
                        </div>
                        @endif
                    </a>
                    <div class="card-body pb-0">
                        <a href="{{ route('product', ['slug' => $product->slug]) }}"><h5 class="text-dark text-center text-serif">{{ $product->name }}</h5></a>
                        @if($product->discount==0)
                        <div class="text-center">
                            <span class="text-dark font-weight-bold">{{ "$".number_format($product->price, 2, ",", ".") }}</span>
                        </div>
                        @else
                        <div class="d-flex justify-content-center">
                            <span class="text-dark font-weight-bold mr-3">{{ "$".number_format($product->price-(($product->price*$product->discount)/100), 2, ",", ".") }}</span>
                            <span class="text-danger font-weight-bold"><del>{{ "$".number_format($product->price, 2, ",", ".") }}</del></span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
			@endforeach
		</div>
	</div>
</section>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('/admins/vendor/lightslider/lightslider.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admins/vendor/lightgallery/lightgallery.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admins/vendor/lightgallery/lg-thumbnail.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admins/vendor/lightgallery/lg-fullscreen.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admins/vendor/lightgallery/lg-zoom.js') }}"></script>
<script src="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection