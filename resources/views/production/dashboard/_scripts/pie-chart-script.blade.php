<script>
    var pieOptions = {
        series: {!! $series !!},
        labels: {!! $labels !!},
        chart: {
            height: 350,
            type: 'pie',
            dropShadow: {
                enabled: true,
                color: '#000',
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2
            },
            toolbar: {
                show: false
            }
        },
        colors: ['#FF5630', '#36B37E', '#00B8D9', '#FFAB00'],
        dataLabels: {
            formatter: function(val, opts) {
                return opts.w.config.series[opts.seriesIndex]
            },
        },
        title: {
            text: '',
            align: 'left'
        },
        markers: {
            size: 1
        },
        xaxis: {
            categories: {!! $labels !!},
            title: {
                text: 'Month'
            }
        },
        yaxis: {
            title: {
                text: '{{ __('Amount') }}'
            },
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: 8,
            offsetX: 8
        }
    };

    var pieChart = new ApexCharts(document.querySelector("#pie-chart"), pieOptions);

    pieChart.render();
</script>
