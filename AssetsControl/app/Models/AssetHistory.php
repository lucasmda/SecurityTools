<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{

    protected $table = 'assets_history';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id', 'ip_address', 'hostname', 'status','ping','scan', 'localidade', 'porta_sw', 'switch',
      'vlan_id', 'location', 'site', 'environment', 'obs', 'wannacry', 'doublepulsar', 'vulneravel','reference_date'
    ];

    protected $dates = [
      'created_at','update_at','scan','reference_date'
    ];
}
