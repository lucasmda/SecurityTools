@extends('layouts.default.app')
@section('pageTitle') Search Network @endsection
@section('contentTitle') Search Network @endsection
@section('breadCumb')
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
  <a class="breadcrumb-item" href="{{ url('Asset') }}">Assets</a>
  <a class="breadcrumb-item">Seach Network</a>
</nav>
@endsection
@section('content')

<div class="row">
  <div class="col-sm-12 col-md-4 col-lg-4">
    <div class="card">
      <div class="card-body">
        <form action="{{ url('Asset/search') }}" method="post" name="form_search" id="form_search">
          {{csrf_field()}}
          <div class="row">
            <div class="com-sm-12 col-md-12 col-lg-12">
              <div class="form-group">
                <label for="ip_list">IP List</label>
                <textarea rows="9" class="form-control" id="ip_list" name="ip_list" placeholder="Insert a list of IPs, each one separated by line-breaks" value="{{old('ip_list')}}"></textarea>
              </div>
              <button type="submit" class="btn btn-primary float-right" name="submit_form_search" value="1">Search</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@if(isset($results))
  <div class="col-sm-12 col-md-8 col-lg-8">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Search Results</h4>
        <br>
        <table id="search_results_table" width="100%" class="table table-stripped">
          <thead>
            <tr>
              <th>IP Address</th>
              <th>Location</th>
              <th>Network CIDR</th>
              <th>Network Range</th>
            </tr>
          </thead>
          <tbody>
            @foreach($results as $result)
            <tr>
              <td>{{isset($result['ip_address']) ? $result['ip_address'] : 'Unknown'}}</td>
              <td>{{isset($result['localizacao']) ? $result['localizacao'] : 'Unknown'}}</td>
              <td>{{isset($result['cidr']) ? $result['cidr'] : 'Unknown'}}</td>
              <td>{{isset($result['range']) ? $result['range'] : 'Unknown'}}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>IP Address</th>
              <th>Location</th>
              <th>Network CIDR</th>
              <th>Network Range</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection

@section('customJS')

@if(isset($results))
<script type="text/javascript">
$("#search_results_table").DataTable({
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

</script>
@endif

@endsection
