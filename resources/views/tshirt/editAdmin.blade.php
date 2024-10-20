@extends('template.layout')

@section('titulo', 'Editar Tshirt Image')

@section('main')
    <form id="form_criarImage" method="POST" action="{{ route('tshirt.updateAdmin', ['tshirtImage' => $tshirtImage]) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="container">
            <div class="row price-details " style="align-items: center; height: 60vh;">
                <div class="col-md-12 center">
                    <div class="col-md-6 text-center">
                        <label>Nome:</label>
                        <br>
                        <input class="@error('name') is-invalid @enderror" type="text" placeholder="Nome" name="name"
                               value="{{ $tshirtImage->name }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 text-center">
                        <label>Categoria:</label>
                        <select class="form-select" name="idCategory" id="categorySelect">
                            <option value="{{$tshirtImage->category_id}}">{{$tshirtImage->category->name}}</option>
                            @foreach($categorias as $category)
                                @if($tshirtImage->category_id !== $category->id)
                                    <option
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <label>Description:</label>
                    <br>
                    <input class="@error('description') is-invalid @enderror" type="text" placeholder="Description"
                           name="description" value="{{ $tshirtImage->description }}">
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-md-12 mt-4 text-center">
                    <img src="{{ $tshirtImage->fullPhotoUrl }}" id="output_image"
                         style="max-width: 100%; max-height: 300px;">
                    <p></p>
                    <div class="mt-3">
                        <label>Image:</label>
                        <input class="@error('image_url') is-invalid @enderror" type="file" name="image_url"
                               accept="image/*" onchange="preview_image(event)">
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
                    <a href="{{route('tshirt.indexAdmin')}}"
                       class="btn btn-dark my-1 center">Voltar</a>
                    <button type="submit" class="btn btn-success" name="ok" form="form_criarImage">Guardar Alterações
                    </button>
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
