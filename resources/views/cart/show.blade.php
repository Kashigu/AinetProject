@extends('template.layout')

@section('main')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                @include('cart.shared.table', [
                'cart' => $cart,
                'showDetail' => true,
                'showEdit' => true,
                'showDelete' => true,
            ])
            </div>
        </div>
    </div>
@endsection
