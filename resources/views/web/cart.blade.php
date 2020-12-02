@extends('layouts.web')

@section('title', 'Mi Carrito')

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

@include('web.partials.banner', ['title' => 'Mi Carrito', 'banner' => $setting->banner])

<section class="ftco-section pt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="cart-list">
					<table class="table" id="table-cart">
						<thead class="thead-primary">
							<tr class="text-center">
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th>Producto</th>
								<th>Precio</th>
								<th>Cantidad</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($products as $product)
							<tr class="text-center cart-product" code="{{ $product['code'] }}">
								<td class="product-remove">
									<a href="javascript:void(0);" code="{{ $product['code'] }}">
										<span class="fa fa-times"></span>
									</a>
								</td>
								<td class="image-prod">
									<div class="img" style="background-image:url(@if(isset($product['product']->images[0])){{ image_exist('/admins/img/products/', $product['product']->images[0]->image, false, false) }}@else{{ image_exist('/admins/img/template/', 'image.jpg') }}@endif);"></div>
								</td>
								<td class="product-name">
									<h3>{{ $product['product']->name }}@if(!is_null($product['size'])){{ " (Talla ".$product['size']->name.")" }}@endif @if(!is_null($product['color']))<br><i class="fa fa-square" style="color: {{ $product['color']->color }};"></i> {{ $product['color']->name }}@endif</h3>
								</td>
								<td class="price">@if($product['product']->discount>0){{ "$".number_format($product['product']->price-(($product['product']->price*$product['product']->discount)/100), 2, ",", ".") }}@else{{ "$".number_format($product['product']->price, 2, ",", ".") }}@endif</td>
								<td class="quantity">
									<div class="input-group mb-3">
										<input type="text" class="qty form-control" value="{{ $product['qty'] }}" min="1" max="{{ $product['product']->qty }}" code="{{ $product['code'] }}" slug="{{ $product['product']->slug }}" price="@if($product['product']->discount>0){{ $product['product']->price-(($product['product']->price*$product['product']->discount)/100) }}@else{{ $product['product']->price }}@endif">
									</div>
								</td>
								<td class="total" code="{{ $product['code'] }}" slug="{{ $product['product']['slug'] }}">{{ "$".$product['subtotal'] }}</td>
							</tr>
							@empty
							<tr class="text-center">
								<td class="py-3" colspan="6">No hay productos agregados al carrito</td>
							</tr>
							@endforelse
							
							@if(count($products)>0)
							<tr class="text-center">
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>Total:</td>
								<td id="total-cart">{{ "$".number_format($total, 2, ",", ".") }}</td>
							</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 mt-5 text-right">
				<a href="{{ route('checkout') }}" class="btn btn-primary py-3 px-4">Finalizar Compra</a>
			</div>
		</div>
	</div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection