@extends('layouts.login')
@push('styles')
    <style>
        .company-img {
            width: 350px;
            height: 300px;
        }

        /* Móviles (menos de 768px) */
        @media (max-width: 767.98px) {
            .company-img {
                padding-top: 0px;
                width: 120px;
                height: 120px;
            }
        }

        /* Tablets (entre 768px y 991.98px) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .company-img {
                width: 250px;
                height: 200px;
            }
        }

        /* Escritorio (mayores a 992px) */
        @media (min-width: 992px) {
            .company-img {
                width: 350px;
                height: 300px;
            }
        }
    </style>
@endpush
@push('scripts')
    <script>
        window.onload = function() {
            toastr.options = {
                positionClass: "toast-top-right",
                timeOut: 2000,
                progressBar: true,
            };
            const email = localStorage.getItem('email');
            const password = localStorage.getItem('password');

            if (email) {
                document.getElementById('email').value = localStorage.getItem('email');
            }
            if (password) {
                document.getElementById('password').value = localStorage.getItem('password');
            }

            if (email || password) {
                document.getElementById('rememberMe').checked = true;
            }

            document.getElementById('login-form').addEventListener('submit', function(event) {

                if (document.getElementById('rememberMe').checked) {
                    localStorage.setItem('email', document.getElementById('email').value);
                    localStorage.setItem('password', document.getElementById('password').value);
                } else {

                    localStorage.removeItem('email');
                    localStorage.removeItem('password');
                }

            });
        };
    </script>
    @if (session('error'))
        <script>
            toastr.error("Credenciales Incorrectas", 'Error');
        </script>
    @endif
@endpush

@section('content')
    <div class="animated fadeInDown d-md-flex align-items-center" style="height: 100vh;">
        <div class="d-md-flex col-12">
            <div class="col-md-5 d-flex justify-content-center justify-content-lg-end">
                <div>
                    <h2 class="text-white text-center" style="font-weight: 600"> BIBLIOTECA FICCT </h2>
                    <img class="company-img" src="{{asset('images/portada_ficct.jpg') }}"
                        alt="logo_company">
                </div>
            </div>
            <div class="col-md-7 d-md-flex justify-content-center">
                <div class="col-lg-7">
                    <h1 class="text-white text-center" style="font-weight: 600">  </h1>
                    <form class="mt-4 mb-5" role="form" method="POST" action="{{ route('auth.store') }}"
                        id="login-form">
                        @csrf
                        <div class="form-group position-relative">
                            <div class="d-flex align-items-center">
                                <input type="email" name="email" id="email"
                                    class="form-control rounded py-3 pl-5 pr-5 text-dark @error('email') border-danger @enderror"
                                    placeholder="correo" autocomplete="off" />

                                <i class="fa fa-user position-absolute fa-2x" aria-hidden="true"
                                    style="left: 15px; color: rgb(75, 73, 73);"></i>
                            </div>

                            @if ($errors->has('email'))
                                <p class="text-danger mt-2">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                        <div class="form-group position-relative">
                            <div class="d-flex align-items-center">
                                <input type="password" name="password" id="password"
                                    class="form-control rounded py-3 pl-5 pr-5 text-dark @error('password') border-danger @enderror"
                                    placeholder="contraseña" autocomplete="off">
                                <i class="fa fa-unlock-alt position-absolute fa-2x"
                                    aria-hidden="true"style="left: 15px; color: rgb(75, 73, 73);"></i>

                            </div>
                            @if ($errors->has('password'))
                                <p class="text-danger mt-2">{{ $errors->first('password') }}</p>
                            @endif
                        </div>

                        <button type="submit" class="btn rounded py-2 full-width m-b text-white"
                            style="background-color: #578994">
                            <h3> Iniciar Sesión</h3>
                        </button>

                        <a href="#">
                            <p class="text-white">¿Olvidaste tu contraseña?</p>
                        </a>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label text-white" for="rememberMe">Recordar mis datos</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
