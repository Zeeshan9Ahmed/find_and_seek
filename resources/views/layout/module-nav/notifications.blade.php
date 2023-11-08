<?php $active = ($path == "admin/technicians" || $path == "admin/blocked-users"?"active":""); ?>
<li class="nav-item has-treeview {{ ($active == 'active'?"menu-open":"") }}" >
    <a href="#" class="nav-link">
        <i class="nav-icon fas "></i>
        <p>Notifications<i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.send.notification') }}" class="nav-link {{ ($path == "admin/technicians"?"active":"") }}">
                <i class="nav-icon far nav-icon"></i>
                <p>Send Notification</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.view.notification') }}" class="nav-link {{ ($path == "admin/technicians"?"active":"") }}">
                <i class="nav-icon far  nav-icon"></i>
                <p>Users Notifications</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.admin.notification') }}" class="nav-link {{ ($path == "admin/technicians"?"active":"") }}">
                <i class="nav-icon far  nav-icon"></i>
                <p>Admin Notifications</p>
            </a>
        </li>
    </ul>
</li>