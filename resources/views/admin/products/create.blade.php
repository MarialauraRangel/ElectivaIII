@extends('layouts.admin')

@section('title', 'Crear Productos')

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/uploader/jquery.dm-uploader.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/uploader/styles.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">

	<div class="col-12 layout-spacing">
		<div class="statbox widget box box-shadow">
			<div class="widget-header">
				<div class="row">
					<div class="col-xl-12 col-md-12 col-sm-12 col-12">
						<h4>Crear Productos</h4>
					</div>                 
				</div>
			</div>
			<div class="widget-content widget-content-area">

				<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('productos.store') }}" method="POST" class="form" id="formProduct">
							@csrf
							<div class="row">
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Nombre<b class="text-danger">*</b></label>
									<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required placeholder="Introduzca un nombre" value="{{ old('name') }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Código<b class="text-danger">*</b></label>
									<input class="form-control @error('code') is-invalid @enderror" type="text" name="code" required placeholder="Introduzca un código" value="{{ old('code') }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Categoría/Subcategorías<b class="text-danger">*</b></label>
									<select class="form-control select2 @error('subcategory_id') is-invalid @enderror" name="subcategory_id[]" required multiple>
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
									<label class="col-form-label">Colores</label>
									<select class="form-control select2 @error('color_id') is-invalid @enderror" name="color_id[]" multiple>
										<option value="">Seleccione</option>
										@if(!is_null(old('color_id')))
										{!! selectArray($colors, old('color_id')) !!}
										@else
										@foreach($colors as $color)
										<option value="{{ $color->slug }}" @if(old('color_id')==$color->slug) selected @endif>{{ $color->name }}</option>
										@endforeach
										@endif
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Tallas</label>
									<select class="form-control select2 @error('size_id') is-invalid @enderror" name="size_id[]" multiple>
										<option value="">Seleccione</option>
										@if(!is_null(old('size_id')))
										{!! selectArray($sizes, old('size_id')) !!}
										@else
										@foreach($sizes as $size)
										<option value="{{ $size->slug }}" @if(old('size_id')==$size->slug) selected @endif>{{ $size->name }}</option>
										@endforeach
										@endif
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Cantidad<b class="text-danger">*</b></label>
									<input class="form-control number @error('qty') is-invalid @enderror" type="text" name="qty" required placeholder="Introduzca una cantidad" value="{{ old('qty') }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Precio<b class="text-danger">*</b></label>
									<input class="form-control decimal @error('price') is-invalid @enderror" type="text" name="price" required placeholder="Introduzca el precio" value="{{ old('price') }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Descuento (%)<b class="text-danger">*</b></label>
									<input class="form-control discount @error('discount') is-invalid @enderror" type="text" name="discount" required placeholder="Introduzca el descuento" value="{{ old('discount') }}">
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Descripción<b class="text-danger">*</b></label>
									<textarea class="form-control @error('description') is-invalid @enderror" required name="description" placeholder="Introduce la descripción" rows="4">{{ old('description') }}</textarea>
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Imágenes<b class="text-danger">*</b></label>
									<div id="drop-area" class="dm-uploader text-center bg-white py-4 px-2">
										<h3 class="text-muted">Arrastra aquí tus imágenes</h3>
										<div class="btn btn-primary btn-block">
											<span>Selecciona un archivo</span>
											<input type="file" title="Selecciona un archivo" multiple>
										</div>
									</div>
									<p id="response" class="text-left py-0"></p>
								</div>

								<div class="col-12">
									<div class="row" id="images"></div>
								</div>

								<div class="form-group col-12">
									<div class="btn-group" role="group">
										<button type="submit" class="btn btn-primary" action="product">Guardar</button>
										<a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
									</div>
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
<script src="{{ asset('/admins/vendor/uploader/jquery.dm-uploader.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection