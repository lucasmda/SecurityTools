$("#prevetiveMeasuresTable").DataTable({ 
  processing: false, 
  serverSide: false,
  responsive: true,
  ajax: url + '/api/PreventiveMeasures', 
  columns: [ 
    { data: 'incidentID', name: 'incidentID' },
    { data: 'notification_source.notificationSource', name: 'notification_source.notificationSource' }, 
    { data: 'threat_type.threatType', name: 'threat_type.threatType' },
    { data: 'title', name: 'title' }, 
    { data: 'ticket_status.status', name: 'ticket_status.status'},
    { data: 'dateReceipt', name: 'dateReceipt'},
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
