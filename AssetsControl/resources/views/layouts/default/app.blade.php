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
@include('layouts.default.partials.header')
<body style="padding-top: 4rem;">
  @include('layouts.default.partials.topbar')
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
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12">
        @yield('breadCumb')
      </div>
    </div>
    @if(count($errors) > 0)
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div id="validation"class="alert alert-danger">
            <h6 class="alert-heading">Please, check the field(s) below!</h6>
            <hr>
            <ol>
          </div>
        </div>
      </div>
    @endif
    @if(Session::has('success'))
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div id="success"class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h6 class="alert-heading">{{Session::get('success')}}</h6>
          </div>
        </div>
      </div>
    @endif
    @yield('content')
  </section>
  <br>
  @include('layouts.default.partials.footer')
  @include('layouts.default.partials.scripts')
</body>
</html>
