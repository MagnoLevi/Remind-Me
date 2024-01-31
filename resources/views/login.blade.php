@extends('layout.main')

@section('css')
    @vite('/resources/css/login.css')
@endsection

@section('body_content')

    <body>
        @include('layout.top_menu')

        <div class="div-center">
            <div class="main-container">
                {{-- LOGIN DIV --}}
                <div id="login_div" style="display: {{ Session::get('errors') ? 'none' : 'flex' }};">

                    {{-- TITLE --}}
                    <p class="title">
                        LOGIN
                    </p>

                    {{-- SUB TITLE --}}
                    <p class="sub-title">
                        Welcome to Remind Me, I will help you with your abababa ababab duba duba duuu badu
                    </p>

                    {{-- INPUTS --}}
                    <form action=" {{ route('login.authenticate') }}" method="POST">
                        @csrf
                        <div class="text-end text-danger">{{ Session::get('error') }}</div>

                        <div class="form-container">
                            <input name="email" class="input-form" type="email" placeholder="Email" required>
                            <i class="icon-form fas fa-user"></i>
                        </div>

                        <div class="form-container">
                            <input name="password" class="input-form" type="password" placeholder="Password" required>
                            <i class="icon-form fas fa-lock"></i>

                            <p class="forgot-password">Forgot Password?</p>
                        </div>

                        <button class="btn-form">LOGIN</button>
                    </form>

                    {{-- SOCIAL --}}
                    <div class="social-login">
                        <label class="more-info-text">Or login with</label>
                        <div class="social-container">
                            <button>
                                <i class="fab fa-facebook-f"></i>
                            </button>

                            <button>
                                <i class="fab fa-google"></i>
                            </button>

                            <button>
                                <i class="fab fa-linkedin-in"></i>
                            </button>
                        </div>
                    </div>

                    {{-- CREATE ACCOUNT OR LOGIN --}}
                    <div class="register-or-login">
                        New to Remind Me? Create an account
                    </div>
                </div>


                {{-- REGISTER DIV --}}
                <div id="register_div" style="display: {{ Session::get('errors') ? 'flex' : 'none' }};">
                    {{-- TITLE --}}
                    <p class="title">
                        SIGN UP
                    </p>

                    {{-- SUB TITLE --}}
                    <p class="sub-title">
                        Welcome to Remind Me, I will help you with your abababa ababab duba duba duuu badu
                    </p>

                    {{-- INPUTS --}}
                    <form action=" {{ route('login.store') }}" method="POST">
                        @csrf

                        <div class="text-end text-danger">
                            @if ($errors = Session::get('errors'))
                                @foreach (Session::get('errors') as $error)
                                    {{ $error }} <br>
                                @endforeach
                            @endif
                        </div>

                        <div class="form-container">
                            <input name="email" class="input-form" type="email" placeholder="Email" required>
                            <i class="icon-form fas fa-user"></i>
                        </div>

                        <div class="form-container">
                            <input name="password" class="input-form" type="password" placeholder="Password" min="6"
                                required>
                            <i class="icon-form fas fa-lock"></i>
                        </div>

                        <div class="form-container">
                            <input name="password_confirm" class="input-form" type="password" placeholder="Confirm Password"
                                min="6" required>
                            <i class="icon-form fas fa-lock"></i>

                            <p class="forgot-password">Forgot Password?</p>
                        </div>

                        <button type="submit" class="btn-form">Sign Up</button>
                    </form>

                    {{-- SOCIAL --}}
                    <div class="social-login">
                        <label class="more-info-text">Or Sign Up with</label>
                        <div class="social-container">
                            <button>
                                <i class="fab fa-facebook-f"></i>
                            </button>

                            <button>
                                <i class="fab fa-google"></i>
                            </button>

                            <button>
                                <i class="fab fa-linkedin-in"></i>
                            </button>
                        </div>
                    </div>

                    {{-- CREATE ACCOUNT OR LOGIN --}}
                    <div class="register-or-login">
                        Already have an account? Log in
                    </div>
                </div>


                {{-- FORGOT PASSWORD DIV --}}
                <div id="forget_pass_div">
                    {{-- TITLE --}}
                    <p class="title">
                        FORGET PASSWORD
                    </p>

                    {{-- SUB TITLE --}}
                    <p class="sub-title">
                        Welcome to Remind Me, I will help you with your abababa ababab duba duba duuu badu
                    </p>

                    {{-- INPUTS --}}
                    <form action=" {{ route('login.forget-password') }}" method="POST">
                        @csrf
                        <div class="form-container" style="margin-bottom: 10px;">
                            <input name="email" class="input-form" type="email" placeholder="Email">
                            <i class="icon-form fas fa-user"></i>
                        </div>

                        <button class="btn-form" style="margin: 10px auto 32px auto;">Send</button>
                    </form>

                    {{-- CREATE ACCOUNT OR LOGIN --}}
                    <div class="register-or-login">
                        Already have an account? Log in
                    </div>
                </div>
            </div>
        </div>

    </body>
@endsection

@section('js')
    @vite('resources/js/remind_me/login.js')
@endsection
