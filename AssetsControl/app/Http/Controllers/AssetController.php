<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
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
    return view('Asset.index',compact('assets'))->with(['datatables' => true]);;
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
        'ip_address'      => 'required'
      ]);

      $asset = new Asset;
      $asset->ip_address = $request->input('ip_address');
      $asset->hostname = $request->input('hostname');
      $asset->status = $request->input('status');
      $asset->localidade = $request->input('localidade');
      $asset->porta_sw = $request->input('porta_sw');
      $asset->switch = $request->input('switch');
      $asset->vlan_id = $request->input('vlan_id');
      $asset->location = $request->input('location');
      $asset->site = $request->input('site');
      $asset->environment = $request->input('environment');
      $asset->obs = $request->input('obs');
      $asset->wannacry = $request->input('wannacry');
      $asset->doublepulsar = $request->input('doublepulsar');
      $asset->vulneravel = $request->input('vulneravel');
      $asset->save();

      return redirect(route('Asset.index'))->with('success', 'Asset '. $asset->ip_address .' registered.');
    }

    elseif(isset($request->submit_form_two)){

      $lines = preg_split("/[\r\n]+/", $request->full_data, -1, PREG_SPLIT_NO_EMPTY);
      $data = [];
      $ips = [];

      foreach ($lines as $line) {
        $data = explode("\t",$line);
        $ips[] = $data[0];

        switch ($data[1]) {
          case 'WannaCry':
          $asset = Asset::updateOrCreate(
            ['ip_address' => $data[0]],
            [
              'status' => $data[2],
              'localidade' => $data[3],
              'porta_sw' => $data[4],
              'switch' => $data[5],
              'vlan_id' => $data[6],
              'location' => $data[7],
              'site' => $data[8],
              'environment' => $data[9],
              'obs' =>$data[10],
              'wannacry' =>  1
            ]
          );
          break;
          case 'DoublePulsar':
          $asset = Asset::updateOrCreate(
            ['ip_address' => $data[0]],
            [
              'status' => $data[2],
              'localidade' => $data[3],
              'porta_sw' => $data[4],
              'switch' => $data[5],
              'vlan_id' => $data[6],
              'location' => $data[7],
              'site' => $data[8],
              'environment' => $data[9],
              'obs' =>$data[10],
              'doublepulsar' =>  1,
            ]
          );
          break;
          case 'vulnerável':
          $asset = Asset::updateOrCreate(
            ['ip_address' => $data[0]],
            [
              'status' => $data[2],
              'localidade' => $data[3],
              'porta_sw' => $data[4],
              'switch' => $data[5],
              'vlan_id' => $data[6],
              'location' => $data[7],
              'site' => $data[8],
              'environment' => $data[9],
              'obs' =>$data[10],
              'vulneravel' => 1
            ]
          );
          break;
        }

      }

      return redirect(route('Asset.index'))->with('success', 'Assets '. implode($ips,',') .' registered.');
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
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit()
  {
    return view('Asset.edit');
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request)
  {
    //
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
}
