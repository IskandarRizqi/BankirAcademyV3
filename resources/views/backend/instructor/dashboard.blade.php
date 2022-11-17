@extends('backend.beranda')
@section('content')
<div class="row layout-top-spacing">
  <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
    <div class="widget widget-chart-one">
      <div class="widget-heading">
        <h5 class="">Jumlah Kelas Per Bulan Dalam Setahun</h5>
        <div class="task-action">
          {{-- <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-more-horizontal">
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="19" cy="12" r="1"></circle>
                <circle cx="5" cy="12" r="1"></circle>
              </svg>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask"
              style="will-change: transform;">
              <a class="dropdown-item" href="javascript:void(0);">Weekly</a>
              <a class="dropdown-item" href="javascript:void(0);">Monthly</a>
              <a class="dropdown-item" href="javascript:void(0);">Yearly</a>
            </div>
          </div> --}}
        </div>
      </div>

      <div class="widget-content">
        <div id="chart"></div>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
    <div class="widget widget-chart-two">
      <div class="widget-heading">
        <h5 class="">Sales by Category</h5>
      </div>
      <div class="widget-content">
        <div id="chart-2" class=""></div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('custom-js')
<script>
  let data = JSON.parse('<?= $class ?>')
  var options = {
          series: [{
          name: 'Inflation',
          data: data
        }],
          chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val + " class";
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
          categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          position: 'bottom',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val + "%";
            }
          }
        
        },
        // title: {
        //   text: 'Monthly Inflation in Argentina, 2002',
        //   floating: true,
        //   offsetY: 330,
        //   align: 'center',
        //   style: {
        //     color: '#444'
        //   }
        // }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>
@endsection