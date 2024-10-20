@extends('template.layout')

@section('titulo', 'Lista de Imagens')

@section('main')
    <div class="container mt-3">
        <form id="filterForm" method="GET" action="{{ route('tshirt.indexAdmin') }}">
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
        <div class="row">
            <div class="col-md-12">
                @include('tshirt.shared.tableAdmin', [
                    'showDetail' => true,
                    'showEdit' => true,
                    'showDelete' => true,
                ])
            </div>
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



