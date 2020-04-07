<!DOCTYPE html>
 
<html lang="en">
<head>
<title>Kasus Corona</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">  
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" rel="stylesheet" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<style type="text/css">
    .custom {
        font-size: 12px;
        font-family: Arial;
    }
    .bottomcustom, .topcustom {
        font-size: 12px;
        font-family: Arial;
        width: 420px;
   .peta{
			height:100vh;
	}
}

</style>
</head>
      <body>
         <div class="container">
            <h1 class="text-center">Data Statistik Kasus Covid-19 di Indonesia</h1>
            @foreach ($suspect_indo as $datas)  
            <div class="row">
                <div class="col-md-1"></div>
                <div class="card text-white bg-warning mb-3" style="min-width: 16rem;">
                    <div class="card-header text-center"><h2>Positif</h2></div>
                    <div class="card-body">
                      <h2 class="card-text text-center">{{ $datas['positif'] }}</h2>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="card text-white bg-success mb-3" style="min-width: 16rem;">
                    <div class="card-header text-center"><h2>Sembuh</h2></div>
                    <div class="card-body">
                      <h2 class="card-text text-center">{{ $datas['sembuh'] }}</h2>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="card text-white bg-danger mb-3" style="min-width: 16rem;">
                    <div class="card-header text-center"><h2>Meninggal</h2></div>
                    <div class="card-body">
                      <h2 class="card-text text-center">{{ $datas['meninggal'] }}</h2>
                    </div>
                </div>
            </div>
            @endforeach
            <br/>
            <script type="text/javascript">
            var locations = [
               @foreach($location_indo['features'] as $value)
                  [ "{{ $value['geometry']['y'] }}", "{{ $value['geometry']['x'] }}", "{{ $value['attributes']['Provinsi'] }}", "{{ $value['attributes']['Kasus_Posi'] }}", "{{ $value['attributes']['Kasus_Semb'] }}", "{{ $value['attributes']['Kasus_Meni'] }}" ],
               @endforeach
            ];
            </script>
            <div class="row">
               <div id="mapid" style="width: 1280px; height: 400px;"></div>
               <script>
                  var mymap = L.map('mapid').setView([-0.4690016,117.1550653,17], 5);
               
                  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                     maxZoom: 18,
                     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                     id: 'mapbox/dark-v10',
                  }).addTo(mymap);
                  for (i = 0; i < locations.length; i++) {
                     L.marker([locations[i][0],locations[i][1]]).addTo(mymap)
                     .bindPopup("<b>Provinsi : " + locations[i][2] + "</b><br>" +
                     "Positif : " + locations[i][3] + "<br>" +
                     "Sembuh : " + locations[i][4] + "<br>" +
                     "Meninggal : " + locations[i][5] + "<br>"
                     );
                  }
               </script>
            </div>


            <br/>

              <div class="row">
                <div class="col-md-7">
                    <div style="height: 550px; width: 100%">
                        {!! $chart->container() !!}
                        {!! $chart->script() !!}
                    </div>
    
                 </div>
                 <div class="col-md-5">
                    <table class="display compact custom" cellspacing="0" width="420px" id="laravel_datatable">
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
                 </div>
              </div>
             
         </div>
   <script>
   $(document).ready( function () {
    $('#laravel_datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('coronas-list') }}",
           order: [[ 1 , "desc" ]], 
           columns: [
                    //{ data: 'attributes.FID'},
                    { data: 'attributes.Provinsi' },
                    { data: 'attributes.Kasus_Posi' },
                    { data: 'attributes.Kasus_Semb' },
                    { data: 'attributes.Kasus_Meni'}
                 ],
                 "dom": '<"topcustom"lfr>t<"bottomcustom"ip>'
        });
     });
   </script>
   </body>
</html>