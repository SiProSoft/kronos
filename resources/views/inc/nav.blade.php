
<nav class="navigation">
    <div class="navigation--darkened-layer"></div>

    <div class="navigation--bar">

        <a class="navigation--collapse-toggle hamburger hamburger--slider" aria-label="Menu" aria-controls="navigation">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </a>
    </div>

    <div class="navigation--collapse">
        <div class="navigation--cover-image" style="background-image: url({{ asset('img/background/1.jpeg') }})">
            <div class="navigation--profile-image">
                <img src="https://www.easyflow.dk/media/1060/signar_web.jpg?width=360&height=418" alt="">
            </div>
            <div class="navigation--cover-name">{{ Auth::user()->name }}</div>
        </div>

        @auth
        
        @php
            $navigationItems = array(
                array('title' => 'Dashboard', 'url' => route('dashboard'), 'icon' => 'dashboard'),
                array('title' => 'Projects', 'url' => route('projects.index'), 'icon' => 'apps'),
                array('title' => 'Tasks', 'url' => route('tasks.index'), 'icon' => 'check'),
                array('title' => 'Time Entries', 'url' => route('timeentries.index'), 'icon' => 'access_time'),
            );
        @endphp

        <ul class="navigation--group">
            @foreach ($navigationItems as $item)
                <li class="navigation--group-item {{ url()->current() == $item['url'] ? 'active' : ''}}">
                    <a href="{{$item['url']}}">
                        <i class="material-icons">{{$item['icon']}}</i>{{$item['title']}}
                    </a>
                </li>
            @endforeach
        </ul>
        @endauth


        <ul class="navigation--group">
            @guest
                <li class="navigation--group-item"><a href="{{ route('login') }}">Login</a></li>
                <li class="navigation--group-item"><a href="{{ route('register') }}">Register</a></li>
            @else
                <li class="navigation--group-item">
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