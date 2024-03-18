@extends($ajax ? 'clean' : 'base-show')
@section('display')
    Display Vacation Plan
@endsection
@section('show')
    <div class="col-sm-12">
        <label for="title" class="form-label">Title:</label><br>
        <div class="form-control-static pb-2">{{ $model->title }}</div>
    </div>
    <div class="col-sm-12">
        <label for="participant" class="form-label">Participants: </label><br>
        <div class="form-control-static pb-2">{{ $model->participant ? $model->participant : '-' }}</div>
    </div>
    <div class="col-sm-12">
        <label for="location" class="form-label">Location: </label><br>
        <div class="form-control-static pb-2">{{ $model->location }}</div>
    </div>
    <div class="col-sm-12">
        <label for="date_initial" class="form-label">Data Initial:</label><br>
        <div class="form-control-static pb-2">{{ $model->getDate('date_initial') }}</div>
    </div>
    <div class="col-sm-12">
        <label for="date_final" class="form-label">Data Final</label><br>
        <div class="form-control-static pb-2">{{ $model->getDate('date_final') }}</div>
    </div>
@endsection
