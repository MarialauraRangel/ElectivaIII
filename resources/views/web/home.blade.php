@extends('layouts.web')

@section('title', 'Inicio')

@section('content')

@if(count($banners)>0)
<section class="ftco-section py-0 mb-3" id="banner">
    <div class="main-banner">
        <div class="bg-white px-0">
            <div id="carousel" class="carousel slide" data-ride="carousel">
                @if(count($banners)>1)
                <ol class="carousel-indicators">
                    @foreach($banners as $banner)
                    <li data-target="#carousel" data-slide-to="{{ $num++ }}" @if($loop->first) class="active" @endif></li>
                    @endforeach
                </ol>
                @endif
                <div class="carousel-inner">
                    @foreach($banners as $banner)
                    <div class="carousel-item @if($loop->first) active @endif">
                        <div class="d-flex justify-content-center">
                            <img src="{{ image_exist('/admins/img/banners/', $banner->image) }}" alt="{{ $banner->title }}">
                        </div>
                        <div class="card-img-overlay d-flex justify-content-center align-items-center">
                            <div class="row">
                                @if(!is_null($banner->title) || !is_null($banner->text) || $banner->button==1)
                                <div class="col-12 text-center px-4">
                                    @if(!is_null($banner->title))
                                    <h1 class="text-serif font-weight-bold mb-0">{{ $banner->title }}</h1>
                                    @endif
                                    @if(!is_null($banner->text))
                                    <h5 class="text-serif">{{ $banner->text }}</h5>
                                    @endif
                                    @if($banner->button==1)
                                    <div class="text-center mt-5">
                                        @empty($banner->url)
                                        <a href="javascript:void(0);" class="btn btn-primary px-3">{{ $banner->button_text }}</a>
                                        @else
                                        <a href="{{ $banner->pre_url.$banner->url }}" @if($banner->target==2) target="_blank" @endif class="btn btn-primary px-3">{{ $banner->button_text }}</a>
                                        @endempty
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if(count($banners)>1)
                    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif


{{-- <section class="ftco-section ftco-no-pb">
    <div class="container">
        <div class="row no-gutters ftco-services">
            <div class="col-lg-3 col-md-3 col-6 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-shipped"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Envíos a tiempo</h3>
                        <span>Hasta la comodidad de tu hogar</span>
                    </div>
                </div>      
            </div>
            <div class="col-lg-3 col-md-3 col-6 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-diet"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Ingredientes Frescos</h3>
                        <span>Pizzas con los mejor necesarios</span>
                    </div>
                </div>    
            </div>
            <div class="col-lg-3 col-md-3 col-6 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-award"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Calidad Superior</h3>
                        <span>Productos de Calidad</span>
                    </div>
                </div>      
            </div>
            <div class="col-lg-3 col-md-3 col-6 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-customer-service"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Pedidos</h3>
                        <span>Tratos coridales por parte de nuestros empleados</span>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</section> --}}

<section class="ftco-section">
    <div class="container">
        <div class="col-md-12 heading-section text-center">
            <h2 class="text-serif mb-4">Últimos Productos</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                @include('web.partials.product', ['product' => $product])
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- <section class="ftco-section img" style="background-image: url(web/images/bg_3.jpg);">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-6 heading-section ftco-animate deal-of-the-day ftco-animate">
                <span class="subheading">Los Mejores Precios para ti</span>
                <h2 class="mb-4">Servicio de Entrega</h2>
                <p>Desde nuestras instalaciones, viajaremos hasta la comodidad de tu hogar sin ningún inconveniente</p>
                <h3><a href="#">Hemos pensado en una mejor solución en esta cuarentena</a></h3>
            </div>
        </div>   		
    </div>
</section> --}}

@endsection