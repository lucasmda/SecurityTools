$("#bulletinsTable").DataTable({ 
  processing: false, 
  serverSide: false,
  responsive: true,
  ajax: url + '/api/Bulletins', 
  columns: [ 
    { data: 'bulletinNumber', name: 'bulletinNumber' },
    { data: 'title', name: 'title' },
    { data: 'applicability.applicability', name: 'applicability.applicability' },
    { data: 'priority', name: 'priority'},
    { data: 'receiptDate', name: 'receiptDate'},
    { data: 'lastUpdate', 'visible': false, name: 'lastUpdate'},
    { data: 'actions', name: 'actions'}
  ],
  columnDefs: [
    {
      type: 'date-eu',
      targets: [4,5]
    }
  ],
  order: [[ 5, "desc" ]],
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
