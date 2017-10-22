@extends('layouts.default.app')
@section('pageTitle') Asset @endsection
@section('contentTitle') Asset @endsection
@section('breadCumb')
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
  <a class="breadcrumb-item" href="{{ url('Asset') }}">Assets</a>
  <a class="breadcrumb-item">Show</a>
</nav>
@endsection
@section('subMenuRightActions')
<div class="dropdown show float-right">
  <a class="btn btn-secondary dropdown-toggle" href="" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Actions
  </a>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item" href="{{ route('Asset.edit', $asset->id) }}">Edit this Assets</a>
  </div>
</div>
@endsection
@section('content')
<div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('Asset.update', $asset->id) }}" method="post">
          {{csrf_field()}}
          {{ method_field('PUT') }}
          <div class="row">
            <div class="com-sm-12 col-md-6 col-lg-6">
              <div class="form-group">
                <label for="ip_address">IP</label>
                <input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="IP" value="{{old('ip_address') ? old('ip_address') : $asset->ip_address}}" disabled>
              </div>
              <div class="form-group">
                <label for="hostname">Hostname</label>
                <input type="text" class="form-control" id="hostname" name="hostname" placeholder="Hostname" value="{{old('hostname') ? old('hostname') : $asset->hostname}}" disabled>
              </div>
              <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="status" name="status" placeholder="Status" value="{{old('status') ? old('status') : $asset->status}}" disabled>
              </div>
              <div class="form-group">
                <label for="localidade">Localidade</label>
                <input type="text" class="form-control" id="localidade" name="localidade" placeholder="Localidade" value="{{old('localidade') ? old('localidade') : $asset->localidade}}" disabled>
              </div>
              <div class="form-group">
                <label for="porta_sw">Porta SW</label>
                <input type="text" class="form-control" id="porta_sw" name="porta_sw" placeholder="Porta SW" value="{{old('porta_sw') ? old('porta_sw') : $asset->porta_sw}}" disabled>
              </div>
              <div class="form-group">
                <label for="switch">Switch</label>
                <input type="text" class="form-control" id="switch" name="switch" placeholder="Switch" value="{{old('switch') ? old('switch') : $asset->switch}}" disabled>
              </div>
            </div>
            <div class="com-sm-12 col-md-6 col-lg-6">
              <div class="form-group">
                <label for="vlan_id">VlanID</label>
                <input type="text" class="form-control" id="vlan_id" name="vlan_id" placeholder="VlanID" value="{{old('vlan_id') ? old('vlan_id') : $asset->vlan_id}}" disabled>
              </div>
              <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{old('location') ? old('location') : $asset->location}}" disabled>
              </div>
              <div class="form-group">
                <label for="site">Site</label>
                <input type="text" class="form-control" id="site" name="site" placeholder="Site" value="{{old('site') ? old('site') : $asset->site}}" disabled>
              </div>
              <div class="form-group">
                <label for="environment">Environment</label>
                <input type="text" class="form-control" id="environment" name="environment" placeholder="Environment" value="{{old('environment') ? old('environment') : $asset->environment}}" disabled>
              </div>
              <div class="form-group">
                <label for="obs">OBS</label>
                <textarea class="form-control" id="obs" name="obs" placeholder="Observação" disabled>{{old('obs') ? old('obs') : $asset->obs}}</textarea>
              </div>
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" name="wannacry" id="wannacry" {{$asset->wannacry ? 'checked' : '' }} disabled> WannaCry
                </label>
              </div>
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" name="doublepulsar" id="doublepulsar" {{$asset->doublepulsar ? 'checked' : '' }} disabled> DoublePulsar
                </label>
              </div>
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" name="vulneravel" id="vulneravel" {{$asset->vulneravel ? 'checked' : '' }} disabled> Vulnerável
                </label>
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
