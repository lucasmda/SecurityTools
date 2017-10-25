<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Getters;
use App\Models\Asset;
use Carbon\Carbon;
use DB;

class ImportController extends Controller{

  public function index(){
    return view('Import.index');
  }

  public function import_ip_compare(Request $request){

    $lines = preg_split("/[\r\n]+/", $request->ip_compare_data, -1, PREG_SPLIT_NO_EMPTY);
    $scan_date = $request->scan_date;
    $scan_period = $request->scan_period;

    foreach ($lines as $line) {
      $data = explode("\t",$line);

      $location = Getters::get_localizacao($data[0])['localizacao'];

      DB::table('assets_ip_compare')->insert([
        [
          'ip_address' => $data[0],
          'localidade' => $location,
          'source' => $data[1],
          'scan_date' => $scan_date,
          'scan_period' => $scan_period,
        ]
      ]);

      switch ($data[1]) {
        case 'WannaCry':
        case 'wannacry':
        $asset = Asset::updateOrCreate(
          ['ip_address' => $data[0]],
          [
            'scan' => $scan_date,
            'localidade' =>  $location,
            'wannacry' =>  1
          ]
        );
        break;
        case 'DoublePulsar':
        $asset = Asset::updateOrCreate(
          ['ip_address' => $data[0]],
          [
            'scan' => $scan_date,
            'localidade' =>  $location,
            'doublepulsar' =>  1,
          ]
        );
        break;
        case 'vulnerável':
        case 'Vulnerabilidades':
        case 'Vulnerable':
        $asset = Asset::updateOrCreate(
          ['ip_address' => $data[0]],
          [
            'scan' => $scan_date,
            'localidade' =>  $location,
            'vulneravel' => 1
          ]
        );
        break;
      }

    }
    return redirect(url('/Import'))->with('success', 'All data was registered.');

  }


}
