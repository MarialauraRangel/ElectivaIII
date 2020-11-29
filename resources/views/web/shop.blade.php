@extends('layouts.web')

@section('title', 'Tienda')

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.css') }}">
@endsection

@section('content')

<div class="hero-wrap hero-bread" style="background-image: url('web/images/bg_2.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Inicio</a></span> <i class="fa fa-angle-right mx-2"></i> <span>Tienda</span></p>
                <h1 class="mb-0 bread text-serif">Tienda</h1>
            </div>
        </div>
    </div>
</div>

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
                                <option @if($search['subcategory']==$subcategory->slug) selected @endif value="{{ $subcategory->slug }}">{{ $subcategory->name }}</option>
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