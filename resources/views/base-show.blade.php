@extends('index')
@section('title')
  Display Vacation Plan
@endsection
@section('main')
    <main class="w-100 h-100 d-flex pt-5">
        <div class="container" id="index-vacation">
            <div class="card">
                <div class="card-header bg-dark bg-gradient">
                    <h3 class="text-white">@yield('display')</h3>
                </div>
                <div class="card-body">
                    @yield('show')
                </div>
            </div>
        </div>
    </main>
@endsection
