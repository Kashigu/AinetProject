@extends('template.layout')

@section('main')
    <div class="container">
        <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
            <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center justify-content-between"
                 style="min-width:260px; max-width:260px;">
                @include('users.shared.fields_foto', [
                    'user' => $user,
                    'allowUpload' => false,
                    'allowDelete' => false,
                ])
            </div>
        </div>
        @customer
        <div class="row">
            <div class="col-md-12 mt-4 price-details">
                <div class="col-md-6 mt-4 center">
                    <h3>Email: {{Auth::user()->email}}</h3>
                </div>
                <div class="col-md-6 mt-4 center">
                    @if(Auth::user()->customer->nif != null)
                        <h3> NIF: {{Auth::user()->customer->nif}}</h3>
                    @else
                        <h3>NIF: Ainda não tem NIF</h3>
                    @endif
                </div>
            </div>
            <div class="col-md-12 mt-4 center">
                @if(Auth::user()->customer->address != null)
                    <h3>Address: {{Auth::user()->customer->address}}</h3>
                @else
                    <h3>Address: Ainda não tem Adress</h3>
                @endif
            </div>
        </div>
        @endcustomer

        @admin()
        <div class="row">
            <div class="col-md-12 mt-4 price-details">
                <div class="col-md-6 mt-4 center">
                    <h3>Email: {{$user->email}}</h3>
                </div>
                <div class="col-md-6 mt-4 center">
                    @if($user->user_type == 'E')
                        <h3> Tipo: Funcionário </h3>
                    @else
                        <h3> Tipo: Administrador</h3>
                    @endif
                </div>
            </div>
        </div>
        @endadmin

        <div class="row">
            <div class="col-md-12 mt-4 rowReverse price-details">
                @admin()
                <a href="{{ route('user.edit', ['user' => $user ])}}"
                   class="btn btn-dark text-white text-decoration-none">Editar Perfil</a>
                <a class="text-white text-decoration-none" href="{{route('user.index')}}"> <button class="btn btn-dark"> Voltar</button></a>
                @endadmin
                @customer()
                <a href="{{ route('customer.edit', ['customer' => $user ])}}"
                   class="btn btn-dark text-white text-decoration-none">Editar Perfil</a>

                <a class="text-white text-decoration-none" href="{{route('tshirtImage.create')}}"> <button class="btn btn-dark"> Adicionar Imagem</button></a>
                @endcustomer
            </div>
        </div>

    </div>
    @customer()
    <div class="container mt-4">
        <div class="col-md-12">
            @include('users.shared.table', [
            'id' => $id,
            'tshirtImages'=> $TshirtImages,
            'showDetail' => true,
            'showEdit' => true,
            'showDelete' => true,
        ])
        </div>
    </div>
    @endcustomer
@endsection
