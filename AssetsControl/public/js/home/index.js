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


Highcharts.chart('detection_history_chart', {
  chart: {
    type: 'spline'
  },
  credits:{
    enabled: false
  },
  title: {
    text: 'Detection History'
  },
  subtitle: {
    text: 'History of detections along past days'
  },

  xAxis: {
    categories: assets_control.date_range,
    title: {
      text: 'Dias'
    },
  },
  yAxis: {
    title: {
      text: 'Ativos'
    },
    labels: {
      formatter: function () {
        return this.value;
      }
    }
  },
  tooltip: {
    crosshairs: true,
    shared: true
  },
  plotOptions: {
    spline: {
      marker: {
        radius: 4,
        lineColor: '#666666',
        lineWidth: 1
      }
    }
  },
  series: [
    {
      name: 'WannaCry',
      color: '#ff0000',
      marker: {
        symbol: 'triangle'
      },
      data:assets_control.detection_history.WannaCry
    },
    {
    name: 'DoublePulsar',
    color: '#336699',
    marker: {
      symbol: 'square'
    },
    data: assets_control.detection_history.DoublePulsar
  }, {
    name: 'Vulnerable',
    color: '#ff6d00',
    marker: {
      symbol: 'circle'
    },
    data: assets_control.detection_history.Vulnerable
  },
]

});

function getServerList(vulnerability, location){
  // ServersTable.ajax.url(url + '/get-servers-vl/'+vulnerability+'/'+location).load();
  $.getJSON(url + '/get-servers-vl/'+vulnerability+'/'+location, function(response){
    console.log(response);
  });
}
