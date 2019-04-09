try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    require('admin-lte');
    require('bootstrap-confirmation2');
    require('chart.js');

    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        singleton: true,
        popout: true,
        btnOKClass: 'btn btn-sm btn-danger',
      });
} catch (e) {
    console.log("Error loading Simple Laravel CRM Demo script files", e);
}

if (window.location.pathname == "/") {
    const barChartCanvas = $('#barChart').get(0).getContext('2d');
    const barChartData = window.chartData;
    const barChart = new Chart(barChartCanvas, { type: 'bar', data: barChartData });
}