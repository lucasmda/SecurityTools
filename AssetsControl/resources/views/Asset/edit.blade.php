@extends('layouts.default.app')
@section('pageTitle') Assets @endsection
@section('contentTitle') Assets @endsection
@section('breadCumb')
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
  <a class="breadcrumb-item" href="{{ url('Asset') }}">Assets</a>
  <a class="breadcrumb-item">Edit</a>
</nav>
@endsection
@section('content')
<div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <br />
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12">
            <form action="{{ url('/Asset/update') }}" method="post">
              {{csrf_field()}}
              <div class="row">
                <div class="com-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <label for="wannacry">IPs WannaCry</label>
                    <textarea class="form-control" id="wannacry" name="wannacry" rows="9"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="com-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <label for="doublepulsar">IPs DoublePulsar</label>
                    <textarea class="form-control" id="doublepulsar" name="doublepulsar" rows="9"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="com-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <label for="vulneravel">IPs Vulneráveis</label>
                    <textarea class="form-control" id="vulneravel" name="vulneravel" rows="9"></textarea>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary float-right">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
