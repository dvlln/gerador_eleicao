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
                        <form action="{{ route('password.email') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row justify-content-between">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input
                                            type="email"
                                            name="email"
                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                            placeholder="E-mail"
                                        >
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5">
                                    <a class="btn btn-danger btn-block my-1" href="{{ route('auth.login.home') }}">
                                        Voltar
                                    </a>
                                </div>
                                <div class="col-12 col-md-5">
                                    <button type="submit" class="btn btn-success btn-block my-1">
                                        Enviar
                                    </button>
                                </div>
                            </div>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
