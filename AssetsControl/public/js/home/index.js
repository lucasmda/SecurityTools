// Create the chart
Highcharts.chart('vulnerabilities-locations-chart', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'General Status by Vulnerability per Location'
  },
  subtitle: {
    text: 'Click the columns to view locations.'
  },
  xAxis: {
    type: 'category'
  },
  yAxis: {
    title: {
      text: 'Total assets'
    }
  },
  legend: {
    enabled: false
  },
  plotOptions: {
    series: {
      borderWidth: 0,
      dataLabels: {
        enabled: true,
        format: '{point.y}'
      },

    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
  },
  series: [{
    name: 'Vulnerabilities',
    colorByPoint: true,
    data: assets_control.series_vulnerabilities
  }],
  drilldown: {
    series: assets_control.drilldown_vulnerabilities
  }

});

function getServerList(vulnerability, location){
  // ServersTable.ajax.url(url + '/get-servers-vl/'+vulnerability+'/'+location).load();
  $.getJSON(url + '/get-servers-vl/'+vulnerability+'/'+location, function(response){
    console.log(response);
  });
}
