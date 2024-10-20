@extends('template.layout')

@section('titulo', 'Editar Cor')

@section('main')
    <form id="form_criarImage" method="POST" action="{{ route('color.update',['color' => $color]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container">
            <div class="row price-details " style="align-items: center; height: 60vh;">
                <div class="col-md-12 price-details">
                    <div class="col-md-4">
                        <label>Nome:</label>
                        <input class="@error('name') is-invalid @enderror" type="text" placeholder="Nome" name="name" value="{{$color->name}}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Code:</label>
                        <input class="@error('code') is-invalid @enderror" type="text" placeholder="Code Hexadecimal sem o '#'" name="code" value="{{$color->code}}">
                        @error('code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label>Image:</label>
                        <img src="{{ asset('storage/tshirt_base/'.$color->code.'.jpg')}}" id="output_image" style="max-width: 100%; max-height: 300px;">
                        <p></p>
                        <input class="@error('image_url') is-invalid @enderror" type="file" name="image_url" value="{{asset('storage/tshirt_base/'.$color->code.'.jpg')}}"  accept="image/*" onchange="preview_image(event)" >
                        @error('image_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <input type="hidden" name="previous_image" value="{{asset('storage/tshirt_base/'.$color->code.'.jpg')}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                    <a href="{{ route('color.index') }}" class="btn btn-dark my-1">Voltar</a>
                    <button type="submit" class="btn btn-success" name="ok" form="form_criarImage">Guardar Alterações</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        function preview_image(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output_image');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
