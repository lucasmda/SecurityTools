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
      return back()->with('success', 'Asset '. $asset->ip_address .' updated.');
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
