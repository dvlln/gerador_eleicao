<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/sb-admin-2.min.css') }}">
</head>
<body>

<h1 class="text-center my-4">Criar conta</h1>

<div class="card shadow my-5 w-75 mx-auto">
    <div class="card-body">
        <form method="POST" action="{{ route('auth.register.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input
                            type="text"
                            name="name"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            placeholder="Nome"
                            value="{{ old('name') }}"
                        >
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input
                            type="email"
                            name="email"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            placeholder="E-mail"
                            value="{{ old('email') }}"
                        >
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    </div>
                </div>
                <div class="col-md-6">  
                        <div class="form-group">     
                            <input
                                type="text"
                                name="cpf"
                                class="form-control cpf {{ $errors->has('cpf') ? 'is-invalid' : ''}}"
                                placeholder="CPF"
                                value="{{ old('cpf') }}"
                            >
                            <div class="invalid-feedback">{{ $errors->first('cpf')}}</div>

                        </div>
                    </div>
                <div class="col-12 col-md-6">
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
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Confirmar senha"
                        >
                    </div>
                </div>

                <button class="btn btn-block btn-primary mt-3" type="submit">Enviar</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
