<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Info Data Covid-19</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/admin-lte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/admin-lte/dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/admin-lte/plugins/summernote/summernote-bs4.css">
  <!-- Leaflet -->
  <link href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" rel="stylesheet" />
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <style type="text/css">
    .custom {
        font-size: 12px;
        font-family: Arial;
    }
    .bottomcustom, .topcustom {
        font-size: 12px;
        font-family: Arial;
        width: 100%;

    }
  </style>

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="" class="navbar-brand">
        <img src="/admin-lte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Covid-19</span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
        </ul>
      </div>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> <small>Data Statistik</small> Covid-19</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="col-lg-12">
         @foreach ($suspect_indo as $datas)  
          <div class="row">
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $datas['positif'] }}</h3>
    
                    <p>POSITIF</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $datas['sembuh'] }}</h3>

                    <p>SEMBUH</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $datas['meninggal'] }}</h3>

                    <p>MENINGGAL</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                </div>
            </div>
          </div>
          @endforeach
          <!-- /.row -->
          <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-globe mr-1"></i>
                        Peta Sebaran Kasus Per Provinsi
                      </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div id="mapid" style="width: 100%; height: 400px;"></div>
                        <script>
                           var mymap = L.map('mapid').setView([-0.4690016,117.1550653,17], 5);
                        
                           L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                              maxZoom: 18,
                              attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                                 '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                                 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                              id: 'mapbox/dark-v10',
                           }).addTo(mymap);
                           @foreach ($location_indo['features'] as $value) {
                              L.marker(["{{$value['geometry']['y']}}","{{$value['geometry']['x']}}"]).addTo(mymap)
                              .bindPopup("<b>Provinsi : " + "{{$value['attributes']['Provinsi']}}" + "</b><br>" +
                              "Positif : " + "{{$value['attributes']['Kasus_Posi']}}" + "<br>" +
                              "Sembuh : " + "{{$value['attributes']['Kasus_Semb']}}" + "<br>" +
                              "Meninggal : " + "{{$value['attributes']['Kasus_Meni']}}" + "<br>"
                              );
                           }
                           @endforeach
                        </script>
                    </div><!-- /.card-body -->
                </div>
            </div>
          </div>

          <!-- /.row -->
          <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Grafik Kasus Per Provinsi
                      </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div style="height: 610px; width: 100%">
                            {!! $chart->container() !!}
                            {!! $chart->script() !!}
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-table mr-1"></i>
                        Tabel Data Kasus
                      </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover display compact custom" cellspacing="0" width="100%" id="laravel_datatable">
                            <thead>
                               <tr>
                                  <!--<th>FID</th>-->
                                  <th>Provinsi</th>
                                  <th>Positif</th>
                                  <th>Sembuh</th>
                                  <th>Meninggal</th>
                               </tr>
                            </thead>
                         </table>
                    </div><!-- /.card-body -->
                </div>
            </div>
          </div>
          <!-- /.row -->
                    <!-- /.row -->
          <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Grafik Perkembangan Jumlah Kumulatif Kasus
                      </h3>
                    </div>
                    <div class="card-body">
                        <div style="height: 500px; width: 100%">
                            {!! $chart_stat->container() !!}
                            {!! $chart_stat->script() !!}
                        </div>
                    </div><!-- /.card-body -->
                </div>
              </div>
          </div> 
        </div>
        <!-- /.col-md-12 -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/admin-lte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/admin-lte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin-lte/dist/js/adminlte.min.js"></script>
<!-- ChartJS -->
<script src="/admin-lte/plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin-lte/dist/js/adminlte.js"></script>
<!-- DataTables -->
<script src="/admin-lte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/admin-lte/dist/js/demo.js"></script>
<!-- Summernote -->
<script src="/admin-lte/plugins/summernote/summernote-bs4.min.js"></script>

  <script>
    $(document).ready( function () {
     $('#laravel_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('https://immense-chamber-80308.herokuapp.com/coronas-list') }}",
            order: [[ 1 , "desc" ]], 
            columns: [
                     //{ data: 'attributes.FID'},
                     { data: 'attributes.Provinsi' },
                     { data: 'attributes.Kasus_Posi' },
                     { data: 'attributes.Kasus_Semb' },
                     { data: 'attributes.Kasus_Meni'}
                  ],
                "dom": '<"topcustom"fr>t<"bottomcustom"ip>'
         });
      });
  </script>
</body>
</html>
