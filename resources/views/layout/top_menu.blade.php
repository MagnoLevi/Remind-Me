<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="d-flex alaign-items-center">
            <div class="dropdown">
                <a id="logo_top_menu" class="logo" href="{{ url('') }}">
                    <img id="logo_white" src="{{ asset('../../image/remind_me_white.png') }}" alt="Logo Remind Me"
                        style="max-width: 52px;">
                    <img id="logo_yellow" src="{{ asset('../../image/remind_me_yellow.png') }}" alt="Logo Remind Me"
                        style="max-width: 52px; display: none;">
                    Remind Me
                </a>
            </div>

            @if (Auth::user())
                <a class="{{ $nav == 'to_do' ? 'top-link-selected' : 'top-link' }} ms-3" href="{{ url('to-do') }}">To do</a>
            @endif
        </div>

        <div>
            @if (Auth::user())
                <a class="h4 log-in-out-top-menu" href="{{ route('login.logout') }}">
                    <i class="fa-solid fa-door-closed mr-2"></i>
                    Log Out
                </a>
            @endif

            @if (Auth::guest() && !request()->is('login'))
                <a class="h4 log-in-out-top-menu" href="{{ url('login') }}">
                    <i class="fa-solid fa-door-open mr-2"></i>
                    Log In
                </a>
            @endif
        </div>
    </div>
</nav>
