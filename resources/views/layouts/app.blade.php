<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(!empty($title))
        <title>{{$title}} | {{config('app.name')}}</title>
    @else
        <title>{{config('app.name')}}</title>
    @endif

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="jquery-3.2.1.min.js"></script>
    
</head>
<body>
    <div id="app">
        @include('inc.navbar')
        <!-- @include('inc.messages') -->
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
    <script>
        $(document).ready(function() {
        // get current URL path and assign 'active' class
        var pathname = window.location.pathname;
        $('.nav > li > a[href="'+pathname+'"]').parent().addClass('active');
    })
    </script>
</body>
</html>
