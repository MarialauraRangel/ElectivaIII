@extends('layouts.admin')

@section('title', 'Editar Descuentos')

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/select2/select2.min.css') }}">
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">

	<div class="col-12 layout-spacing">
		<div class="statbox widget box box-shadow">
			<div class="widget-header">
				<div class="row">
					<div class="col-xl-12 col-md-12 col-sm-12 col-12">
						<h4>Editar Descuentos</h4>
					</div>                 
				</div>
			</div>
			<div class="widget-content widget-content-area">

				<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('descuentos.update') }}" method="POST" class="form" id="formDiscount">
							@csrf
							@method('PUT')
							<div class="row">
								<div class="form-group col-12">
									<label class="col-form-label">Tipo<b class="text-danger">*</b></label>
									<select class="form-control @error('type') is-invalid @enderror" name="type" required id="typeDiscount">
										<option value="">Seleccione</option>
										<option value="1">Descuento Global</option>
										<option value="2">Descuento por Categorías</option>
										<option value="3">Descuento por Subcategorías</option>
									</select>
								</div>

								<div class="col-12 d-none" id="globalDiscount">
									<div class="row">
										<div class="form-group col-lg-6 col-md-6 col-12">
											<label class="col-form-label">Descuento Global<b class="text-danger">*</b></label>
											<input class="form-control discount @error('discount') is-invalid @enderror" name="discount" required disabled placeholder="Introduzca un descuento" value="{{ $setting->discount }}">
										</div>
									</div>
								</div>

								<div class="col-12 d-none" id="categoryDiscount">
									<div class="row">
										<div class="form-group col-lg-6 col-md-6 col-12">
											<label class="col-form-label">Categorías<b class="text-danger">*</b></label>
											<select class="form-control select2 @error('category_id') is-invalid @enderror" name="category_id[]" required disabled multiple>
												<option value="">Seleccione</option>
												@if(!is_null(old('category_id')))
												{!! selectArray($categories, old('category_id')) !!}
												@else
												@foreach($categories as $category)
												<option value="{{ $category->slug }}">{{ $category->name }}</option>
												@endforeach
												@endif
											</select>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-12">
											<label class="col-form-label">Descuento de Categorías<b class="text-danger">*</b></label>
											<input class="form-control discount @error('category_discount') is-invalid @enderror" name="category_discount" required disabled placeholder="Introduzca un descuento" value="{{ $setting->discount }}">
										</div>
									</div>
								</div>

								<div class="col-12 d-none" id="subcategoryDiscount">
									<div class="row">
										<div class="form-group col-lg-6 col-md-6 col-12">
											<label class="col-form-label">Subcategorías<b class="text-danger">*</b></label>
											<select class="form-control select2 @error('subcategory_id') is-invalid @enderror" name="subcategory_id[]" required disabled multiple>
												<option value="">Seleccione</option>
												@if(!is_null(old('subcategory_id')))
												{!! selectSubcategories($subcategories, old('subcategory_id')) !!}
												@else
												@foreach($subcategories as $subcategory)
												<option value="{{ $subcategory->slug }}">{{ $subcategory->category->name."/".$subcategory->name }}</option>
												@endforeach
												@endif
											</select>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-12">
											<label class="col-form-label">Descuento de Subcategorías<b class="text-danger">*</b></label>
											<input class="form-control discount @error('subcategory_discount') is-invalid @enderror" name="subcategory_discount" required disabled placeholder="Introduzca un descuento" value="{{ $setting->discount }}">
										</div>
									</div>
								</div>

								<div class="form-group col-12">
									<button type="submit" class="btn btn-primary" action="discount">Actualizar</button>
								</div> 
							</div>
						</form>
					</div>                                        
				</div>

			</div>
		</div>
	</div>

</div>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/select2/custom-select2.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection