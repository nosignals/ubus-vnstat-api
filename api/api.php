<?php
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Origin: *");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: application/json; charset=utf-8");

echo '{';
$cnt = 0;
if (isset($_GET['network'])) {
    $dt = $_GET['network'];
    $query = shell_exec("ubus call network.interface.$dt status");
    echo '"network":{"status": true, "data":[';
    if(empty( $query )){
       echo '], "error":"interface not found"},';
    } else { echo $query; echo '], "error": null},'; }
} else { echo '"network":{"status": false, "data":[ ], "error":"no data"},'; $cnt++; }

if (isset($_GET['system'])) {
    $dt = $_GET['system'];
    echo '"system":{"status": true, "data":[';
    $query = shell_exec("ubus call system $dt");
    if(empty( $query )){
       echo '], "error":"parameter not found"},';
    } else { echo $query; echo '], "error": null},'; }
} else { echo '"system":{"status": false, "data":[ ], "error":"no data"},'; $cnt++; }

if (isset($_GET['vnstat'])) {
    $dt = $_GET['vnstat'];
    echo '"vnstat":{"status": true, "data":[';
    $query = shell_exec("vnstat --json -i $dt");
    if(empty( $query )){
       echo '], "error":"interface not found"}';
    } else { echo $query; echo '], "error": null}'; }
} else { echo '"vnstat":{"status": false, "data":[ ], "error":"no data"}'; $cnt++; }

echo '}';
?>