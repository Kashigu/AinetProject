@extends('template.layout')

@section('titulo', 'Lista de ' . $user_type_nome)

@section('main')
    <div class="container mt-4">
        <form method="GET" action="{{ route('users.index') }}">
            <div class="row center">
                <div class="col-lg-4 center">
                    <button class="btn btn-dark{{ $filterByUser == 'C' ? ' active' : '' }}" name="user_type" value="C" type="submit" style="font-size: 30px;"> Customers
                    </button>
                </div>
                <div class="col-lg-4 center">
                    <button class="btn btn-dark{{ $filterByUser == 'E' ? ' active' : '' }}" name="user_type" value="E" type="submit" style="font-size: 30px;"> Funcionarios
                    </button>
                </div>
                <div class="col-lg-4 center">
                    <button class="btn btn-dark{{ $filterByUser == 'A' ? ' active' : '' }}" name="user_type" value="A" type="submit" style="font-size: 30px;"> Administradores
                    </button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                @include('users.shared.tableAdmin', [
                    'showDetail' => true,
                    'showEdit' => true,
                    'showDelete' => true,
                ])
            </div>
        </div>
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
@endsection
