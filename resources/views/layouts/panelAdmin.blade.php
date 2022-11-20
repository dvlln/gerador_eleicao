<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gerador de eleicoes - @yield('title')</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/fontawesome-free/css/all2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
        <div id="wrapper">

        <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
                <div class="sidebar-brand d-flex align-items-center justify-content-center">

                    <div class="sidebar-brand-text mx-3">LinkeTinder</div>
                </div>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                        <i class="fa fa-solid fa-house-user"></i>
                        <span>Dashboard</span>
                    </a>
                    <a class="nav-link" href="{{ route('admin.eleicao.index') }}">
                        <i class="fas fa-person-booth"></i>
                        <span>Eleições</span>
                    </a>
                </li>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
                <div id="content">

                <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>

                    <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">

                         <!-- Nav Item - User Information -->
                         <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{auth()->user()->name}}
                                </span>
                                <i class="fa fa-user"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                {{-- Sair --}}
                                <form method="POST" action="{{route('auth.login.destroy')}}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Sair
                                    </button>
                                </form>
                                {{-- Editar perfil --}}
                                <button class="dropdown-item" type="button" id="buttonEditPerfil">
                                        <i class="fas fa-regular fa-user-pen fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Editar perfil
                                </button>
                                {{-- Editar empresa --}}
                                <button class="dropdown-item" type="button" data-toggle="modal" data-target="#editEmpresa">
                                    <i class="fas fa-solid fa-building fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Editar empresa
                                </button>
                            </div>
                        </li>

                        {{-- MODAL Edital perfil --}}
                        <div class="modal fade" id="modalEditPerfil" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal_title">Editar perfil</h5>
                                    </div>
                                    <form action="{{ route('user.update', $users->id) }}" method="POST" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="{{ url('storage/perfil/'.$users->foto) }}" alt="perfilFoto" style="width: 100%; height: auto;">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="name">Nome</label>
                                                        <input
                                                            type="text"
                                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                            id="name"
                                                            name="name"
                                                            value="{{ isset($users) ? $users->name : '' }}"
                                                        />
                                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="email">E-mail</label>
                                                        <input
                                                            type="text"
                                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                            id="email"
                                                            name="email"
                                                            value="{{ isset($users) ? $users->email : '' }}"
                                                        />
                                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="perfilFoto">Alterar foto de perfil</label>
                                                        <input
                                                            type="file"
                                                            class="form-control {{ $errors->has('foto') ? 'is-invalid' : '' }}"
                                                            id="perfilFoto"
                                                            name="foto"
                                                        />
                                                        <div class="invalid-feedback">{{ $errors->first('foto') }}</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="password">Nova senha</label>
                                                        <input
                                                            type="password"
                                                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                            id="password"
                                                            name="password"
                                                        />
                                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="password_confirmation">Confirmar senha</label>
                                                        <input
                                                            type="password"
                                                            class="form-control"
                                                            id="password_confirmation"
                                                            name="password_confirmation"
                                                        />
                                                        <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        </ul>
                    </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <div class="d-flex justify-content-between">
                            <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>
                            @yield('import')
                        </div>
                        <!-- Page Heading -->

                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session()->has('warning'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session('warning') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <main class="pb-5">
                            <!-- CONTEÚDO -->
                            @yield('content')
                        </main>

                    </div>
                <!-- /.container-fluid -->

                </div>
            <!-- End of Main Content -->

            <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>&copy; Gerador de eventos {{ date('Y') }}</span>
                        </div>
                    </div>
                </footer>
            <!-- End of Footer -->

            </div>
        <!-- End of Content Wrapper -->

        </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button -->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    <!-- End of Scroll to Top Button -->

    <!-- Bootstrap core JavaScript -->
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- End of Bootstrap core JavaScript -->

    <!-- Custom scripts for all pages -->
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-mask/jquery.mask.min.js') }}"></script>

        {{-- Abre e fecha modal --}}
        @if ($flag === 0)
            <script>
                $(document).ready(function(){
                    $("#buttonEditPerfil").click(function(){
                    $("#modalEditPerfil").modal();
                    });
                });
            </script>
        @else
            <script>
                $(document).ready(function(){
                    $("#buttonEditPerfil").click(function(){
                    $("#modalEditPerfil").modal();
                    });
                    $("#buttonEditPerfil").toggleClass([function(){
                        $("#modalEditPerfil").modal();
                    }]);
                });
            </script>
        @endif

    <!-- End of Custom scripts for all pages -->

    @yield('js')
</body>

</html>
