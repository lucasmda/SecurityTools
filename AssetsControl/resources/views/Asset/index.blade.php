@extends('layouts.default.app')
@section('pageTitle') Assets @endsection
@section('contentTitle') Assets @endsection
@section('customCSS')
@endsection
@section('subMenuRightActions')
<div class="dropdown show float-right">
  <a class="btn btn-secondary dropdown-toggle" href="" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Actions
  </a>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item" href="{{ url('Asset/create') }}">Create new Asset Insertion</a>
    <a class="dropdown-item" href="{{ url('Asset/edit') }}">Edit some Assets</a>
  </div>
</div>
@endsection
@section('breadCumb')
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
  <a class="breadcrumb-item" href="{{ url('Asset') }}">Assets</a>
</nav>
@endsection
@section('content')
<div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <table id="assetsTable" class="table table-hover" width="100%">
          <thead>
            <tr>
              <th>IP Address</th>
              <th>Hostname</th>
              <th>WannaCry</th>
              <th>DoublePulsar</th>
              <th>Vulnerável</th>
              <th>Localidade</th>
              <th>Status</th>
              <th>Porta SW</th>
              <th>Switch</th>
              <th>Vlan ID</th>
              <th>Location</th>
              <th>Site</th>
              <th>Environment</th>
              <th>Observações</th>
              <th>Created At</th>
              <th>Updated At</th>
            </tr>
          </thead>
          <tbody>
            @foreach($assets as $asset)
            <tr>
              <td>{{$asset->ip_address}}</td>
              <td>{{$asset->hostname}}</td>
              <td>{!!$asset->wannacry ? '<b class="text-danger">Sim</b>' : 'Não'!!}</td>
              <td>{!!$asset->doublepulsar ? '<b class="text-danger">Sim</b>' : 'Não'!!}</td>
              <td>{!!$asset->vulneravel ? '<b class="text-danger">Sim</b>' : 'Não'!!}</td>
              <td>{{$asset->localidade}}</td>
              <td>{{$asset->status}}</td>
              <td>{{$asset->porta_sw}}</td>
              <td>{{$asset->switch}}</td>
              <td>{{$asset->vlan_id}}</td>
              <td>{{$asset->location}}</td>
              <td>{{$asset->site}}</td>
              <td>{{$asset->environment}}</td>
              <td>{{$asset->obs}}</td>
              <td>{{$asset->created_at}}</td>
              <td>{{$asset->updated_at}}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>IP Address</th>
              <th>Hostname</th>
              <th>WannaCry</th>
              <th>DoublePulsar</th>
              <th>Vulnerável</th>
              <th>Status</th>
              <th>Localidade</th>
              <th>Porta SW</th>
              <th>Switch</th>
              <th>Vlan ID</th>
              <th>Location</th>
              <th>Site</th>
              <th>Environment</th>
              <th>Observações</th>
              <th>Created At</th>
              <th>Updated At</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('customJS')
<script type="text/javascript">
  $(document).ready(function() {
    $("#assetsTable").DataTable({
      responsive: true,
      dom: 'Bfrtip',
      buttons: [
       'copy', 'excel', 'pdf'
     ],
     initComplete: function () {
       this.api().columns().every(function () {
         var column = this;
         var input = document.createElement("input");
         input.setAttribute("Placeholder","Filter");
         $(input).appendTo($(column.footer()).empty())
         .on('keyup change', function () {
           column.search($(this).val(), false, false, true).draw();
         });
       });
    }
  });
});
</script>

@endsection
