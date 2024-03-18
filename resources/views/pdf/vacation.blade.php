<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css\bootstrap.min.css" rel="stylesheet">
    <title>Vacation Plan</title>
</head>

<body>
    <h1 class="text-center">Vacation Plan</h1>
    @foreach ($querys as $query)
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="text-center">{{ $query->title }}</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="participant" class="form-label">Participants: </label>
                        <div class="form-control-static pb-2">{{ $query->participant ? $query->participant : '-' }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="location" class="form-label">Location: </label>
                        <div class="form-control-static pb-2">{{ $query->location }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="date_initial" class="form-label">Date Initial:</label>
                        <div class="form-control-static pb-2">{{ $query->getDate('date_initial') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label for="date_final" class="form-label">Date Final:</label>
                        <div class="form-control-static pb-2">{{ $query->getDate('date_final') }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</body>

</html>
