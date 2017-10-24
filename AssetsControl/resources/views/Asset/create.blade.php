@extends('layouts.default.app')
@section('pageTitle') Create Asset @endsection
@section('contentTitle') Create Asset @endsection
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
        <nav class="nav nav-tabs" id="myTab" role="tablist">
          <a class="nav-item nav-link active" id="oneIpTab" data-toggle="tab" href="#oneIp" role="tab" aria-controls="nav-oneIp" aria-selected="true">Single Insert</a>
          <a class="nav-item nav-link" id="multipleIpTab" data-toggle="tab" href="#multipleIP" role="tab" aria-controls="nav-multipleIp" aria-selected="false">Multiple Insert</a>
        </nav>
        <br>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="oneIp" role="tabpanel" aria-labelledby="nav-oneIp">
            <form action="{{ route('Asset.store') }}" method="post" name="form_one">
              {{csrf_field()}}
              <div class="row">
                <div class="com-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="ip_address">IP</label>
                    <input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="IP" value="{{old('ip_address')}}">
                  </div>
                  <div class="form-group">
                    <label for="hostname">Hostname</label>
                    <input type="text" class="form-control" id="hostname" name="hostname" placeholder="Hostname" value="{{old('hostname')}}">
                  </div>
                  <div class="form-group">
                    <label for="ping">Ping</label>
                    <input type="text" class="form-control" id="ping" name="ping" placeholder="Ping result" value="{{old('ping')}}">
                  </div>
                  <div class="form-group">
                    <label for="scan">Scan</label>
                    <input type="text" class="form-control" id="scan" name="scan" placeholder="Scan Date" value="{{old('scan')}}">
                  </div>
                  <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" class="form-control" id="status" name="status" placeholder="Status" value="{{old('status')}}">
                  </div>
                  <div class="form-group">
                    <label for="localidade">Localidade</label>
                    <input type="text" class="form-control" id="localidade" name="localidade" placeholder="Localidade" value="{{old('localidade')}}">
                  </div>
                  <div class="form-group">
                    <label for="porta_sw">Porta SW</label>
                    <input type="text" class="form-control" id="porta_sw" name="porta_sw" placeholder="Porta SW" value="{{old('porta_sw')}}">
                  </div>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" name="wannacry" id="wannacry" value="1"> WannaCry
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" name="doublepulsar" id="doublepulsar" value="1"> DoublePulsar
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" name="vulneravel" id="vulneravel" value="1"> Vulnerável
                    </label>
                  </div>
                </div>
                <div class="com-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="switch">Switch</label>
                    <input type="text" class="form-control" id="switch" name="switch" placeholder="Switch" value="{{old('switch')}}">
                  </div>
                  <div class="form-group">
                    <label for="vlan_id">VlanID</label>
                    <input type="text" class="form-control" id="vlan_id" name="vlan_id" placeholder="VlanID" value="{{old('vlan_id')}}">
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{old('location')}}">
                  </div>
                  <div class="form-group">
                    <label for="site">Site</label>
                    <input type="text" class="form-control" id="site" name="site" placeholder="Site" value="{{old('site')}}">
                  </div>
                  <div class="form-group">
                    <label for="environment">Environment</label>
                    <input type="text" class="form-control" id="environment" name="environment" placeholder="Environment" value="{{old('environment')}}">
                  </div>
                  <div class="form-group">
                    <label for="obs">OBS</label>
                    <textarea class="form-control" id="obs" name="obs" placeholder="Observação">{{old('obs')}}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="reference_date">Reference Date</label>
                    <input type="date" class="form-control" id="reference_date" name="reference_date" placeholder="Reference Date (YYYY-MM-DD)" value="{{old('reference_date')}}">
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary float-right" name="submit_form_one" value="1">Save</button>
            </form>
          </div>
          <div class="tab-pane fade show" id="multipleIP" role="tabpanel" aria-labelledby="nav-multipleIp">
            <form action="{{ route('Asset.store') }}" method="post" name="form_two">
              {{csrf_field()}}
              <div class="row">
                <div class="com-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <label for="full_data">Full Data</label>
                    <textarea rows="9" class="form-control" id="full_data" name="full_data" placeholder="Data from Excel" value="{{old('full_data')}}"></textarea>
                  </div>
                  <div class="form-group">
                    <div class="form-group">
                      <label for="reference_date">Reference Date</label>
                      <input type="date" class="form-control" id="reference_date" name="reference_date" placeholder="Reference Date (YYYY-MM-DD)" value="{{old('reference_date')}}">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary float-right" name="submit_form_two" value="1">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('customJS')
<script type="text/javascript">
  $("#ip_address").on('change', function(){
    if($(this).val().length === 0){
      $("#localidade").val("");
    }else{
      $.ajax({
        url: url + '/get-subnet/' + $(this).val(),
        type: 'get',
        dataType: 'json',
        success: function(response){
          $("#localidade").val(response.localizacao);
        }
      });
    }
  });
</script>
@endsection
