@extends('layouts.web')

@section('title', 'Perfil')

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/dropify/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

@include('web.partials.banner', ['title' => 'Perfil', 'banner' => $setting->banner])

<section class="ftco-section pt-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4 col-12">
				<div class="card border-primary mb-3">
					<div class="card-body">
						<div class="d-flex">
							<img src="{{ image_exist('/admins/img/admins/', Auth::user()->photo, true) }}" width="120" height="120" class="bg-white rounded-circle shadow-blue mx-auto" alt="{{ Auth::user()->name." ".Auth::user()->lastname }}">	
						</div>
						<p class="h4 text-center mt-2 mb-0">{{ Auth::user()->name." ".Auth::user()->lastname }}</p>
						<p class="text-center text-muted mt-2 mb-0">Email: {{ Auth::user()->email }}</p>
						@if(!is_null(Auth::user()->phone) && !empty(Auth::user()->phone))
						<p class="text-center text-muted mt-2 mb-0">Teléfono: {{ Auth::user()->phone }}</p>
						@endif
					</div>
				</div>
			</div>

			<div class="col-lg-9 col-md-8 col-12">
				<ul class="nav nav-tabs mb-3" id="animateLine" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="animated-underline-shopping-tab" data-toggle="tab" href="#animated-underline-shopping" role="tab" aria-controls="animated-underline-shopping" aria-selected="true">Compras</a>
					</li>
					<li class="nav-item">
						<a class="nav-link @if(session('tabs')=="setting"){{ 'active' }}@endif" id="animated-underline-setting-tab" data-toggle="tab" href="#animated-underline-setting" role="tab" aria-controls="animated-underline-setting" aria-selected="@if(session('tabs')=="setting"){{ 'true' }}@else{{ 'false' }}@endif">Configuración</a>
					</li>
				</ul>

				<div class="tab-content" id="animateLineContent-4">
					<div class="tab-pane fade show active" id="animated-underline-shopping" role="tabpanel" aria-labelledby="animated-underline-shopping-tab">
						<div class="row">
							<div class="col-12">
								@if($orders->count()>0)
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
											@foreach($orders as $order)
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
											@endforeach
										</tbody>
									</table>
								</div>
								@else
								<p class="h4 text-center text-danger font-weight-bold py-4">No ha realizado ninguna compra</p>
								@endif
							</div>
						</div>    
					</div>
					<div class="tab-pane fade @if(session('tabs')=="setting"){{ 'show active' }}@endif" id="animated-underline-setting" role="tabpanel" aria-labelledby="animated-underline-setting-tab">
						<form action="{{ route('web.profile.update') }}" method="POST" class="form" id="formProfile" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
							<div class="row">
								<div class="form-group col-12">
									@include('admin.partials.errors')
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Foto (Opcional)</label>
									<input type="file" name="photo" accept="image/*" class="dropify" data-height="125" data-max-file-size="20M" data-allowed-file-extensions="jpg png jpeg web3" data-default-file="{{ image_exist('/admins/img/admins/', Auth::user()->photo, true) }}" />
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<div class="row">
										<div class="form-group col-12">
											<label class="col-form-label">Nombre<b class="text-danger">*</b></label>
											<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required placeholder="Introduzca un nombre" value="{{ Auth::user()->name }}">
										</div>

										<div class="form-group col-12">
											<label class="col-form-label">Apellido<b class="text-danger">*</b></label>
											<input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" required placeholder="Introduzca un apellido" value="{{ Auth::user()->lastname }}">
										</div>
									</div>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Email</label>
									<input class="form-control" type="email" disabled placeholder="Introduzca un correo electrónico" value="{{ Auth::user()->email }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Teléfono<b class="text-danger">*</b></label>
									<input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" required placeholder="Introduzca un teléfono" value="{{ Auth::user()->phone }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Contraseña (Opcional)</label>
									<input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="********" id="password">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Confirmar Contraseña (Opcional)</label>
									<input class="form-control" type="password" name="password_confirmation" placeholder="********">
								</div>

								<div class="form-group col-12">
									<button type="submit" class="btn btn-primary rounded px-4 py-2" action="profile">Actualizar</button>
								</div> 
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>

@endsection

@section('scripts')
{{-- <script src="{{ asset('/admins/vendor/table/datatable/datatables.js') }}"></script> --}}
<script src="{{ asset('/admins/vendor/dropify/dropify.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection