@extends('layouts.web')

@section('title', 'Compras')

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')
<div class="hero-wrap hero-bread" style="background-image: url('web/images/bg_2.jpg');">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Inicio</a></span> <span>Compras</span></p>
				<h1 class="mb-0 bread">Compras Realizadas</h1>
			</div>
		</div>
	</div>
</div>

<section class="ftco-section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="cart-list">
					<table class="table">
						<thead class="thead-primary">
							<tr class="text-center">
								<th>#</th>
								<th>Cantidad de Productos</th>
								<th>Total</th>
								<th>Pago</th>
								<th>Estado</th>
								<th>Fecha</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@forelse($orders as $order)
							<tr>
								<td>{{ $num++ }}</td>
								<td>{{ $order->items->sum('qty')." Productos" }}</td>
								<td>{{ "$".number_format($order->total, 2, ",", ".") }}</td>
								<td>{!! statePayment($order->payment->state) !!}</td>
								<td>{!! stateOrder($order->state) !!}</td>
								<td>{{ $order->created_at->format('d-m-Y H:i a') }}</td>
								<td class="d-flex justify-content-center">
									<a href="{{ route('order', ['slug' => $order->slug]) }}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i></a>

								</td>
							</tr>
							@empty
							<tr class="text-center">
								<td colspan="6">No ha realizado ninguna compra.</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection