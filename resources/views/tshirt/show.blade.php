@extends('template.layout')

@section('main')
<form method="POST" action="{{ route('cart.add', ['tshirtImage' => $tshirtImage])}}">
    <div class="container mt-3">
        <div class="row">

            <div class="col-md-6 mt-4">
                <div class="image-container">

                    @csrf
                    <input type="hidden" id="selectedColor" name="color">
                    <input type="hidden" name="tshirt" value="{{ $tshirtImage->id }}">
                    <div id="colorImageContainer" style="position: relative; width: 380px; height: 380px;">

                        <img id="colorImage" src="{{asset('storage/tshirt_base/fafafa.jpg')}}" width="510" height="510" style="position: absolute; top: 0; left: 0;">

                        @if(Auth::user() && Auth::user()->id === $customer_id )
                        <img src="{{ $tshirtImage->fullPhotoUrlPersona }}" width="250" height="250" style="position: absolute; top: 60%; left: 60%; transform: translate(-40%, -50%);">
                        @else
                        <img src="{{ $tshirtImage->fullPhotoUrl }}" width="250" height="250" style="position: absolute; top: 60%; left: 60%; transform: translate(-40%, -50%);">
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-6 box">
                <div class="card-body">
                    <div>
                        <h1> {{$tshirtImage->name}} </h1>
                    </div>

                    <div class="mt-3">
                        @foreach ($color as $colors)
                        <span name="color" class="color-circle" style="background-color:#{{$colors->code}}" onclick="changeColor('{{ $colors->tshirtFoto }}', '{{ $colors->name }}')"></span>
                        @endforeach
                    </div>
                    <div class="price-details mt-3">

                        @if(Auth::user() && Auth::user()->id === $customer_id )
                        <input type="hidden" name="price" value="{{ $pricePersona }}">
                        <div>
                            <h1>{{ $pricePersona }}€ </h1>
                        </div>
                        @else
                        <input type="hidden" name="price" value="{{ $price }}">
                        <div>
                            <h1>{{ $price }}€ </h1>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-3 mt-2 center">
                            <div class="btn-group" role="group">
                                <button id="decrement" type="button" class="btn btn-dark" style="font-size: 30px;">
                                    -
                                </button>
                                <input id="quantity" name="quantidade" min="1" value="1" class="form-control center">
                                <button id="increment" type="button" class="btn btn-dark" style="font-size: 30px;">
                                    +
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2 fim mt-2">
                            <select class="form-select btn btn-dark" name="tamanho">
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-3 fim mt-2">
                            <button class="btn btn-dark" type="submit" style="font-size: 30px;"><i class="fa-solid fa-cart-shopping"></i> Add
                            </button>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-6 mt-4">
            </div>
            <div class="col-md-6 mt-4 box">
                <div>
                    <h2> Description </h2>
                </div>
                <span style="font-size: 20px">{{$tshirtImage->description}}</span>
            </div>

        </div>

    </div>
</form>
<script src="{{asset('js/novo.js')}}"></script>


@endsection