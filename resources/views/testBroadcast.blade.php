<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <div class="card">
        <div class="card-header">
            <span><strong>Hey</strong></span>
            <button class="btn btn-danger float-right">Delete</button>
        </div>
        <div class="card-body"></div>
    </div>

    <ul>
        @foreach ($reliefGoods as $reliefGood)
            @can('view', $reliefGood)
                <li>{{ $reliefGood->name }}</li>
            @endcan
        @endforeach
    </ul>



<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
