$(document).ready(function () {
  $.ajax({
    url: url + '/api/Dashboard',
    method: 'GET',
    success: function(result){
      $("#securityIncidentsTotal").html(result['securityIncidents']);
      $("#preventiveMeasuresTotal").html(result['preventiveMeasures']);
      $("#extraDATSTotal").html(result['extraDATs']);
      $("#changesTotal").html(result['changes']);
      $("#bulletinsTotal").html(result['bulletins']);
      $("#assetsTotal").html(result['assets']);
    }});
});
