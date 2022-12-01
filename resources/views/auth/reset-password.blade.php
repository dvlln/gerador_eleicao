<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/sb-admin-2.min.css') }}">
</head>
<body>
    <h1 class="text-center my-4">Redefinir senha</h1>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">

                @if(session()->has('success'))
                <div class="alert alert-success"> {{ session('status')}}</div>
                @endif

                @if(session()->has('warning'))
                <div class="alert alert-warning"> {{ session('status')}}</div>
                @endif

                <div class="card shadow my-4 mx-auto">
                    <div class="card-body">
                        <form action="{{ route('password.update') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input
                                            type="password"
                                            name="password"
                                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                            placeholder="Senha"
                                        >
                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input
                                            type="password"
                                            name="password_confirmation"
                                            class="form-control"
                                            placeholder="Confirmar senha"
                                        >
                                    </div>
                                </div>
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <button type="submit" class="btn btn-success btn-block my-1">
                                    Enviar
                                </button>
                            </div>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
