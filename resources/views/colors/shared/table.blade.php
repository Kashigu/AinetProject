<table class="table mt-3">
    <thead class="table-dark">
    <tr>
        <td colspan="6" align='right'>

            <a href="{{ route('color.create') }}">
                <button type="button" class="btn btn-success">Adicionar</button>
            </a>

        </td>
    </tr>
    <tr>
        <th class="text-center align-middle">Imagem</th>
        <th class="text-center align-middle">Nome</th>
        <th class="text-center align-middle">Codigo</th>
        <th class="text-center align-middle" colspan="2">Opções</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($colors as $cor)
        <tr>
            <td class="text-center align-middle vertical-line">
                <img src="{{asset('storage/tshirt_base/'.$cor->code .'.jpg')}} "
                     alt="Image"
                     style="width: 15%; height: auto; background-color: lightgrey">
            </td>
            <td class="text-center align-middle vertical-line">
                <span><strong>{{ $cor->name }}</strong></span>

            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $cor->code }}</span>
            </td>
            @if ($showEdit)
                <td class="text-center align-middle"><a class="btn btn-dark"
                                                        href="{{route('color.edit',['color' => $cor])}}">
                        <i class="fas fa-edit"></i></a></td>
            @endif

            @if ($showDelete)
                <td class="text-center align-middle vertical-line">
                    <form id="deleteForm{{ $cor->code }}" method="POST"
                          action="{{ route('color.destroy', ['color' => $cor]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#confirmationModal{{ $cor->code }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @include('shared.confirmation', [
                     'name'=> $cor->name,
                     'modalId' => 'confirmationModal' . $cor->code,
                     'formId' => 'deleteForm' . $cor->code,
                     'title' => 'Quer realmente apagar a Cor ',
                     'confirmationButton' => 'Apagar',
                     'formActionRoute' => 'color.destroy',
                     'formActionRouteParameters' => ['color' => $cor],
                     'formMethod' => 'DELETE',
                 ])


                </td>
            @endif

        </tr>
    @endforeach
    </tbody>
</table>
