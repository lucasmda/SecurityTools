$("#ExtraDATsTable").DataTable({ 
  processing: false, 
  serverSide: false,
  responsive: true,
  ajax: url + '/api/ExtraDATs', 
  columns: [ 
    { data: 'incidentID', name: 'incidentID' },
    { data: 'changeID', name: 'changeID' },
    { data: 'name', name: 'name' },
    { data: 'dateReceipt', name: 'dateReceipt'},
    { data: 'lastUpdate', visible: false, name: 'lastUpdate'},
    { data: 'actions', name: 'actions'}
  ],
  columnDefs: [
    {
      type: 'date-eu',
      targets: [3,4]
    }
  ],
  order: [[ 4, "desc" ]],
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
