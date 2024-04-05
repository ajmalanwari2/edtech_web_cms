
google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }

  //map

  google.charts.load('current', {'packages':['geochart'],'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY' });
  google.charts.setOnLoadCallback(drawRegionsMap);

  function drawRegionsMap() {
    var data = google.visualization.arrayToDataTable([
      ['Province', 'Population', 'Area'],
      ['Badakhshan',  2760000, 50],
      ['Badghis',  499000, 50],
      ['Baghlan',  1149000, 50],
      ['Balkh',  1526000, 50],
      ['Bamyan',  493000, 50],
      ['Daykundi',  327000, 50],
      ['Farah',  596000, 50],
      ['Faryab',  985000, 50],
      ['Ghazni',  1477000, 50],
      ['Ghor',  692000, 50],
      ['Helmand',  1553000, 50],
      ['Herat',  1845000, 50],
      ['Jowzjan',  821000, 50],
      ['Kabul',  4917000, 50],
      ['Kandahar',  1143000, 50],
      ['Kapisa',  428000, 50],
      ['Khost',  574000, 50],
      ['Kunar',  449000, 50],
      ['Kunduz',  1182000, 50],
      ['Laghman',  442000, 50],
      ['Logar',  374000, 50],
      ['Nangarhar',  1578000, 50],
      ['Nimruz',  183000, 50],
      ['Nuristan',  130000, 50],
      ['Paktia',  525000, 50],
      ['Paktika',  373000, 50],
      ['Panjshir',  147000, 50],
      ['Parwan',  700000, 50],
      ['Samangan',  544000, 50],
      ['Sar-e Pol',  532000, 50],
      ['Takhar',  1034000, 50],
      ['Uruzgan',  346000, 50],
      ['Wardak',  581000, 50],
      ['Zabul',  381000, 50]
    ]);

    var options = {
        region: 'AF',
        resolution: 'provinces',
        colorAxis: {colors: ['#00853f', 'black', '#e31b23']},
        backgroundColor: '0',
        datalessRegionColor: 'transparent',
        defaultColor: '#f5f5f5',
        keepAspectRatio: true,
        domain: 'IN',
        displayMode: 'regions',
        keepAspectRatio: false
        
      };

    var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

    chart.draw(data, options);
  }

//   bar chart

google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawwChart);
      function drawwChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
// bar chart

google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2014', 1000, 400],
          ['2015', 1170, 460],
          ['2016', 660, 1120],
          ['2017', 1030, 540],
          ['2014', 1000, 400],
          ['2015', 1170, 460],
          ['2016', 660, 1120],
          ['2017', 1030, 540]
        ]);

        var options = {
          legend: { position: 'none' },
          chart: { },
          axes: {
            x: {
              0: { side: 'top', label: '.'} // Top x-axis.
            }
          },
          bar: { groupWidth: "20%" },
          colors: ['#1c6ac6','#b3e49c'],
          is3D:true
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
