@extends('layouts.default.app')
@section('pageTitle') Import Data @endsection
@section('contentTitle') Import Data @endsection
@section('customCSS')
@endsection

@section('breadCumb')
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
  <a class="breadcrumb-item" href="{{ url('Import') }}">Import</a>
</nav>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12 col-md-4 col-lg-4">
    <form action="{{ url('Import/step-one') }}" method="post" name="form_one">
      <div class="card text-center">
        <div class="card-header">
          Step 1 - Import "IP Compare"
        </div>
        <div class="card-body">
          <p class="card-text"></p>
          <form action="{{ url('Import/step-one') }}" method="post" name="form_one">
            {{csrf_field()}}
            <div class="form-group">
              <textarea rows="9" class="form-control" id="ip_compare_data" name="ip_compare_data" placeholder="Copy IP's and Sources information from Excel and paste it here." value="{{old('ip_compare_data')}}"></textarea>
            </div>
            <div class="form-group">
              <label for="scan_date">Scan Date</label>
              <input type="date" class="form-control" id="scan_date" name="scan_date" placeholder="Scan Date Date (YYYY-MM-DD)" value="{{old('scan_date')}}">
            </div>
            <div class="form-group">
              <label for="scan_date">Scan Period</label><br>
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input scan_period" type="radio" name="scan_period" value="madrugada"> Madrugada
                </label>
              </div>
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input scan_period" type="radio" name="scan_period" value="manha"> Manhã
                </label>
              </div>
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input scan_period" type="radio" name="scan_period" value="tarde"> Tarde
                </label>
              </div>
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input scan_period" type="radio" name="scan_period" value="noite" > Noite
                </label>
              </div>
            </div>
          </div>
          <div class="card-footer text-muted">
            <button type="submit" class="btn btn-primary float-right center" name="submit_form_one" value="1">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('customJS')

@endsection
