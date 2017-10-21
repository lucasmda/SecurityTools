@extends('layouts.default.app')
@section('pageTitle') Asset @endsection
@section('contentTitle') Asset @endsection
@section('breadCumb')
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
  <a class="breadcrumb-item" href="{{ url('Asset') }}">Assets</a>
  <a class="breadcrumb-item">Create</a>
</nav>
@endsection
@section('content')
<div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('Asset.store') }}" method="post">
          {{csrf_field()}}
          <div class="row">
            <div class="com-sm-12 col-md-6 col-lg-6">
              <div class="form-group">
                <label for="incidentID">Incident ID</label>
                <input type="text" class="form-control" id="incidentID" name="incidentID" placeholder="Enter the IncidentID" value="{{old('incidentID')}}">
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary float-right">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
