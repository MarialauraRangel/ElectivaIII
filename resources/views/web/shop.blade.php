@extends('layouts.web')

@section('title', 'Tienda')

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.css') }}">
@endsection

@section('content')

@include('web.partials.banner', ['title' => 'Tienda', 'banner' => $setting->banner])

<section class="ftco-section pt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <form action="{{ route('shop') }}" method="GET">
                    <div class="row">
                        <div class="form-group col-lg-3 col-md-6 col-12">
                            <select class="form-control" name="category" id="shopCategories">
                                <option value="">Todas las categorías</option>
                                @foreach($categories as $category)
                                @if(count($category->subcategories)>0)
                                <option @if(isset($search['category']) && !is_null($search['category']) && $search['category']==$category->slug) selected @endif value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-12">
                            <select class="form-control" name="subcategory" id="shopSubcategories">
                                <option value="">Todas las subcategorías</option>
                                @if(isset($search['category']) && !is_null($search['category']))
                                @foreach($subcategories as $subcategory)
                                <option @if(isset($search['subcategory']) && $search['subcategory']==$subcategory->slug) selected @endif value="{{ $subcategory->slug }}">{{ $subcategory->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-12">
                            <input class="form-control min" type="text" name="min" placeholder="Precio Min" value="@if(isset($search['min']) && !is_null($search['min'])){{ $search['min'] }}@endif">
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-12">
                            <input class="form-control max" type="text" name="max" placeholder="Precio Max" value="@if(isset($search['max']) && !is_null($search['max'])){{ $search['max'] }}@endif">
                        </div>

                        <div class="form-group col-12">
                            <button type="submit" class="btn btn-primary rounded w-100 py-1">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>

            @forelse($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                @include('web.partials.product', ['product' => $product])
            </div>
            @empty
            <div class="col-12">
                <p class="h3 text-center text-danger">No hay ningún resultado</p>
            </div>
            @endforelse

            <div class="col-12 d-flex justify-content-center">
                {{ $pagination->links() }}
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
@endsection