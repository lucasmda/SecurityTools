@extends('layouts.default.app')
@section('pageTitle') Dashboard @endsection
@section('contentTitle') Dashboard @endsection
@section('customCSS')
<link rel="stylesheet" href="{{asset('plugins/bootstrap-treeview-master/bootstrap-treeview.min.css')}}">
@endsection

@section('breadCumb')
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
</nav>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12 col-md-4 col-lg-4">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Assets' General Status</h4>
        <table class="table table-striped table-hover">
          <thead class="bg-primary text-white">
            <tr>
              <th>Status</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data['byStatus'] as $status)
            <tr>
              <td>{{isset($status->status_remediation) && $status->status_remediation != "" ? $status->status_remediation : 'Unknown'}}</td>
              <td>{{$status->amount}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-sm-12 col-md-8 col-lg-8">
    <div class="card">
      <div class="card-block">

        <div id="vulnerabilities-locations-chart" height="300px">
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-block">
        <table class="table table-stripped table-hover table-sm">
          <thead class="bg-primary text-white">
            <tr>
              <th>Location</th>
              <th>WannaCry</th>
              <th>DoublePulsar</th>
              <th>Vulnerable</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php $twc=0; $tdp = 0; $tvl = 0; $tt = 0; ?>
            @foreach($data['all']->groupBy('localidade') as $key => $value)
            <tr>
              <td>{{$key}}</td>
              <td>{{$wc = $value->where('wannacry',1)->count()}}</td>
              <td>{{$dp = $value->where('doublepulsar',1)->count()}}</td>
              <td>{{$vl = $value->where('vulneravel',1)->count()}}</td>
              <td>{{$total = $value->unique('ip_address')->count()  }}</td>
            </tr>
            <?php $twc+=$wc; $tdp += $dp; $tvl += $vl; $tt += $total; ?>
            @endforeach
            <tfoot class="bg-primary text-white">
              <tr>
                <th>Total</th>
                <th>{{$twc}}</th>
                <th>{{$tdp}}</th>
                <th>{{$tvl}}</th>
                <th>{{$tt}}</th>
              </tr>
            </tfoot>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12 col-md-6 col-lg-6">
    <div id="tree">

    </div>
  </div>
</div>
@endsection

@section('customJS')
<script src="{{ asset('plugins/HighCharts/js/highcharts.js') }}"></script>
<script src="{{ asset('plugins/HighCharts/js/modules/drilldown.js')}}" charset="utf-8"></script>
<script src="{{ asset('plugins/HighCharts/js/modules/exporting.js') }}"></script>
<script src="{{ asset('plugins/HighCharts/js/modules/data.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-treeview-master/bootstrap-treeview.min.js')}}" charset="utf-8"></script>
<script src="{{asset('/js/home/index.js')}}" charset="utf-8"></script>
<script type="text/javascript">
  $('#tree').treeview({data: assets_control.tree});
</script>
@endsection
