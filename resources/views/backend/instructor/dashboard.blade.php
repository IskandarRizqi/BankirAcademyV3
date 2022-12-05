@extends('backend.template')
@section('content')
<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
  <div class="widget widget-chart-one">
    <div class="widget-heading">
      <h5 class="">Jumlah Kelas Per Bulan Dalam Setahun</h5>
      <div class="task-action">
        {{-- <div class="dropdown">
          <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-more-horizontal">
              <circle cx="12" cy="12" r="1"></circle>
              <circle cx="19" cy="12" r="1"></circle>
              <circle cx="5" cy="12" r="1"></circle>
            </svg>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
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
<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
  <div class="widget widget-card-one">
    <div class="widget-content">
      <div class="table-responsive">
        <table id="zero-config" class="table dt-table-hover" style="width:100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Nilai</th>
              <th>Pesan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($review as $key => $r)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$r->name}}</td>
              <td>{{$r->review_val}}</td>
              <td>{{$r->review_msg}}</td>
              <td><span onclick="aktif('{{$r->id}}','{{$r->status?'Tidak Tampil':'Tampil'}}')"
                  class="badge badge-{{$r->status?'success':'danger'}}">{{$r->status?'Tampil':'Tidak
                  Tampil'}}</span></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<form id="form_tampil" action="/changestatusreview" method="post">
  @csrf
  <input type="text" name="id_review" id="id_review" hidden>
  <input type="text" name="val_review" id="val_review" hidden>
</form>
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

        function aktif(id,msg) {
            $('#id_review').val(id)
            $('#val_review').val(msg)
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: msg,
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    $('#form_tampil').submit()
                }
            });
        }
</script>
@endsection