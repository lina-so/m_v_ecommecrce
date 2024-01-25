<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach ($items as $item)
            <li class="nav-item menu-open">
                <a href="{{ route($item['route']) }}" class="nav-link  {{ $item['route'] == $active ? 'active' : '' }}">
                    <p>
                        {{ $item['title'] }}
                        {{-- @if (isset($item['submenu']) && is_array($item['submenu'])) --}}
                        <i class="right fas fa-angle-left"></i>
                    {{-- @endif --}}
                    </p>
                </a>
                {{-- partial ul --}}
                @if (isset($item['submenu']) && is_array($item['submenu']))

                <ul class="nav nav-treeview">
                    @foreach ($item['submenu'] as $sub)
                    <li class="nav-item">
                        <a href="{{ route($sub['route']) }}" class="nav-link">
                            <i class="{{ $sub['icon'] }}"></i>
                            <p>{{ $sub['title'] }}</p>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif

            </li>
        @endforeach


    </ul>
</nav>
<!-- /.sidebar-menu -->

