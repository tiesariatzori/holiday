<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="fullscreen-bg">

<head>
    <title>@yield('title', 'Holiday')</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="holiday-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.2/r-3.0.0/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <link href="{{ asset('css\app.css') }}" rel="stylesheet">
    <link href="{{ asset('css\jquery.datetimepicker.min.css') }}" rel="stylesheet">
</head>

<body>
    @if (auth()->user())
        <div class="container justify-content-center">
            <nav class="container col-sm-12 navbar navbar-dark bg-dark bg-gradient">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div><a class="btn btn-secondary text-white " href="{{ route('logout') }}">Logout</a></div>
                </div>
            </nav>
        </div>
        <div class="d-flex justify-content-center">
            <div class="container collapse col-sm-12" id="navbarToggleExternalContent">
                <div class="bg-dark ps-4 pt-2 pb-2">
                    <div class="container">
                        <div><a class="pb-2 text-white" href="{{ route('home.index') }}">Home</a></div>
                        <div><a class="pb-2 text-white " href="{{ route('plan.index') }}">Vacation Plan</a></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('partials.alerts')
    @include('register')
    @yield('main')

    <script src="https://kit.fontawesome.com/2a4d6ba719.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"
        integrity="sha256-UnTxHm+zKuDPLfufgEMnKGXDl6fEIjtM+n1Q6lL73ok=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
        integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.2/r-3.0.0/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <script src="{{ asset('js\panel\utility.js') }}"></script>
    <script src="{{ asset('js\panel\vacation.js') }}"></script>
    <script src="{{ asset('js\register.js') }}"></script>
    <script src="{{ asset('js\jquery.deserialize.js') }}"></script>
    <script src="{{ asset('js\jquery.datetimepicker.full.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.register({
                ajax: true,
                url: {
                    base: "{{ route('login') }}",
                }
            });
            $.register().validations();
        });
    </script>
    @stack('scripts')
</body>

</html>
