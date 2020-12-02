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