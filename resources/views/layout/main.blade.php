<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta type="hidden">

    <link rel="icon" href="{{ asset('../image/remind_me_blue.png') }}" type="image/icon type">
    <title>Remind Me</title>

    {{-- FONTAWESOME --}}
    <script src="https://kit.fontawesome.com/ca8348cfb1.js" crossorigin="anonymous"></script>

    {{-- APP VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CSS --}}
    @vite(['/resources/css/base_styles.css', '/resources/css/top_menu.css'])
    @yield('css')

    {{-- BOOTSTRAP --}}
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.2/css/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap-5.3.2/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap-5.3.2/js/bootstrap.bundle.min.js') }}"></script>
</head>

{{-- BODY --}}
@yield('body_content')

{{-- JS --}}
@vite(['resources/js/remind_me/top_menu.js'])
@yield('js')

</html>
