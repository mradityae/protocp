// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: [
      "VPN", 
      "Gangguan Backup Lintas", 
      "Gangguan ASTINET", 
      "Gangguan Router Mikrotik", 
      "Gangguan M2M", 
      "Gangguan Manggoesky", 
      "Gangguan Sinyal M2M", 
      "Lain-lain"
    ],
    datasets: [{
      data: [
        0.05,
        0.63,
        2.09,
        0.11,
        0.1,
        0.0,
        0.79, 
        0.00
      ],
      backgroundColor: [
        '#4e73df', 
        '#1cc88a', 
        '#FFA843',
        '#FFF723', 
        '#1E9CB5', 
        '#1E4BB5',
        '#1cc88a', 
        '#36b9cc'],
      hoverBackgroundColor: [
        '#4e73df', 
        '#1cc88a', 
        '#FFA843',
        '#FFF723', 
        '#1E9CB5', 
        '#1E4BB5',
        '#1cc88a', 
        '#36b9cc'
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
