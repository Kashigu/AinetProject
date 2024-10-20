<img src="{{ $user->fullPhotoUrl }}" alt="Avatar" class="rounded-circle img-thumbnail" style="width: 260px">
@if ($allowUpload)
    <div class="mb-3 pt-3">
        <input type="file" class="form-control @error('file_foto') is-invalid @enderror" name="file_foto" id="inputFileFoto">
        @error('file_foto')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
@endif
@if (($allowDelete ?? false) && $user->photo_url)
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal">
        Apagar Foto
    </button>
@endif
