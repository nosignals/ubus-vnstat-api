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
    if ($dt === "device") {
        $query = shell_exec("ubus call network.device status");
        echo '"network":{"status": true, "data":[';
        if (empty($query)) {
            echo '], "error":"query error"},';
        } else {
            echo $query;
            echo '], "error": null},';
        }
    } else {
        $query = shell_exec("ubus call network.interface.$dt status");
        echo '"network":{"status": true, "data":[';
        if (empty($query)) {
            echo '], "error":"interface not found"},';
        } else {
            echo $query;
            echo '], "error": null},';
        }
    }
} else {
    echo '"network":{"status": false, "data":[ ], "error":"no data"},';
    $cnt++;
}

if (isset($_GET['system'])) {
    $dt = $_GET['system'];
    echo '"system":{"status": true, "data":[';
    $query = shell_exec("ubus call system $dt");
    if (empty($query)) {
        echo '], "error":"parameter not found"},';
    } else {
        echo $query;
        echo '], "error": null},';
    }
} else {
    echo '"system":{"status": false, "data":[ ], "error":"no data"},';
    $cnt++;
}

if (isset($_GET['vnstat'])) {
    $dt = $_GET['vnstat'];
    echo '"vnstat":{"status": true, "data":[';
    $query = shell_exec("vnstat --json -i $dt");
    if (empty($query)) {
        echo '], "error":"interface not found"}';
    } else {
        echo $query;
        echo '], "error": null},';
    }
} else {
    echo '"vnstat":{"status": false, "data":[ ], "error":"no data"},';
    $cnt++;
}

if (isset($_GET['netdata'])) {
    $dt = $_GET['netdata'];
    $showData = '0';
    if (isset($_GET['data'])) {
        $dt2 = $_GET['data'];
        if ($dt2 === "all") {
            $showData = "1";
        } else {
            $showData = "0";
        }
    }
    echo '"netdata":{"status": true, "data":[';
    netdataParse($dt, $showData);
} else {
    echo '"netdata":{"status": false, "data":[ ], "error":"no data"}';
    $cnt++;
}
echo '}';
function netdataParse($param, $cond)
{
    if ($param === "info") {
        $getData = file_get_contents("http://127.0.0.1:19999/api/v1/info");
        echo $getData;
        echo '], "error": null}';
    }
    else if ($param === "temp") {
        $rawDt = shell_exec("cat /sys/class/thermal/thermal_zone0/temp | awk '{print $1}'");
        $jsDt = "{ \"temp\": $rawDt } ], \"error\":\"null\"}";
        echo $jsDt;
    } else {
        $rawr = shell_exec("curl http://127.0.0.1:19999/api/v1/data?chart=$param");
        if ($cond === "1") {
            if ($rawr === "Chart is not found: $param") {
                echo '], "error":"parameter not found"}';
            } else {
                $getData = file_get_contents("http://127.0.0.1:19999/api/v1/data?chart=$param");
                echo $getData;
                echo '], "error": null}';
            }
        } else {
            if ($rawr === "Chart is not found: $param") {
                echo '], "error":"parameter not found"}';
            } else {
                $getData = file_get_contents("http://127.0.0.1:19999/api/v1/data?chart=$param&after=-1");
                echo $getData;
                echo '], "error": null}';
            }
        }
    }
}
?>
