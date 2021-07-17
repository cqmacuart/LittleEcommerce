<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('parts.head')
    <body>
        <div class="wrapper" id="app">
            <App ruta="{{route('basepath')}}"></App>
        </div>
        @include('parts.scripts')
    </body>
</html>
