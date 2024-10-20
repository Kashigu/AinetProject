@extends('template.layout')

@section('titulo', 'Preço')

@section('main')

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                @include('prices.shared.table', [
                    'showDetail' => false,
                    'showEdit' => true,
                    'showDelete' => false,
                ])
            </div>
        </div>
    </div>
@endsection
