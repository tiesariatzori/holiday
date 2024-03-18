<div class="modal" id="register-modal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark bg-gradient">
                <h5 class="modal-title text-white">Register</h5>
                <button type="button" class="btn-close text-white close-modal" data-bs-dismiss="#register-modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <form action="#" method="POST" id="register-form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-12 mb-2 ">
                            <div class="form-group">
                                <label class="form-label"for="name">Name:</label>
                                <input type="text" name="name" placeholder="Name" required="required"
                                    class="form-control">
                                @if ($errors->has('name'))
                                    <div class="col-sm-12 text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <label class="form-label"for="email">Email:</label>
                                <input type="text" name="email" placeholder="Email" required="required"
                                    class="form-control">
                                @if ($errors->has('email'))
                                    <div class="col-sm-12 text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i>
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
