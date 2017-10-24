<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localization extends Model{

  protected $table = 'localizacoes';

  protected $fillable = ['name','network_ip','network_size'];

}
