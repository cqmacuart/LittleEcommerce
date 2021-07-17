<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('parts.head')
    <body>
        <div class="wrapper" id="app">
            @if (Auth::check())
            <Admin ruta="{{route('basepath')}}"></Admin>
            @else
            <Auth ruta="{{route('basepath')}}"></Auth>
            @endif
        </div>
        @include('parts.scripts')
    </body>
</html>
