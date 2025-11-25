<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
// Function untuk load chart data
async function loadChart(containerId, type, title) {
  try {
    const response = await fetch(`../data/get_chart_data.php?type=${type}`);
    const result = await response.json();
    
    if (!result.success || result.data.length === 0) {
      document.getElementById(containerId).innerHTML = '<p class="text-muted text-center">Belum ada data</p>';
      return;
    }
    
    Highcharts.chart(containerId, {
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
        text: title,
        style: {
          color: '#fff',
          fontSize: '16px'
        }
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>Total: <b>Rp {point.y:,.0f}</b>'
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
        enabled: true,
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        itemStyle: {
          color: '#fff',
          fontSize: '13px',
          fontWeight: 'normal'
        }
      },
      series: [{
        name: 'Total',
        colorByPoint: true,
        data: result.data
      }]
    });
  } catch (error) {
    console.error('Error loading chart:', error);
    document.getElementById(containerId).innerHTML = '<p class="text-danger text-center">Gagal memuat chart</p>';
  }
}

// Load both charts
document.addEventListener('DOMContentLoaded', function() {
  loadChart('incomeChart', 'income', 'Income by Category');
  loadChart('expenseChart', 'expense', 'Expense by Category');
});
</script>
