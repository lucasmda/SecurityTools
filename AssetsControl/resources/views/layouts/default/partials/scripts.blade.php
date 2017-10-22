<!-- Scripts Include -->
<script type="text/javascript">var url = "{{ url('/') }}";</script>
<script type="text/javascript" src="{{ asset('plugins/jQuery/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/PopperJS/popperjs.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-4.0.0-beta/js/bootstrap.min.js') }}"></script>
@if(isset($datatables) && $datatables == true)
<script src="{{ asset('plugins/datatables/media/js/jquery.dataTables.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('plugins/datatables/media/js/dataTables.bootstrap4.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/vfs_fonts.js') }}"></script>
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
