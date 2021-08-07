<li class="dropdown user" style="margin-right: 35px">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <span class="badge">
            @switch(auth()->user()->role)
                @case("admin")
                A
                @break
                @case("content")
                C
                @break
                @case("manager")
                M
                @break
                @default
                <i class="fa fa-cog"></i>
            @endswitch
        </span>
        <span class="hidden-xs">
            {{ auth()->user()->email }}
        </span>

    </a>
    <ul class="dropdown-menu">
        <li class="user-footer">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-btn fa-sign-out"></i> Выход
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</li>
