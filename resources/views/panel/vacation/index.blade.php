@extends('index')
@section('title')
    Vacation Plan
@endsection
@section('main')
    <main class="w-100 h-100 d-flex pt-5">
        <form class="container" action="{{ route('plan.export') }}" method="POST" id="vacation-export"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="export" value="1">
            <div id="index-vacation">
                <div class="card">
                    <div class="card-header bg-dark bg-gradient">
                        <h3 class="text-white">Vacation Plan</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-12 text-center pb-3 pt-3">
                            <div class="btn-group" role="group">
                                <button type="button" id="vacation-add" class="btn btn-primary ">Create</button>
                                <button type="submit" class="btn btn-secondary">Export</button>
                            </div>
                        </div>
                        <table id="tablePlan" class="table table-striped table-bordered col-sm-12">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Location</th>
                                    <th>Participants</th>
                                    <th>Date Initial</th>
                                    <th>Date Final</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </main>
    @include('panel.vacation.modais')
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
            $.vacation().index();
            $.vacation().validations();
        });
    </script>
@endpush
