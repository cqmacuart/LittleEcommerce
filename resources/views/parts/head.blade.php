
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="max-age=43200" />
    <meta http-equiv="expires" content="43200"/>
    <meta name="robots" content="index"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('parts.meta')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/plantilla.css')}}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    {{-- PWA ASSETS --}}
    @laravelPWA

    <!-- Styles -->
</head>
