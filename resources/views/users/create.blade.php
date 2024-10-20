@extends('template.layout')

@section('main')
    <form id="form_criarImage" method="POST" action="{{ route('user.store')}}"
          enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="container">
            <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
                <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center justify-content-between"
                     style="min-width:260px; max-width:260px;">
                    <img src="" alt="Avatar" id="output_image"
                         class="rounded-circle img-thumbnail" style="width: 260px">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-4 price-details">
                    <div class="col-md-12 mt-4 center">
                        <p></p>
                        <div class="mt-3">
                            <label>Image:</label>
                            <input type="file" name="photo_url" accept="image/*" onchange="preview_image(event)">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4 price-details">
                    <div class="col-md-6 mt-4 alinhaTextoCentro">
                        <label><h3>Nome:</h3></label>
                        <br>
                        <input class="@error('name') is-invalid @enderror" type="text" placeholder="Nome" name="name">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-4 alinhaTextoCentro">
                        <label><h3>Email:</h3></label>
                        <br>
                        <input class="@error('email') is-invalid @enderror" type="text" placeholder="Email" name="email">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 mt-4 price-details">
                    <div class="col-md-6 mt-4 alinhaTextoCentro">
                        <label><h3>Password:</h3></label>
                        <br>
                        <input class="@error('password') is-invalid @enderror" type="password" placeholder="Password" name="password">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-4 center">
                        <select name="tipo">
                            <option value="C">Customer</option>
                            <option value="E">Funcionário</option>
                            <option value="A">Administrador</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-4 alinhaTextoCentro">
                <div class="col-md-12 d-flex justify-content-between">
                    <a href="{{route('user.index')}}"
                       class="btn btn-dark my-1 center">Voltar</a>
                    <button type="submit" class="btn btn-success" name="ok" form="form_criarImage">Criar User

                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

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
