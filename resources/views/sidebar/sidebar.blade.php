<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                @foreach ($menus as $menu)
                    <li class="submenu {{ set_active($menu->active_routes) }} 
                        {{ (isset($menu->pattern) && request()->is($menu->pattern)) ? 'active' : '' }}">
                        <a href="{{ $menu->route ? route($menu->route) : '#' }}">
                            <i class="{{ $menu->icon }}"></i>
                            <span>{{ $menu->title }}</span>
                            @if ($menu->children->count())
                                <span class="menu-arrow"></span>
                            @endif
                        </a>
                        @if ($menu->children->count())
                            <ul>
                                @foreach ($menu->children as $child)
                                    <li>
                                        <a href="{{ $child->route ? route($child->route) : '#' }}" 
                                           class="{{ set_active($child->active_routes) }} 
                                                  {{ (isset($child->pattern) && request()->is($child->pattern)) ? 'active' : '' }}">
                                            {{ $child->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>












