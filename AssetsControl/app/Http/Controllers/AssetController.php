<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetHistory;
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
    return view('Asset.index',compact('assets'))->with(['datatables' => true]);
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

  public function get_localizacao($ip)
  {
    $subnets = self::list_subnets();
    foreach ($subnets as $subnet) {
      if(self::ip_in_range($ip, $subnet['cidr'])){
        return $subnet;
      }
    }
    return ['localizacao'=>"UNDEFINED"];

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
        'reference_date'  => 'required'
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
            'status' => $request->input('status'),
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

        $asset_history = AssetHistory::updateOrCreate(
          ['ip_address'=>$request->input('ip_address'), 'reference_date' => $request->input('reference_date')],
          [
            'ip_address'=>$request->input('ip_address'),
            'hostname' => $request->input('hostname'),
            'status' => $request->input('status'),
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
            'vulneravel' => $request->input('vulneravel'),
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
        $stored_asset = Asset::where('ip_address',$data[0])->where('status', $data[2])->pluck('status');

        if(isset($stored_asset[0]) && $stored_asset[0] == $data[2]){
          if($data[4] != ""){
            Asset:: where('ip_address',$request->ip_address)->where('status', $request->status)->update(['scan' => Carbon::createFromFormat('d/m/Y', $data[4])->toDateString()]);
          }else{
            continue;
          }
        }else{

          switch ($data[1]) {
            case 'WannaCry':
            $asset = Asset::updateOrCreate(
              ['ip_address' => $data[0]],
              [
                'status' =>  isset($data[2]) && $data[2] != "" ? $data[2] : null,
                'ping' =>  isset($data[3]) && $data[3] != "" ? $data[3] : null,
                'scan' => $data[4] != ""  ? Carbon::createFromFormat('d/m/Y', $data[4])->toDateString() : null,
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
            $asset_history = AssetHistory::updateOrCreate(
              ['ip_address'=>$data[0], 'reference_date' => $request->input('reference_date')],
              [
                'ip_address'=>$data[0],
                'status' =>  isset($data[2]) && $data[2] != "" ? $data[2] : null,
                'ping' =>  isset($data[3]) && $data[3] != "" ? $data[3] : null,
                'scan' => $data[4] != ""  ? Carbon::createFromFormat('d/m/Y', $data[4])->toDateString() : null,
                'localidade' =>  isset($data[5]) && $data[5] != "" ? $data[5] : null,
                'porta_sw' =>  isset($data[6]) && $data[6] != "" ? $data[6] : null,
                'switch' =>  isset($data[7]) && $data[7] != "" ? $data[7] : null,
                'vlan_id' => $data[8] != '' ? $data[8] : null,
                'location' =>  isset($data[9]) && $data[9] != "" ? $data[9] : null,
                'site' =>  isset($data[10]) && $data[10] != "" ? $data[10] : null,
                'environment' =>  isset($data[11]) && $data[11] != "" ? $data[11] : null,
                'obs' => isset($data[12]) && $data[12] != "" ? $data[12] : null,
                'wannacry' =>  1,
                'reference_date' =>  $request->input('reference_date')
              ]
            );
            break;
            case 'DoublePulsar':
            $asset = Asset::updateOrCreate(
              ['ip_address' => $data[0]],
              [
                'status' =>  isset($data[2]) && $data[2] != "" ? $data[2] : null,
                'ping' =>  isset($data[3]) && $data[3] != "" ? $data[3] : null,
                'scan' => $data[4] != ""  ? Carbon::createFromFormat('d/m/Y', $data[4])->toDateString() : null,
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
            $asset_history = AssetHistory::updateOrCreate(
              ['ip_address'=>$data[0], 'reference_date' => $request->input('reference_date')],
              [
                'ip_address'=>$data[0],
                'status' =>  isset($data[2]) && $data[2] != "" ? $data[2] : null,
                'ping' =>  isset($data[3]) && $data[3] != "" ? $data[3] : null,
                'scan' => $data[4] != ""  ? Carbon::createFromFormat('d/m/Y', $data[4])->toDateString() : null,
                'localidade' =>  isset($data[5]) && $data[5] != "" ? $data[5] : null,
                'porta_sw' =>  isset($data[6]) && $data[6] != "" ? $data[6] : null,
                'switch' =>  isset($data[7]) && $data[7] != "" ? $data[7] : null,
                'vlan_id' => $data[8] != '' ? $data[8] : null,
                'location' =>  isset($data[9]) && $data[9] != "" ? $data[9] : null,
                'site' =>  isset($data[10]) && $data[10] != "" ? $data[10] : null,
                'environment' =>  isset($data[11]) && $data[11] != "" ? $data[11] : null,
                'obs' => isset($data[12]) && $data[12] != "" ? $data[12] : null,
                'doublepulsar' =>  1,
                'reference_date' =>  $request->input('reference_date')
              ]
            );
            break;
            case 'vulnerável' || 'Vulnerabilidades':
            $asset = Asset::updateOrCreate(
              ['ip_address' => $data[0]],
              [
                'status' =>  isset($data[2]) && $data[2] != "" ? $data[2] : null,
                'ping' =>  isset($data[3]) && $data[3] != "" ? $data[3] : null,
                'scan' => $data[4] != ""  ? Carbon::createFromFormat('d/m/Y', $data[4])->toDateString() : null,
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
            $asset_history = AssetHistory::updateOrCreate(
              ['ip_address'=>$data[0], 'reference_date' => $request->input('reference_date')],
              [
                'ip_address'=>$data[0],
                'status' =>  isset($data[2]) && $data[2] != "" ? $data[2] : null,
                'ping' =>  isset($data[3]) && $data[3] != "" ? $data[3] : null,
                'scan' => $data[4] != ""  ? Carbon::createFromFormat('d/m/Y', $data[4])->toDateString() : null,
                'localidade' =>  isset($data[5]) && $data[5] != "" ? $data[5] : null,
                'porta_sw' =>  isset($data[6]) && $data[6] != "" ? $data[6] : null,
                'switch' =>  isset($data[7]) && $data[7] != "" ? $data[7] : null,
                'vlan_id' => $data[8] != '' ? $data[8] : null,
                'location' =>  isset($data[9]) && $data[9] != "" ? $data[9] : null,
                'site' =>  isset($data[10]) && $data[10] != "" ? $data[10] : null,
                'environment' =>  isset($data[11]) && $data[11] != "" ? $data[11] : null,
                'obs' => isset($data[12]) && $data[12] != "" ? $data[12] : null,
                'vulneravel' =>  1,
                'reference_date' =>  $request->input('reference_date')
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
      $asset->status = $request->status;
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

  /**
  * Check if a given ip is in a network
  * @param  string $ip    IP to check in IPV4 format eg. 127.0.0.1
  * @param  string $range IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
  * @return boolean true if the ip is in this range / false if not.
  */
  function ip_in_range( $ip, $range ) {
    if ( strpos( $range, '/' ) == false ) {
      $range .= '/32';
    }
    // $range is in IP/CIDR format eg 127.0.0.1/24
    list( $range, $netmask ) = explode( '/', $range, 2 );
    $range_decimal = ip2long( $range );
    $ip_decimal = ip2long( $ip );
    $wildcard_decimal = pow( 2, ( 32 - $netmask ) ) - 1;
    $netmask_decimal = ~ $wildcard_decimal;
    return ( ( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal ) );
  }

  public function list_subnets()
  {
    $ips = DB::table('localizacoes')->select('name','network_ip','network_size','network_range')->get();
    $data = [];
    foreach ($ips as $ip) {
      $data[] =[
        'localizacao' => $ip->name,
        'cidr' => (string)$ip->network_ip . '/' . (string) $ip->network_size,
        'range' => $ip->network_range
      ];
    }
    return $data;
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
      $network = self::get_localizacao($ip);
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
