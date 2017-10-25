<?php

namespace App\Utils;

use DB;

/**
 *
 */
class Getters{

  public static function get_localizacao($ip)  {

    $subnets = self::list_subnets();
    foreach ($subnets as $subnet) {
      if(self::ip_in_range($ip, $subnet['cidr'])){
        return $subnet;
      }
    }
    return ['localizacao'=>"UNDEFINED"];

  }

  public static function list_subnets()
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

  /**
  * Check if a given ip is in a network
  * @param  string $ip    IP to check in IPV4 format eg. 127.0.0.1
  * @param  string $range IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
  * @return boolean true if the ip is in this range / false if not.
  */
  public static function ip_in_range( $ip, $range ) {
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

}
