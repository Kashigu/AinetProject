<table class="table mt-3">
    <thead class="table-dark">
    <tr>
        <th class="text-center align-middle">Imagem</th>
        <th class="text-center align-middle">Nome</th>
        <th class="text-center align-middle">Tamanho</th>
        <th class="text-center align-middle">Cor</th>
        <th class="text-center align-middle">Quantidade</th>
        <th class="text-center align-middle">Preço Unitário</th>
        <th class="text-center align-middle">Preço c/desconto</th>
        <th class="text-center align-middle">Subtotal</th>
        @if ($showEdit)
            <th class="button-icon-col"></th>
        @endif
        @if ($showDelete)
            <th class="button-icon-col"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @php
        $total_price = 0;
    @endphp
    @foreach ($cart as $cartItem)
        <tr>
            <td class="text-center align-middle vertical-line">
                <img src="{{ $cartItem['tshirtImage']->fullPhotoUrlPersona }}" alt="Image" width="250" height="250" style="max-width: 100%; height: auto; background-color: gray">

            </td>
            <td class="text-center align-middle vertical-line">
                <span><strong>{{ $cartItem['tshirtImage']->name }}</strong></span>
            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $cartItem['tamanho'] }}</span>
            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $cartItem['color'] }}</span>
            </td>

            <td class="text-center align-middle vertical-line">
                <span>{{ $cartItem['quantidade'] }}</span>
            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $cartItem['price'] }}€</span>
            </td>
            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $cartItem['precoComDesconto'] }}€</span>
            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $cartItem['subtotal'] }}€</span>
            </td>
            @if ($showEdit)
                <td class="button-icon-col text-center align-middle"><a class="btn btn-dark" href="{{ route('cart.edit', ['tshirtImage' => $cartItem['tshirtImage'], 'color' => $cartItem['color'], 'tamanho' => $cartItem['tamanho']]) }}">
                        <i class="fas fa-edit"></i></a></td>
            @endif
            @if ($showDelete)
                <td class="button-icon-col text-center align-middle">
                    <form method="POST" action="{{ route('cart.remove', ['tshirtImage' => $cartItem['tshirtImage'], 'color' => $cartItem['color'], 'tamanho' => $cartItem['tamanho']]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="delete" class="btn btn-danger">
                            <i class="fas fa-trash"></i></button>
                    </form>
                </td>
            @endif
        </tr>
        @php
            $total_price += $cartItem['precoComDesconto'] * $cartItem['quantidade'];
        @endphp
    @endforeach
    </tbody>
</table>

<div class="my-4 d-flex justify-content-end">
    <h1>Total: {{$total_price}}€ &nbsp;&nbsp;&nbsp;</h1>
    @customer
        <button type="submit" class="btn btn-primary" name="ok" form="formStore">Confirmar Compra</button>
    @endcustomer
    @guest
        <button type="submit" class="btn btn-primary" name="login" form="formLogin">Confirmar Compra</button>
    @endguest
    <button type="submit" class="btn btn-danger ms-3" name="clear" form="formClear">Limpar Carrinho</button>
</div>

<form id="formLogin" method="GET" action="{{ route('login') }}" class="d-none">
    @csrf
    
</form>

<form id="formStore" method="GET" action="{{ route('order.create') }}" class="d-none">
    @csrf
</form>
<form id="formClear" method="POST" action="{{ route('cart.destroy') }}" class="d-none">
    @csrf
    @method('DELETE')
</form>
