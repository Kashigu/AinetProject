<table class="table mt-3">
    <thead class="table-dark">
    <tr>
        <th class="text-center align-middle">Catálogo Preço</th>
        <th class="text-center align-middle">Preço Próprio</th>
        <th class="text-center align-middle">Desconto Catálogo</th>
        <th class="text-center align-middle">Desconto Próprio</th>
        <th class="text-center align-middle">Quantidade para Desconto</th>
        <th class="text-center align-middle">Opção</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($price as $preco)
        <tr>
            <td class="text-center align-middle vertical-line">
                <span><strong>{{ $preco->unit_price_catalog }}</strong></span>
            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $preco->unit_price_own }}</span>
            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $preco->unit_price_catalog_discount }}</span>
            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $preco->unit_price_own_discount }}</span>
            </td>
            <td class="text-center align-middle vertical-line">
                <span>{{ $preco->qty_discount }}</span>
            </td>
            @if ($showEdit)
                <td class="text-center align-middle vertical-line">
                    <button class="btn btn-dark edit-btn" onclick="mostrarForm('editForm{{$preco->id}}')">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

@foreach ($price as $preco)
    <form id="form_editarPrice" method="POST" action="{{ route('price.update', ['price' => $preco]) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container mt-4" id="editForm{{$preco->id}}" style="display: none;">
            <div class="row">
                <div class="col-md-12 mt-4 price-details">
                    <div class="col-md-6 mt-4 alinhaTextoCentro">
                        <label>Catálogo Preço:</label>
                        <input class="@error('catalogPrice') is-invalid @enderror" type="text" placeholder="Catálogo Preço" name="catalogPrice"
                               value="{{ $preco->unit_price_catalog }}">
                        @error('catalogPrice')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-4 alinhaTextoCentro">
                        <label>Preço Próprio:</label>
                        <input class="@error('proprioPrice') is-invalid @enderror" type="text"
                               placeholder="Preço Próprio" name="proprioPrice"
                               value="{{ $preco->unit_price_own }}">
                        @error('proprioPrice')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 mt-4 price-details">
                    <div class="col-md-6 mt-4 alinhaTextoCentro">
                        <label>Desconto Catálogo:</label>
                        <input class="@error('discountCatalog') is-invalid @enderror" type="text" placeholder="Desconto Catálogo" name="discountCatalog"
                               value="{{ $preco->unit_price_catalog_discount }}">
                        @error('discountCatalog')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-4 alinhaTextoCentro">
                        <label>Desconto Próprio:</label>
                        <input class="@error('discountProprio') is-invalid @enderror" type="text" placeholder="Desconto Catálogo" name="discountProprio"
                               value="{{ $preco->unit_price_catalog_discount }}">
                        @error('discountProprio')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 mt-4 price-details">
                    <div class="col-md-12 mt-4 alinhaTextoCentro">
                        <label>Quantidade para Desconto:</label>
                        <input class="@error('quanti') is-invalid @enderror" type="text" placeholder="Quantidade para Desconto" name="quanti"
                               value="{{ $preco->qty_discount }}">
                        @error('quanti')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mt-4 alinhaTextoCentro">
                <div class="col-md-12 d-flex center">
                    <button type="submit" class="btn btn-success" name="ok" form="form_editarPrice">Guardar
                        Alterações
                    </button>
                </div>
            </div>
        </div>
    </form>
@endforeach

<script>
    function mostrarForm(formId) {
        var form = document.getElementById(formId);
        if (form.style.display === "none") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }
</script>
