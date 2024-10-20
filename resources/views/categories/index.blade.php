@extends('template.layout')

@section('titulo', 'Lista de Categorias')

@section('main')
    <div class="container mt-3">
        <form id="filterForm" method="GET" action="{{ route('category.index') }}">
            <div class="row">
                <div class="col-lg-10">
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
                @include('categories.shared.table', [
                    'showDetail' => true,
                    'showEdit' => true,
                    'showDelete' => true,
                ])
            </div>
        </div>
        <div class="mt-3">
            {{ $categories->withQueryString()->links() }}
        </div>
    </div>

    <script>
        document.getElementById('inputNome').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    </script>
@endsection




