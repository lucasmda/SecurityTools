<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JavaScript;
use DB;

class HomeController extends Controller{

  public function index()
  {
    $maxDate = DB::table('assets_ip_compare')->max('scan_date');
    $data['byStatus'] = DB::table('assets')->select('status_remediation', DB::raw('count(*) as amount'))->groupBy('status_remediation')->get();
    $data['byVulnerability']['WannaCry'] = DB::table('assets')->where('wannacry',1)->get();
    $data['byVulnerability']['DoublePulsar'] = DB::table('assets')->where('doublepulsar',1)->get();
    $data['byVulnerability']['Vulnerable'] = DB::table('assets')->where('vulneravel',1)->get();
    $data['all'] = DB::table('assets')->select('ip_address','hostname','status_host','status_remediation','localidade','ping','wannacry','doublepulsar','vulneravel')->get();
    $drilldownCounts = [];

    $date_range = DB::table('assets_ip_compare')
    ->select('scan_date')
    ->distinct()
    ->latest('scan_date')
    ->limit(30)
    ->get()
    ->sortBy('scan_date')
    ->pluck('scan_date');

    $detection_history = [];

    foreach ($date_range as $date) {
      $detection_history['WannaCry'][] = DB::table('assets_ip_compare')->where('scan_date',$date)->where('source','WannaCry')->count();
      $detection_history['DoublePulsar'][] = DB::table('assets_ip_compare')->where('scan_date',$date)->where('source','DoublePulsar')->count();
      $detection_history['Vulnerable'][] = DB::table('assets_ip_compare')->where('scan_date',$date)->whereIn('source',['Vulnerable','Vulneravel','Vulnerabilidades','Vulneráveis'])->count();
    }

    // $tree = [];
    // $tree[0] = ['text' => 'WannaCry', 'icon' => 'fa fa-plus', 'selectedIcon' => 'fa fa-minus','nodes'=> []];
    // $tree[1] = ['text' => 'DoublePulsar', 'icon' => 'fa fa-plus', 'selectedIcon' => 'fa fa-minus','nodes'=> []];
    // $tree[2] = ['text' => 'Vulnerable', 'icon' => 'fa fa-plus', 'selectedIcon' => 'fa fa-minus','nodes'=> []];

    foreach ($data['byVulnerability']['WannaCry']->groupBy('localidade') as $key => $value) {
      // $tree[0]['nodes'][] = ['text'=>$key, 'nodes'=>[]];
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
          'data' => isset($drilldownCounts['WannaCry']) ? $drilldownCounts['WannaCry'] : 0
        ],
        [
          'name' => 'DoublePulsar',
          'id'=> 'DoublePulsar',
          'data' => isset($drilldownCounts['DoublePulsar']) ? $drilldownCounts['DoublePulsar'] : 0
        ],
        [
          'name' => 'Vulnerable',
          'id'=> 'Vulnerable',
          'data' => isset($drilldownCounts['Vulnerable']) ? $drilldownCounts['Vulnerable'] : 0
        ],
    ];

    JavaScript::put([
      'series_vulnerabilities' => $seriesVulnerabilities,
      'drilldown_vulnerabilities' => $drilldownVulnerabilities,
      'date_range' => $date_range,
      'detection_history' => $detection_history
      // 'tree' => $tree
    ]);

    return view('home.index', compact('data'))->with(['datatables' => true]);
  }


}
