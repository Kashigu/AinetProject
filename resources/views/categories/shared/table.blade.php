<table class="table mt-3">
    <thead class="table-dark">
    <tr>
        <td colspan="4" align='right'>
            <form id="createForm" method="POST" action="{{ route('category.store') }}">
                @csrf
                @method('POST')
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createconfirmationModal">Adicionar</button>
            </form>
            @include('shared.createConfirmation', [
                'modalId' => 'createconfirmationModal',
                'formId' => 'createForm',
                'title' => 'Criar Categoria?',
                'confirmationButton' => 'Confirmar',
                'formActionRoute' => 'category.store',
                'formMethod' => 'POST',
            ])
        </td>
    </tr>
    <tr>
        <th class="text-center align-middle">ID</th>
        <th class="text-center align-middle">Nome</th>
        <th class="text-center align-middle" colspan="2">Opções</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($categories as $image)
        <tr>
            <td class="text-center align-middle vertical-line">
                <span><strong>{{ $image->id }}</strong></span>

            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $image->name }}</span>
            </td>

            @if ($showEdit)
                <td class="text-center align-middle vertical-line">
                    <form id="editForm{{ $image->id }}" method="POST"
                          action="{{ route('category.update', ['category' => $image]) }}">
                        @csrf
                        @method('PUT')
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                data-bs-target="#editconfirmationModal{{ $image->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </form>
                @include('shared.editConfirmation', [
                        'categoryName' =>$image->name,
                        'modalId' => 'editconfirmationModal' . $image->id,
                        'formId' => 'editForm' . $image->id,
                        'title' => 'Editar Categoria?',
                        'confirmationButton' => 'Confirmar',
                        'formActionRoute' => 'category.update',
                        'formActionRouteParameters' => ['category' => $image],
                        'formMethod' => 'PUT',
                    ])
            @endif

            @if ($showDelete)
                <td class="text-center align-middle vertical-line">
                    <form id="deleteForm{{ $image->id }}" method="POST"
                          action="{{ route('category.destroy', ['category' => $image]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#confirmationModal{{ $image->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @include('shared.confirmation', [
                     'name'=> $image->name,
                     'modalId' => 'confirmationModal' . $image->id,
                     'formId' => 'deleteForm' . $image->id,
                     'title' => 'Quer realmente apagar a Categoria ',
                     'confirmationButton' => 'Apagar',
                     'formActionRoute' => 'category.destroy',
                     'formActionRouteParameters' => ['category' => $image],
                     'formMethod' => 'DELETE',
                 ])


                </td>
            @endif

        </tr>
    @endforeach
    </tbody>
</table>

