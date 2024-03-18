<div class="col-sm-12">
    <form action="{{ isset($route)?$route:route('plan.store') }}" method="POST" id="vacation-form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{ old('id', $model->id) }}">
        <input type="hidden" name="_method" value="{{ isset($method) ? $method : 'POST' }}" />
        {{csrf_field()}}
        <div class="col-12 mb-2 ">
            <div class="form-group">
                <label class="form-label"for="title">Title:</label>
                <input type="text" name="title" placeholder="Title" required="required" class="form-control"
                    value="{{ old('title', $model->title) }}">
                @if ($errors->has('name'))
                    <div class="col-sm-12 text-danger">
                        <strong>{{ $errors->first('name') }}</strong>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12 mb-2">
            <div class="form-group">
                <label class="form-label"for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Description" class="form-control" rows="3">{{ old('description', $model->description) }}</textarea>
                @if ($errors->has('description'))
                    <div class="col-sm-12 text-danger">
                        <strong>{{ $errors->first('description') }}</strong>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12 mb-2">
            <div class="form-group">
                <label class="form-label"for="location">Location:</label>
                <input type="text" name="location" placeholder="Location" required="required" class="form-control"
                    value="{{ old('location', $model->location) }}">
                @if ($errors->has('location'))
                    <div class="col-sm-12 text-danger">
                        <strong>{{ $errors->first('location') }}</strong>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12 mb-2">
            <div class="form-group">
                <label class="form-label"for="participant">Participant:</label>
                <input type="text" name="participant" placeholder="Participant" class="form-control"
                    value="{{ old('participant', $model->participant) }}">
                @if ($errors->has('participant'))
                    <div class="col-sm-12 text-danger">
                        <strong>{{ $errors->first('participant') }}</strong>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12 mb-2">
            <div class="form-group">
                <label class="form-label"for="date_initial">Date Initial: </label>
                <input type="text" name="date_initial" placeholder="Date Initial"  class="form-control"
                    value="{{ old('date_initial', $model->date_initial) }}">
                @if ($errors->has('date_initial'))
                    <div class="col-sm-12 text-danger">
                        <strong>{{ $errors->first('date_initial') }}</strong>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12 mb-2">
            <div class="form-group">
                <label class="form-label"for="date_final">Date Final:</label>
                <input type="text" name="date_final" placeholder="Date Final"  class="form-control"
                    value="{{ old('date_final', $model->date_final) }}">
                @if ($errors->has('date_final'))
                    <div class="col-sm-12 text-danger">
                        <strong>{{ $errors->first('date_final') }}</strong>
                    </div>
                @endif
            </div>
        </div>
        <div class="row p-2">
            <div class="col-sm-12 text-center">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i>
                        Save
                    </button>
                    @if(!isset($ajax))
                        <a href="{{route('plan.index')}}" class="btn btn-default">
                            <i class="fa fa-bars"></i>
                            Back
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
