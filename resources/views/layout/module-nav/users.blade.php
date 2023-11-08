<?php $active = ($path == "admin/technicians" || $path == "admin/blocked-users"?"active":""); ?>
<li class="nav-item has-treeview {{ ($active == 'active'?"menu-open":"") }}" >
    <a href="#" class="nav-link">
        <i class="nav-icon fas"></i>
        <p>Users <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.users') }}" class="nav-link {{ ($path == "admin/users"?"active":"") }}">
                <i class="nav-icon far nav-icon"></i>
                <p>Users List</p>
            </a>
        </li>
        
    </ul>
</li>