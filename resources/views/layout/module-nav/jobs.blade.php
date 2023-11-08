<?php $active = ($path == "admin/jobs"?"active":""); ?>
<li class="nav-item has-treeview">
    <a href="{{ url('admin/jobs') }}" class="nav-link {{ $active }}">
        
    <i class="fa-thin fa-person-digging"></i>
        <p>Jobs</p>
    </a>
</li>