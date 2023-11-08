<?php $active = ($path == "admin/technicians" || $path == "admin/blocked-users"?"active":""); ?>
<li class="nav-item has-treeview {{ ($active == 'active'?"menu-open":"") }}" >
    <a href="#" class="nav-link">
        <i class="nav-icon fas "></i>
        <p>Content<i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('admin/page/tc') }}" class="nav-link {{ ($path == "admin/users"?"active":"") }}">
                <i class="nav-icon far  nav-icon"></i>
                <p>Terms & conditions</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/page/pp') }}" class="nav-link {{ ($path == "admin/users"?"active":"") }}">
                <i class="nav-icon far  nav-icon"></i>
                <p>Privacy Policy</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/page/au') }}" class="nav-link {{ ($path == "admin/users"?"active":"") }}">
                <i class="nav-icon far  nav-icon"></i>
                <p>About Us</p>
            </a>
        </li>
        
    </ul>
</li>