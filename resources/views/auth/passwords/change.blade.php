@extends('template.layout')
@section('titulo', '')
@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-light">Alterar Senha</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.change.store') }}" novalidate>
                            @csrf
                            <div class="row mb-3">
                                <label for="currentpassword" class="col-md-4 col-form-label text-md-end">
                                    Senha atual</label>
                                <div class="col-md-6">
                                    <input id="currentpassword" type="password"
                                           class="form-control @error('currentpassword') is-invalid @enderror"
                                           name="currentpassword" required>
                                    @error('currentpassword')
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Nova Senha</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">
                                    Confirmar Senha</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Alterar Senha
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
