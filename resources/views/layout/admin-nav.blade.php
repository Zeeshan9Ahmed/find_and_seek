<?php $path = Request::path(); ?>
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">



  @includeIf('layout.module-nav.dashboard')
  {{--@includeIf('layout.module-nav.generes') --}}
  @includeIf('layout.module-nav.users')
  @includeIf('layout.module-nav.notifications') 
  
  @includeIf('layout.module-nav.common-pages')
 
</ul>
