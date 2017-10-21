<!-- Scripts Include -->
<script type="text/javascript">var url = "{{ url('/') }}";</script>
<script type="text/javascript" src="{{ asset('plugins/jQuery/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/PopperJS/popperjs.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-4.0.0-beta/js/bootstrap.min.js') }}"></script>

<!-- Custom Scripts -->
@yield('customJS')
