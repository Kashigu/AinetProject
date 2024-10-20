@extends('template.layout')

@section('main')


    <div class="container mt-3">
        <div class="row justify-content-center">
            @foreach ($tshirtImages as $tshirtImage)
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-header bg-dark text-light">{{ $tshirtImage->name }}</div>
                        <div class="card-body">
                            <img src="{{ $tshirtImage->fullPhotoUrlPersona }}" width="380" height="380" style="background-color: gray">
                            <div class="price-details mt-3">
                                <div class="price">{{ $price }}€</div>
                                <a href="{{ route('tshirt.details', ['tshirtImage' => $tshirtImage])  }}" class="details">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3">
            {{ $tshirtImages->links() }}
        </div>
    </div>



@endsection

