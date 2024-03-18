@extends('index')
@section('title')
    Create Vacation Plan
@endsection
@section('main')
    <main class="w-100 h-100 d-flex pt-5">
        <div class="container" id="index-vacation">
            <div class="card">
                <div class="card-header bg-dark bg-gradient">
                    <h3 class="text-white">Create Vacation Plan</h3>
                </div>
                <div class="card-body">
                    @include('panel.vacation.form')
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $.vacation({
                ajax: true,
                url: {
                    base: "{{ route('plan.index') }}",
                }
            });
            $.vacation().validations();
        });
    </script>
@endpush
