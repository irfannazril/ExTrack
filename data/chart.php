<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
  // Data retrieved from https://netmarketshare.com/
  // Build the chart
  Highcharts.chart('charts', {
    chart: {
      backgroundColor: '#1a1a1a',
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie',
      style: {
        fontFamily: 'Poppins, sans-serif',
        color: '#fff'
      }
    },
    title: {
      text: 'Your Expenses',
      style: {
        color: '#fff', // Mengatur warna teks judul
        fontSize: '16px' // Anda juga bisa mengatur properti CSS lain
      }
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: false
        },
        showInLegend: true
      }
    },
    legend: {
      enabled: true, // Pastikan legend diaktifkan
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',

      // Objek untuk styling teks legend
      itemStyle: {
        color: '#fff', // Mengatur warna teks
        fontSize: '13px', // Anda juga bisa mengatur properti CSS lain
        fontWeight: 'normal'
      }
    },
    series: [{
      name: 'Brands',
      colorByPoint: true,
      data: [{
        name: 'Chrome',
        y: 74.77,
        sliced: true,
        selected: true
      }, {
        name: 'Edge',
        y: 12.82
      }, {
        name: 'Firefox',
        y: 4.63
      }, {
        name: 'Safari',
        y: 2.44
      }, {
        name: 'Internet Explorer',
        y: 2.02
      }, {
        name: 'Other',
        y: 3.28
      }],
    }]
  });
</script>