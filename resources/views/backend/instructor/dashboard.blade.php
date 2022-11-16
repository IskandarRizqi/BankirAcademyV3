@extends('backend.beranda')
@section('content')
Halo Instructor
<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
    <div class="widget widget-chart-three">
        <div class="widget-heading">
            <div class="">
                <h5 class="">Unique Visitors</h5>
            </div>
        </div>

        <div class="widget-content">
            <div id="chart"></div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    var options = {
          series: [{
          name: "STOCK ABC",
          data: [12,21,35,41,51,67]
        }],
          chart: {
          type: 'area',
          height: 350,
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        
        // title: {
        //   text: 'Fundamental Analysis of Stocks',
        //   align: 'left'
        // },
        // subtitle: {
        //   text: 'Price Movements',
        //   align: 'left'
        // },
        labels: ['11/14/2022','11/15/2022','11/16/2022','11/17/2022','11/18/2022','11/19/2022'],
        xaxis: {
          type: 'datetime',
        },
        yaxis: {
          opposite: true
        },
        legend: {
          horizontalAlign: 'left'
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>
@endsection