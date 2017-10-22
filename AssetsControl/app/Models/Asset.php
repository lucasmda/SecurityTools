<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id', 'ip_address', 'hostname', 'status', 'localidade', 'porta_sw', 'switch',
      'vlan_id', 'location', 'site', 'environment', 'obs', 'wannacry', 'doublepulsar', 'vulneravel'
    ];
}
