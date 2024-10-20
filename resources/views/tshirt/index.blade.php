@extends('template.layout')

@section('titulo', 'Catálogo')

@section('main')
    <div class="container mt-3">
        <form id="filterForm" method="GET" action="{{ route('tshirtImage.index') }}">
            <div class="row">
                <div class="col-lg-3">
                    <select class="form-select btn btn-dark" name="id" id="categorySelect" style="font-size: 29px">
                        <option {{ $filterByCategoria === '' ? 'selected' : '' }} value="">Todas as Categorias</option>
                        @foreach($categories as $category)
                            <option
                                {{ $filterByCategoria == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-7">
                    <div class="mb-3 me-2 flex-grow-1 ">
                        <input type="text" class="btn btn-dark" style="font-size: 29px ; border: 1px solid white;width: 100% ;" placeholder="Nome" class="form-control" name="nome" id="inputNome"
                               value="{{ $filterByNome }}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-dark" style="font-size: 29px ; width: 100%">Search</button>
                </div>
            </div>
        </form>
        <div class="row justify-content-center">
            @foreach ($tshirtImages as $tshirtImage)
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-header bg-dark "><h3><a class="text-white text-decoration-none"
                                                             href="{{ route('tshirtImage.show', ['tshirtImage' => $tshirtImage])  }}"> {{ $tshirtImage->name }}
                                </a></h3>
                        </div>
                        <div class="card-body card-header bg-dark text-light">
                            <a href="{{ route('tshirtImage.show', ['tshirtImage' => $tshirtImage])  }}">
                                <img src="{{ $tshirtImage->fullPhotoUrl }}" width="380" height="380"
                                     style="background-color: gray; object-fit: contain;"></a>
                            <div class="price-details mt-3">
                                <div class="price "><h4>{{ $price }}€</h4></div>
                                <a href="{{ route('tshirtImage.show', ['tshirtImage' => $tshirtImage])  }}"
                                   class="details text-white text-decoration-none"><h4>Details</h4></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3">
            {{ $tshirtImages->withQueryString()->links() }}
        </div>
    </div>

    <script>
        document.getElementById('categorySelect').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        }); // no sitio onde meti o id categorySelect adicionei um listener 'change' que é um evento standard do
            // javascript que depois de mudado vai submeter a troca no sitio onde tem o id categoryForm e depois manda um get para a route('tshirt.index')
            // que depois no controlador devolve me as imagens com a categoria que escolhi
            // o de baixo faz o mesmo mas para o texto
        document.getElementById('inputNome').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    </script>
@endsection



