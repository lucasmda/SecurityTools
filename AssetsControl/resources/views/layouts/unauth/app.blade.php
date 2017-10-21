<!--
|--------------------------------------------------------------------------|
|         {{env('APP_NAME')}} - T-Systems Brazil Operations Security                  |
|                           {{env('APP_VERSION')}}                                         |
|--------------------------------------------------------------------------|
|                                                                          |
| This site is a property of T-Systems Brazil Security Team                |
|--------------------------------------------------------------------------|
-->
<!DOCTYPE html>
<html lang="en">
@include('layouts.unauth.partials.header')
<body style="padding-top: 4rem;">
  <section class="container-fluid">
    <div class="row">
      <div class="col-sm-12 col-md-8 col-lg-8">
        <h3>@yield('contentTitle')</h3>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4">
        @yield('subMenuRightActions')
      </div>
    </div>
    <br>
    @yield('content')
  </section>
  <br>
  @include('layouts.unauth.partials.scripts')
</body>
</html>
