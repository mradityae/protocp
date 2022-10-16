// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChartLintasarta");
var myPieChartLintasarta = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: [
      "Time Up 100%", 
      "Time Up >= 50% - <= 99.99%", 
      "Time Up < 50%"
    ],
    datasets: [{
      data: [
        100,
        0,
        0
      ],
      backgroundColor: [
        '#4e73df', 
        '#1cc88a', 
        '#FFA843'],
      hoverBackgroundColor: [
        '#4e73df', 
        '#1cc88a', 
        '#FFA843'
      ],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, data) { 
            var indice = tooltipItem.index;                 
            return  data.labels[indice] +' : '+data.datasets[0].data[indice] + ' %';
        }
    }
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
