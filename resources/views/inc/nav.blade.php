
<nav class="navigation">
    <div class="navigation--darkened-layer"></div>

    <div class="navigation--bar">
        {{--  <a href="#" class="navigation--collapse-toggle">menu</a>  --}}

        <a class="navigation--collapse-toggle hamburger hamburger--elastic" aria-label="Menu" aria-controls="navigation">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </a>
{{--  
        <a class="navigation--logo" href="{{ route('dashboard') }}">
            {{ config('app.name', 'Laravel') }} 
        </a>  --}}
{{--  
        @auth
        <span>{{ Auth::user()->name }}</span>
        @endauth  --}}
    </div>


    <div class="navigation--collapse">
        
        @auth
        <ul class="navigation--group">
            <li><a href="#">{{ Auth::user()->name }}</a></li>
        </ul>

        <ul class="navigation--group">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('projects.index') }}">Projects</a></li>
            <li><a href="{{ route('tasks.index') }}">Tasks</a></li>
            <li><a href="{{ route('timeentries.index') }}">Time Entries</a></li>
        </ul>
        @endauth


        <!-- Right Side Of Navbar -->
        <ul class="navigation--group">
            <!-- Authentication Links -->
            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @else
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>