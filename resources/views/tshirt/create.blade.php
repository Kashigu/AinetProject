@extends('template.layout')

@section('titulo', 'Nova Tshirt Image')

@section('main')
    <form id="form_criarImage" method="POST" action="{{ route('tshirtImage.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="row price-details " style="align-items: center; height: 60vh;">
                <div class="col-md-12 price-details">
                    <input type="hidden" name="idUser" value="{{$idUser}}">
                    <div class="col-md-4">
                        <label>Nome:</label>
                        <input class="@error('name') is-invalid @enderror" type="text" placeholder="Nome" name="name">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Description:</label>
                        <input class="@error('description') is-invalid @enderror" type="text" placeholder="Description" name="description">
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Image:</label>
                        <input class="@error('image_url') is-invalid @enderror" type="file" name="image_url">
                        @error('image_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                    <a href="{{route('user.show',['user' => $idUser])}}"
                       class="btn btn-dark my-1">Voltar</a>
                    <button type="submit" class="btn btn-success" name="ok" form="form_criarImage">Guardar nova
                        Imagem
                    </button>

                </div>
            </div>
        </div>
    </form>
@endsection

