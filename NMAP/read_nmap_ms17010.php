<?php

$fileName = $argv[1];

$xml = simplexml_load_file($fileName);

foreach ($xml->host as $hosts) {
  if(!empty($hosts->hostscript->script["id"])){
    echo $hosts->address["addr"] . ", this host is Vulnerable to ". $hosts->hostscript->script["id"] . ".";
    echo "\n";
  }
}
?>
