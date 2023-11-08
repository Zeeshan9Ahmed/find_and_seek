<?php $active = ($path == "admin/dashboard"?"active":""); ?>
<li class="nav-item has-treeview">
    <a href="{{ url('admin/dashboard') }}" class="nav-link {{ $active }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>