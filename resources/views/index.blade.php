@extends('layout.main')

@section('css')
    {{-- @vite('/resources/css/login.css') --}}
@endsection

@section('body_content')

    <body>
        @include('layout.top_menu')
        {{ Auth::user() }}
    </body>
@endsection

@section('js')
    {{-- @vite('resources/js/remind_me/login.js') --}}
@endsection
