<!-- Scripts Include -->
<script type="text/javascript">var url = "{{ url('/') }}";</script>
<script type="text/javascript" src="{{ asset('plugins/jQuery/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/PopperJS/popperjs.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-4.0.0-beta/js/bootstrap.min.js') }}"></script>
@if(isset($datatables) && $datatables == true)
<script src="{{ asset('plugins/DataTables/dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>
@endif
@if (count($errors) > 0)
<script type="text/javascript">
@foreach ($errors->all() as $error)
$("#validation").append("<li>{{$error}}</li>");
@endforeach
$("#validation").append("</ol>");
</script>
@endif

<!-- Custom Scripts -->
@yield('customJS')
