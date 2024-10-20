<!-- Confirmation Modal -->
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog"
     aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">
                    {{ $title }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="{{ $formId }}" action="{{ route($formActionRoute, $formActionRouteParameters) }}" method="POST">
                    @csrf
                    @method($formMethod)
                    <label><h3>Nome:</h3></label>
                    <br>
                    <input class="@error('name') is-invalid @enderror" type="text" placeholder="Nome" name="name" value="{{$categoryName}}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                                data-bs-dismiss="modal">Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">{{ $confirmationButton }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
