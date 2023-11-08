
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('assets/dist/js/demo.js') }}"></script>

<!-- PAGE PLUGINS -->
<?php if(Request::path() == "admin/statistics"){ ?>
<!-- jQuery Mapael -->
<script src="{{ url('public/assets/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ url('public/assets/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ url('public/assets/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ url('public/assets/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ url('public/assets/plugins/chart.js/Chart.min.js') }}"></script>
<?php } ?>
<!-- PAGE SCRIPTS -->
{{-- <script src="{{ asset('assets/dist/js/pages/dashboard2.js') }}"></script> --}}

<!-- DataTables -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>


<!-- bs-custom-file-input -->
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>


<!-- jquery.validationEngine-en.js -->
<script src="{{ asset('assets/plugins/jquery-ve/js/languages/jquery.validationEngine-en.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('assets/plugins/jquery-ve/js/jquery.validationEngine.js') }}" type="text/javascript" charset="utf-8"></script>
<!-- ajaxform js -->
<script src="{{ asset('assets/plugins/ajaxform/toaster.js') }}"></script>
<script src="{{ asset('assets/plugins/ajaxform/browser.min.js') }}"></script>
<script src="{{ asset('assets/plugins/ajaxform/ajaxform.js') }}"></script>
<script src="{{ asset('assets/plugins/ajaxform/ajaxcustom.js') }}"></script>
   
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
<!-- Mycsutom js SCRIPTS -->
<script src="{{ asset('assets/js/mycustom.js') }}"></script>
