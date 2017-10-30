<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Getters;
use App\Models\Asset;
use Carbon\Carbon;
use DB;

class AssetController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $assets = Asset::all();
    $maxScanDate = Carbon::parse(DB::table('assets_ip_compare')->max('scan_date'));
    return view('Asset.index',compact('assets','maxScanDate'))->with(['datatables' => true]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('Asset.create');
  }



  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    if(isset($request->submit_form_one)){

      $this->validate($request, [
        'ip_address'      => 'required',
      ]);

      $stored_asset = Asset::where('ip_address',$request->ip_address)->where('status', $request->status)->pluck('status');

      if(isset($stored_asset[0]) && $stored_asset[0] == $request->status){
        if(isset($request->scan)){
          Asset:: where('ip_address',$request->ip_address)->where('status', $request->status)->update(['scan' => Carbon::createFromFormat('d/m/Y', $request->input('scan'))->toDateString()]);
          return redirect(route('Asset.index'))->with('info', 'Asset '. $asset->ip_address .' was already registered. Scan Date has been updated.');
        }else{
          return redirect(route('Asset.index'))->with('info', 'Asset '. $asset->ip_address .' was already registered. No data has been changed.');
        }
      }else{

        $asset = Asset::updateOrCreate(
          ['ip_address'=>$request->input('ip_address')],
          [
            'ip_address' => $request->input('ip_address'),
            'hostname' => $request->input('hostname'),
            'status_remediation' => $request->input('status_remediation'),
            'ping' => $request->input('ping'),
            'scan' => isset($request->scan) ? Carbon::createFromFormat('d/m/Y', $request->input('scan'))->toDateString() : null,
            'localidade' => $request->input('localidade'),
            'porta_sw' => $request->input('porta_sw'),
            'switch' => $request->input('switch'),
            'vlan_id' => $request->input('vlan_id') != '' ? $request->input('vlan_id') : null,
            'location' => $request->input('location'),
            'site' => $request->input('site'),
            'environment' => $request->input('environment'),
            'obs' => $request->input('obs'),
            'wannacry' => $request->input('wannacry'),
            'doublepulsar' => $request->input('doublepulsar'),
            'vulneravel' => $request->input('vulneravel')
          ]
        );

      }

      return redirect(route('Asset.index'))->with('success', 'Asset '. $asset->ip_address .' registered.');
    }

    elseif(isset($request->submit_form_two)){

      $lines = preg_split("/[\r\n]+/", $request->full_data, -1, PREG_SPLIT_NO_EMPTY);
      $data = [];
      $ips = [];

      foreach ($lines as $line) {
        $data = explode("\t",$line);
        $ips[] = $data[0];
        $stored_asset = Asset::where('ip_address',$data[0])->where('status_remediation', $data[2])->pluck('status_remediation');

        if(isset($stored_asset[0]) && $stored_asset[0] == $data[2]){
          if($data[4] != ""){
            Asset:: where('ip_address',$request->ip_address)->where('status_remediation', $request->status)->update(['scan' => Carbon::createFromFormat('d/m/Y', $data[4])->toDateString()]);
          }else{
            continue;
          }
        }else{

          switch ($data[1]) {
            case 'WannaCry':
            $asset = Asset::updateOrCreate(
              ['ip_address' => $data[0]],
              [
                'status_remediation' =>  isset($data[2]) && $data[2] != "" ? $data[2] : null,
                'ping' =>  isset($data[3]) && $data[3] != "" ? $data[3] : null,
                'scan' => isset($data[4]) && $data[4] != ""  ? Carbon::createFromFormat('d/m/Y', $data[4])->toDateString() : null,
                'localidade' =>  isset($data[5]) && $data[5] != "" ? $data[5] : null,
                'porta_sw' =>  isset($data[6]) && $data[6] != "" ? $data[6] : null,
                'switch' =>  isset($data[7]) && $data[7] != "" ? $data[7] : null,
                'vlan_id' => $data[8] != '' ? $data[8] : null,
                'location' =>  isset($data[9]) && $data[9] != "" ? $data[9] : null,
                'site' =>  isset($data[10]) && $data[10] != "" ? $data[10] : null,
                'environment' =>  isset($data[11]) && $data[11] != "" ? $data[11] : null,
                'obs' => isset($data[12]) && $data[12] != "" ? $data[12] : null,
                'wannacry' =>  1
              ]
            );

            break;
            case 'DoublePulsar':
            $asset = Asset::updateOrCreate(
              ['ip_address' => $data[0]],
              [
                'status_remediation' =>  isset($data[2]) && $data[2] != "" ? $data[2] : null,
                'ping' =>  isset($data[3]) && $data[3] != "" ? $data[3] : null,
                'scan' => isset($data[4]) && $data[4] != ""  ? Carbon::createFromFormat('d/m/Y', $data[4])->toDateString() : null,
                'localidade' =>  isset($data[5]) && $data[5] != "" ? $data[5] : null,
                'porta_sw' =>  isset($data[6]) && $data[6] != "" ? $data[6] : null,
                'switch' =>  isset($data[7]) && $data[7] != "" ? $data[7] : null,
                'vlan_id' => $data[8] != '' ? $data[8] : null,
                'location' =>  isset($data[9]) && $data[9] != "" ? $data[9] : null,
                'site' =>  isset($data[10]) && $data[10] != "" ? $data[10] : null,
                'environment' =>  isset($data[11]) && $data[11] != "" ? $data[11] : null,
                'obs' => isset($data[12]) && $data[12] != "" ? $data[12] : null,
                'doublepulsar' =>  1,
              ]
            );

            break;
            case 'vulnerável' || 'Vulnerabilidades':
            $asset = Asset::updateOrCreate(
              ['ip_address' => $data[0]],
              [
                'status_remediation' =>  isset($data[2]) && $data[2] != "" ? $data[2] : null,
                'ping' =>  isset($data[3]) && $data[3] != "" ? $data[3] : null,
                'scan' => isset($data[4]) && $data[4] != ""  ? Carbon::createFromFormat('d/m/Y', $data[4])->toDateString() : null,
                'localidade' =>  isset($data[5]) && $data[5] != "" ? $data[5] : null,
                'porta_sw' =>  isset($data[6]) && $data[6] != "" ? $data[6] : null,
                'switch' =>  isset($data[7]) && $data[7] != "" ? $data[7] : null,
                'vlan_id' => $data[8] != '' ? $data[8] : null,
                'location' =>  isset($data[9]) && $data[9] != "" ? $data[9] : null,
                'site' =>  isset($data[10]) && $data[10] != "" ? $data[10] : null,
                'environment' =>  isset($data[11]) && $data[11] != "" ? $data[11] : null,
                'obs' => isset($data[12]) && $data[12] != "" ? $data[12] : null,
                'vulneravel' => 1
              ]
            );

            break;
          }
        }
      }

      return redirect(route('Asset.index'))->with('success',count($ips) .' assets registered.');
    }


  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $asset = Asset::find($id);
    return view('Asset.show', compact('asset'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id = null)
  {
    if(!isset($id)){
      return view('Asset.edit');
    }else{
      $asset = Asset::find($id);
      return view('Asset.editOne', compact('asset'));
    }
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id = null)
  {
    if(!isset($id)){
      $wannacry = $request->wannacry ? $request->wannacry : null;
      $doublepulsar = $request->doublepulsar ? $request->doublepulsar : null;
      $vulneravel = $request->vulneravel ? $request->vulneravel : null;

      if(!empty($wannacry)){
        $stringWannacry = str_replace(array("\r\n","\r"),",",$wannacry);
        $arrayWannacry = explode(",",$stringWannacry);

        for ($i=0; $i < count($arrayWannacry); $i++) {
          $asset = Asset::where('ip_address', '=', $arrayWannacry[$i])->get();

          if(!$asset[0]->wannacry){
            $asset[0]->wannacry = true;
            $asset[0]->save();
          }
        }
      }

      if(!empty($doublepulsar)){
        $stringDoublepulsar = str_replace(array("\r\n","\r"),",",$doublepulsar);
        $arrayDoublepulsar = explode(",",$stringDoublepulsar);

        for ($i=0; $i < count($arrayDoublepulsar); $i++) {
          $asset = Asset::where('ip_address', '=', $arrayDoublepulsar[$i])->get();

          if(!$asset[0]->doublepulsar){
            $asset[0]->doublepulsar = true;
            $asset[0]->save();
          }
        }
      }

      if(!empty($vulneravel)){
        $stringVulneravel = str_replace(array("\r\n","\r"),",",$vulneravel);
        $arrayVulneravel = explode(",",$stringVulneravel);

        for ($i=0; $i < count($arrayVulneravel); $i++) {
          $asset = Asset::where('ip_address', '=', $arrayVulneravel[$i])->get();

          if(!$asset[0]->vulneravel){
            $asset[0]->vulneravel = true;
            $asset[0]->save();
          }
        }
      }
    }else{
      $asset = Asset::find($id);
      $asset->ip_address = $request->ip_address;
      $asset->hostname = $request->hostname;
      $asset->status_remediation = $request->status_remediation;
      $asset->localidade = $request->localidade;
      $asset->porta_sw = $request->porta_sw;
      $asset->switch = $request->switch;
      $asset->vlan_id = $request->vlan_id;
      $asset->location = $request->location;
      $asset->site = $request->site;
      $asset->environment = $request->environment;
      $asset->obs = $request->obs;
      $asset->wannacry = isset($request->wannacry) ? 1 : 0;
      $asset->doublepulsar = isset($request->doublepulsar) ? 1 : 0;
      $asset->vulneravel = isset($request->vulneravel) ? 1 : 0;
      $asset->save();
    }
    return redirect(route('Asset.show', $asset->id))->with('success', 'Asset '. $asset->ip_address .' updated.');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
  }


  public function get_servers_vl($vulnerability , $location)  {
    switch ($vulnerability) {
      case 'WannaCry':
      $servers = DB::table('assets')->select('ip_address', 'status', 'localidade','porta_sw','switch','vlan_id','location','site','environment')
      ->where('wannacry',1)->where('localidade',$location)->get();
      break;
      case 'DoublePulsar':
      $servers = DB::table('assets')->select('ip_address', 'status', 'localidade','porta_sw','switch','vlan_id','location','site','environment')
      ->where('doublepulsar',1)->where('localidade',$location)->get();
      break;
      case 'Vulnerable':
      $servers = DB::table('assets')->select('ip_address', 'status', 'localidade','porta_sw','switch','vlan_id','location','site','environment')
      ->where('vulneravel',1)->where('localidade',$location)->get();
      break;
      default:

      return "fail";
      break;

      return $servers->toJson();

    }

  }

  public function search_page(){
    return view('Asset.search');
  }

  public function search_networks(Request $request){

    $lines = preg_split("/[\r\n]+/", $request->ip_list, -1, PREG_SPLIT_NO_EMPTY);
    $results = [];

    foreach ($lines as $ip) {
      $network = Getters::get_localizacao($ip);
      $results[] = [
        'ip_address' => $ip,
        'localizacao'=> $network['localizacao'],
        'cidr'=> $network['cidr'],
        'range'=> $network['range'],
      ];
    }
    return view('Asset.search', compact('results'))->with(['datatables' => true]);
  }

}
