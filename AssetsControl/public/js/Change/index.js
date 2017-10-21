$("#changesTable").DataTable({ 
  processing: false, 
  serverSide: false, 
  responsive: true,
  ajax: url + '/api/Changes', 
  columns: [ 
    { data: 'changeID', name: 'changeID' },
    { data: 'title', name: 'title' }, 
    { data: 'change_type.type', name: 'change_type.type' },
    { data: 'change_template.templateName', name: 'change_template.templateName' }, 
    { data: 'change_status.status', name: 'change_status.status'},
    { data: 'executionDate', name: 'executionDate'},
    { data: 'lastUpdate', 'visible': false, name: 'lastUpdate'},
    { data: 'actions', name: 'actions'}
  ],
  columnDefs: [
    {
      type: 'date-eu',
      targets: [5,6]
    }
  ],
  order: [[ 6, "desc" ]],
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
