<!-- Confirmation Modal-->
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog"
     aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">
                    {{ $title }}{{$name}} ?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button"
                        data-bs-dismiss="modal">Cancelar
                </button>
                <a class="btn btn-danger" onclick="event.preventDefault();
                        document.getElementById('{{ $modalId }}Form').submit();">
                    {{ $confirmationButton }}</a>
                <form id="{{ $modalId }}Form"
                      action="{{ route($formActionRoute, $formActionRouteParameters) }}"
                      method="POST" style="display: none;">
                    @csrf
                    @method($formMethod)
                </form>
            </div>
        </div>
    </div>
</div>
