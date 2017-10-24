<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JavaScript;
use DB;

class HomeController extends Controller{

  public function index()
  {
    $data['byStatus'] = DB::table('assets')->select('status', DB::raw('count(*) as amount'))->groupBy('status')->get();
    $data['byVulnerability']['WannaCry'] = DB::table('assets')->where('wannacry',1)->get();
    $data['byVulnerability']['DoublePulsar'] = DB::table('assets')->where('doublepulsar',1)->get();
    $data['byVulnerability']['Vulnerable'] = DB::table('assets')->where('vulneravel',1)->get();
    $data['all'] = DB::table('assets')->select('ip_address','hostname','status','localidade','ping','wannacry','doublepulsar','vulneravel')->get();
    $drilldownCounts = [];

    foreach ($data['byVulnerability']['WannaCry']->groupBy('localidade') as $key => $value) {
      $drilldownCounts['WannaCry'][] = [$key, $value->count()];
    }
    foreach ($data['byVulnerability']['DoublePulsar']->groupBy('localidade') as $key => $value) {
      $drilldownCounts['DoublePulsar'][] = [$key, $value->count()];
    }
    foreach ($data['byVulnerability']['Vulnerable']->groupBy('localidade') as $key => $value) {
      $drilldownCounts['Vulnerable'][] = [$key, $value->count()];
    }

    $seriesVulnerabilities =
    [
      [
        'name' => 'WannaCry',
        'color'=> '#ff0000',
        'y' => $data['byVulnerability']['WannaCry']->count(),
        'drilldown' => 'WannaCry'
      ],
      [
        'name'=> 'DoublePulsar',
        'color'=> '#336699',
        'y'=> $data['byVulnerability']['DoublePulsar']->count(),
        'drilldown'=> 'DoublePulsar'
      ],
      [
        'name'=> 'Vulnerable',
        'color'=> '#007bff',
        'y'=> $data['byVulnerability']['Vulnerable']->count(),
        'drilldown'=> 'Vulnerable'
      ],
    ];

    $drilldownVulnerabilities = [
        [
          'name' => 'WannaCry',
          'id'=> 'WannaCry',
          'data' => $drilldownCounts['WannaCry']
        ],
        [
          'name' => 'DoublePulsar',
          'id'=> 'DoublePulsar',
          'data' => $drilldownCounts['DoublePulsar']
        ],
        [
          'name' => 'Vulnerable',
          'id'=> 'Vulnerable',
          'data' => $drilldownCounts['Vulnerable']
        ],
    ];

    JavaScript::put([
      'series_vulnerabilities' => $seriesVulnerabilities,
      'drilldown_vulnerabilities' => $drilldownVulnerabilities
    ]);

    return view('home.index', compact('data'))->with(['datatables' => true]);
  }


}
