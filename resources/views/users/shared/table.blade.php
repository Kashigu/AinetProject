@if ($TshirtImages->isEmpty())
    <h3>Ainda não tem imagens</h3>
@else
    <h3>Imagens de {{$user->name}}</h3>
    <table class="table mt-3">
        <thead class="table-dark">
        <tr>
            <th class="text-center align-middle">Imagem</th>
            <th class="text-center align-middle">Nome</th>
            <th class="text-center align-middle">Descrição</th>
            @if ($showDetail)
                <th class="button-icon-col"></th>
            @endif
            @if ($showEdit)
                <th class="button-icon-col"></th>
            @endif
            @if ($showDelete)
                <th class="button-icon-col"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($TshirtImages as $image)
            <tr>
                <td class="text-center align-middle vertical-line">
                    <img src="{{ $image->fullPhotoUrlPersona }}"
                         alt="Image"
                         class="bg-dark"
                         style="max-width: 50%; height: auto;">
                </td>
                <td class="text-center align-middle vertical-line">
                    <span><strong>{{ $image->name }}</strong></span>
                </td>
                <td class="text-center align-middle vertical-line">
                    <span>{{ $image->description }}</span>
                </td>
                @if ($showDetail)
                    <td class="text-center align-middle vertical-line"><a class="btn btn-secondary"
                                                                          href="{{ route('tshirtImage.show', ['tshirtImage' => $image]) }}">
                            <i class="fas fa-eye"></i></a></td>
                @endif
                @if ($showEdit)
                    <td class="text-center align-middle vertical-line"><a class="btn btn-dark"
                                                                            href="{{route('tshirtImage.edit', ['tshirtImage' => $image])}}">
                            <i class="fas fa-edit"></i></a></td>
                @endif
                @if ($showDelete)
                    <td class="text-center align-middle vertical-line">
                        <form id="deleteForm{{ $image->id }}" method="POST"
                              action="{{ route('tshirtImage.destroy', ['tshirtImage' => $image]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#confirmationModal{{ $image->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @include('shared.confirmation', [
                         'name' => $image->name,
                         'modalId' => 'confirmationModal' . $image->id,
                         'formId' => 'deleteForm' . $image->id,
                         'title' => 'Quer realmente apagar a Imagem ',
                         'confirmationButton' => 'Apagar',
                         'formActionRoute' => 'tshirtImage.destroy',
                         'formActionRouteParameters' => ['tshirtImage' => $image],
                         'formMethod' => 'DELETE',
                     ])


                    </td>
                @endif


            </tr>

        @endforeach
        </tbody>
    </table>
@endif
