<table class="table mt-3">
    <thead class="table-dark">
    <tr>
        <td colspan="8" align='right'>

            <a href="{{ route('user.create') }}">
                <button type="button" class="btn btn-success">Adicionar</button>
            </a>

        </td>
    </tr>
    <tr>
        <th class="text-center align-middle">Imagem</th>
        <th class="text-center align-middle">Nome</th>
        <th class="text-center align-middle">Email</th>
        <th class="text-center align-middle">Tipo</th>
        <th class="text-center align-middle">Bloqueado</th>
        <th class="text-center align-middle" colspan="3">Opções</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td class="text-center align-middle vertical-line">
                <img src="{{ $user->fullPhotoUrl }}"
                     alt="Image"
                     class="bg-dark"
                     style="max-width: 100%; height: auto;">
            </td>
            <td class="text-center align-middle vertical-line">
                <span><strong>{{ $user->name }}</strong></span>

            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $user->email }}</span>
            </td>
            <td class="text-center align-middle vertical-line">
                @if($user->user_type == 'A')
                    <span>Administrador</span>
                @elseif($user->user_type == 'E')
                    <span>Funcionário</span>
                @else
                    <span>Customer</span>
                @endif
            </td>
            <td class="button-icon-col text-center align-middle vertical-line">
                @if($user->blocked == '1')
                    <form method="POST" action="{{ route('users.block', ['user' => $user]) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" name="delete" class="btn btn-danger">
                            <i class="fa fa-lock"></i></button>
                    </form>
                @else
                    <form method="POST" action="{{ route('users.block', ['user' => $user]) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" name="delete" class="btn btn-success">
                            <i class="fa fa-unlock"></i></button>
                    </form>
                @endif
            </td>
            @if ($showDetail &&  $user->user_type != 'C')
                <td class="button-icon-col text-center align-middle"><a class="btn btn-secondary"
                                               href="{{ route('user.show', ['user' => $user ]) }}">
                        <i class="fas fa-eye"></i></a></td>
            @endif
            @if ($showEdit &&  $user->user_type != 'C')
                <td class="button-icon-col text-center align-middle"><a class="btn btn-dark"
                                               href="{{ route('user.edit', ['user' => $user ])}}">
                        <i class="fas fa-edit"></i></a></td>
            @endif

            @if ($showDelete)
                <td class="button-icon-col text-center align-middle verticalRight-line">
                    <form id="deleteForm{{ $user->id }}" method="POST" action="{{ route('user.destroy', ['user' => $user]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#confirmationModal{{ $user->id }}">
                            <i class="fas fa-trash"></i></button>
                    </form>
                </td>
                @include('shared.confirmation', [
                        'name'=> $user->name,
                        'modalId' => 'confirmationModal' . $user->id,
                        'formId' => 'deleteForm' . $user->id,
                        'title' => 'Quer realmente apagar o Utilizador ',
                        'confirmationButton' => 'Apagar',
                        'formActionRoute' => 'user.destroy',
                        'formActionRouteParameters' => ['user' => $user],
                        'formMethod' => 'DELETE',
                    ])
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
