@php
    $permissions = auth()->user()->getAllPermissions();
@endphp

@if (!isset($permission) || (is_array($permission)
    ? collect($permission)->some(function ($perm) use ($permissions) {
        return $permissions->contains('name', $perm);
    })
    : $permissions->contains('name', $permission)))
    <li class="treeview">
        <a href="#">
            <i class="{{ $icon ?? 'fas fa-table' }}"></i>
            <span>
                {{ $menu }}
                @if (isset($useNotif))
                    <span class="notif-badge" id="{{ \Str::slug($menu) }}-badge"></span>
                @endif
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if (isset($submenu))
                @foreach ($submenu as $item)
                @if (!isset($item['permission']) || (is_array($item['permission'])
                    ? collect($item['permission'])->some(function ($perm) use ($permissions) {
                        return $permissions->contains('name', $perm);
                    })
                    : $permissions->contains('name', $item['permission'])))
                    <li class="{{ isset($item['submenu']) ? 'treeview' : '' }}">
                        <a href="{{ isset($item['url']) ? backpack_url($item['url']) : '#' }}">
                            <i class="{{ $item['icon'] ?? 'fa fa-circle-o' }}"></i>
                            <span>
                                {{ $item['label'] }}
                                @if (isset($item['useNotif']))
                                    <span class="notif-badge" id="{{ \Str::slug($item['label']) }}-badge"></span>
                                @endif
                            </span>
                            @if (isset($item['submenu']))
                                <i class="fa fa-angle-right pull-right"></i>
                            @endif
                        </a>
                        @if (isset($item['submenu']))
                            <ul class="treeview-menu">
                                @foreach ($item['submenu'] as $subItem)
                                    @if (!isset($subItem['permission']) || (is_array($subItem['permission'])
                                        ? collect($subItem['permission'])->some(function ($perm) use ($permissions) {
                                            return $permissions->contains('name', $perm);
                                        })
                                        : $permissions->contains('name', $subItem['permission'])))
                                        <li>
                                            <a href="{{ backpack_url($subItem['url']) }}">
                                                <i class="{{ $subItem['icon'] ?? 'fa fa-circle-o' }}"></i>
                                                <span>
                                                    {{ $subItem['label'] }}
                                                    @if (isset($subItem['useNotif']))
                                                        <span class="notif-badge" id="{{ \Str::slug($subItem['label']) }}-badge"></span>
                                                    @endif
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach
            @endif
        </ul>
    </li>
@endif
