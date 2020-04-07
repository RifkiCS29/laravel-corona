<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\CoronaChart;
use App\Charts\StatChart;
use Illuminate\Support\Facades\Http;
use Datatables;

class CoronaController extends Controller
{
    public function index()
    {
        $suspect_indo = collect(Http::get('https://api.kawalcorona.com/indonesia')->json());
        $suspects_prov = collect(Http::get('https://api.kawalcorona.com/indonesia/provinsi')->json());
        $location_indo = collect(Http::get('https://services5.arcgis.com/VS6HdKS0VfIhv8Ct/arcgis/rest/services/COVID19_Indonesia_per_Provinsi/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json')->json());
        $stat_indo = collect(Http::get('https://services5.arcgis.com/VS6HdKS0VfIhv8Ct/arcgis/rest/services/Statistik_Perkembangan_COVID19_Indonesia/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json')->json());
        
        $labels = $suspects_prov->flatten(1)->pluck('Provinsi');
        $data   = $suspects_prov->flatten(1)->pluck('Kasus_Posi');
        $colors = $labels->map(function($item) {
            return $rand_color = '#' . substr(md5(mt_rand()), 0, 6);
        });

        $chart = new CoronaChart;
        $chart->labels($labels);
        $chart->dataset('Kasus Positif', 'doughnut', $data)->backgroundColor($colors);

        $labels_stat = $stat_indo->flatten(2)->where('Jumlah_Kasus_Kumulatif', '!=', null)->pluck('Hari_ke');
        $data_stat  = $stat_indo->flatten(2)->where('Jumlah_Kasus_Kumulatif', '!=', null)->pluck('Jumlah_Kasus_Kumulatif');
        /*$colors_stat = $labels_stat->map(function($item) {
            return $rand_color = '#' . substr(md5(mt_rand()), 0, 6);
        });*/

        //dd($labels_stat);
        $chart_stat = new StatChart;
        $chart_stat->labels($labels_stat);
        $chart_stat->dataset('Jumlah Kumulatif', 'line', $data_stat)->backgroundColor('#EBF5FB'); 

        return view('welcome', [
            'chart' => $chart, 'chart_stat' => $chart_stat, 'suspect_indo' => $suspect_indo, 'location_indo' => $location_indo
        ]);
    }

    public function coronaList()
    {
        $response = Http::get('https://api.kawalcorona.com/indonesia/provinsi');
        $coronas = $response->json();
        return datatables()->of($coronas)->make(true);
        //dd($coronas);
    }
}
