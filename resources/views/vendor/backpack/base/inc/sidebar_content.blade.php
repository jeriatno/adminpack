<?php
$permissions = auth()->user()->getAllPermissions();
?>


@include('components.menu', [
    'menu' => 'Your Menu',
    'icon' => 'fa fa-table'
])

<li class="treeview">
    <a href="#"><i class="fas fa-users"></i> <span>User Managements</span> <i class="fa fa-angle-right pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{ backpack_url('user') }}"><i class="fa fa-circle-o"></i> <span>Users</span></a></li>
        <li><a href="{{ backpack_url('role') }}"><i class="fa fa-circle-o"></i> <span>Roles</span></a></li>
        <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-circle-o"></i> <span>Permissions</span></a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#"><i class="fa fa-layer-group"></i> <span>Master Data</span><i class="fa fa-angle-right pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-circle-o"></i> <span>New Data</span></a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#"><i class="fa fa-cog"></i> <span>Configurations</span><i class="fa fa-angle-right pull-right"></i></a>
    <ul class="treeview-menu">
        <li class="treeview">
            <a href="#"><i class="fa fa-circle-o"></i> <span>Global Configs</span><i class="fa fa-angle-right pull-right"></i></a>
        </li>
    </ul>
</li>

