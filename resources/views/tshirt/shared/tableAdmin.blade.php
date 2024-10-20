<table class="table mt-3">
    <thead class="table-dark">
    <tr>
        <td colspan="6" align='right'>

            <a href="{{ route('tshirt.createAdmin') }}">
                <button type="button" class="btn btn-success">Adicionar</button>
            </a>

        </td>
    </tr>
    <tr>
        <th class="text-center align-middle">Imagem</th>
        <th class="text-center align-middle">Nome</th>
        <th class="text-center align-middle">Description</th>
        <th class="text-center align-middle">Categoria</th>
        <th class="text-center align-middle" colspan="2">Opções</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tshirtImages as $image)
        <tr>
            <td class="text-center align-middle vertical-line">
                <img src="{{ $image->fullPhotoUrl }}"
                     alt="Image"
                     style="max-width: 35%; height: auto; background-color: lightgrey">
            </td>
            <td class="text-center align-middle vertical-line">
                <span><strong>{{ $image->name }}</strong></span>

            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $image->description }}</span>
            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $image->category->name }}</span>
            </td>
            @if ($showEdit)
                <td class="text-center align-middle"><a class="btn btn-dark"
                                                                        href="{{route('tshirt.editAdmin',['tshirtImage' => $image])}}">
                        <i class="fas fa-edit"></i></a></td>
            @endif

            @if ($showDelete)
                <td class="text-center align-middle verticalRight-line">
                    <form id="deleteForm{{ $image->id }}" method="POST"
                          action="{{ route('tshirt.destroyAdmin', ['tshirtImage' => $image]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#confirmationModal{{ $image->id }}">
                            <i class="fas fa-trash"></i></button>
                    </form>
                    @include('shared.confirmation', [
                       'name' => $image->name,
                       'modalId' => 'confirmationModal' . $image->id,
                       'formId' => 'deleteForm' . $image->id,
                       'title' => 'Quer realmente apagar a Imagem ',
                       'confirmationButton' => 'Apagar',
                       'formActionRoute' => 'tshirt.destroyAdmin',
                       'formActionRouteParameters' => ['tshirtImage' => $image],
                       'formMethod' => 'DELETE',
                   ])
                </td>
            @endif

        </tr>
    @endforeach
    </tbody>
</table>
