@extends('index')
@section('title')
    Login
@endsection
@section('main')
    <main class="w-100 h-100 d-flex">
        <div class="container-sm m-auto d-flex  justify-content-center">
            <div class="rounded card col-sm-6 align-items-sm-center shadow-lg border ">
                <form class="col-sm-7 p-2" method="POST" action="{{ route('login.attempt') }}">
                    @csrf
                    <h1 class="h1 mb-3 mt-5 text-center">Holiday</h1>
                    <div class="mb-4 text-center">
                        <img src="{{ asset('img/holiday-logo.png') }}" alt="" width="100" height="60">
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label for="email">Email:</label>
                        <input name="email" type="email" class="form-control" required placeholder="name@example.com"
                            value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <div class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label for="password">Password:</label>
                        <input name="password" type="password" class="form-control" required placeholder="password">
                        @if ($errors->has('password'))
                            <div class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="checkbox mb-1">
                        <label class="form-check-label" for="remember">
                            <input type="checkbox" name="remember" id="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    <div class="col-sm-12 mb-3 text-center ">
                        <a class="mb-2" id="create-accont" href="#">Create an account?</a>
                    </div>
                    <div class="text-center">
                    <button class="col-sm-12 btn btn-lg btn bg-dark bg-gradient mb-5 text-white" type="submit"> {{ __('Login') }}</button>
                    <div>
                </form>
            </div>
        </div>
    </main>
@endsection
