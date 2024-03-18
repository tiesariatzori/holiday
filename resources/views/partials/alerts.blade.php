@if (Session::has('success'))
    <div class="d-flex justify-content-center">
        <div class="col-sm-6 alert alert-success alert-dismissible fade show mt-5" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>
        </div>
    </div>
@endif

@if (Session::has('error'))
    <div class="d-flex justify-content-center">
        <div class="col-sm-6 alert alert-danger alert-dismissible  fade show mt-5" role="alert">
            <strong>{{ session('error') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>
        </div>
    </div>
@endif
