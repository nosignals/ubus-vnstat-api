# UBUS VNSTAT NETDATA API
ubus, vnstat, netdata api for OpenWrt Devices

## Feature

- Monitoring UBUS and VNSTAT command from CLI to JSON data
- Realtime Monitoring 
- Support all Device
- Get Realtime `UBUS NETWORK` data JSON
- Get Realtime `UBUS SYSTEM` data JSON
- Get latest Update `VNSTAT` data JSON
- Get latest Update `NETDATA` data JSON


## Requirement

- Installed package `php vnstat ubus netdata`

## Installing API

> 1. Install the required packages `php7 php7-cgi vnstat ubus netdata` (i'm testing at `php7` & `vnstat`, not `vnstat2`)
> 2. Download or Clone this repository
> 3. Extract downloads file
> 4. **Move** or **Copy** folder `api` to `/www/`
> 5. API is ready to use

## Example
You can call multiple parameter.
Example is available with Javascript,, Go to folder `example`.
Usage : 
open your browser and type this link `http://yourip/api.php?network=yourSupportedInterfaces&system=parameter&vnstat=parameter`
### Javascript
Example get Array JSON from this API
```js
fetch('http://yourhost/api/api.php?system=board&vnstat=eth0&network=wwan0').then(function (response) { return response.json();
        }).then(function (data){
        var data = data......; // You can set configuration json data in here. You can see this JSON structure at below.
        }).catch(function (error) {
            console.log(error);
        });
```
### PHP
Example get Array from this API
```php
$arr = json_decode(file_get_contents('http://yourhost/api/api.php?system=board&vnstat=eth0&network=wwan0'), true);
print_r($arr);
```

## Structure
### Network
> #### network Updates
> - added interface devices.
> #### How to call JSON network interface devices.
> open your browser and type this link `http://yourip/api/api.php?network=device`
example query data result :
```json
"network":{
      "status":true,
      "data":[
         {
            "br-lan":{
               "external":false,
               "present":true,
               "type":"bridge",
               "up":true,
               "carrier":true,
               "auth_status":false,
               "bridge-members":[
                  "eth0"
               ],
               "mtu":1500,
               "mtu6":1500,
               "macaddr":"00:15:18:01:81:31",
               "txqueuelen":1000,
               "ipv6":false,
               "ip6segmentrouting":false,
               "promisc":false,
               "rpfilter":0,
               "acceptlocal":false,
               "igmpversion":0,
               "mldversion":0,
               "neigh4reachabletime":30000,
               "neigh6reachabletime":30000,
               "neigh4gcstaletime":60,
               "neigh6gcstaletime":60,
               "neigh4locktime":99,
               "dadtransmits":1,
               "multicast":true,
               "sendredirects":true,
               "drop_v4_unicast_in_l2_multicast":false,
               "drop_v6_unicast_in_l2_multicast":false,
               "drop_gratuitous_arp":false,
               "drop_unsolicited_na":false,
               "arp_accept":false,
               "statistics":{
                  "collisions":0,
                  "rx_frame_errors":0,
                  "tx_compressed":0,
                  "multicast":0,
                  "rx_length_errors":0,
                  "tx_dropped":0,
                  "rx_bytes":1347973816,
                  "rx_missed_errors":0,
                  "tx_errors":0,
                  "rx_compressed":0,
                  "rx_over_errors":0,
                  "tx_fifo_errors":0,
                  "rx_crc_errors":0,
                  "rx_packets":12915564,
                  "tx_heartbeat_errors":0,
                  "rx_dropped":0,
                  "tx_aborted_errors":0,
                  "tx_packets":8925008,
                  "rx_errors":0,
                  "tx_bytes":39272951715,
                  "tx_window_errors":0,
                  "rx_fifo_errors":0,
                  "tx_carrier_errors":0
               }
            }
         }
      ],
      "error":null
   },
```

Network has some structure, You can check supported network interface from Terminal, 
Copy this command and paste at your terminal `ubus list | grep network.interface`, to check supported network interface.
sample data results
```bash
~# ubus list | grep network.interface
network.interface
network.interface.eth1
network.interface.lan
network.interface.loopback
network.interface.tether
network.interface.wwan0
```
#### How to call JSON network value.
open your browser and type this link `http://yourip/api/api.php?network=yourSupportedInterfaces`

example JSON structure from this api
```json
{
   "status":true,
   "data":[
      {
         "up":true,
         "pending":false,
         "available":true,
         "autostart":true,
         "dynamic":false,
         "uptime":156,
         "l3_device":"br-lan",
         "proto":"static",
         "device":"br-lan",
         "updated":[
            "addresses"
         ],
         "metric":0,
         "dns_metric":0,
         "delegation":true,
         "ipv4-address":[
            {
               "address":"192.168.1.1",
               "mask":24
            }],
         "ipv6-address":[ ],
         "ipv6-prefix":[ ],
         "ipv6-prefix-assignment":[
            {
               "address":"fdd7:8206:fe3e::",
               "mask":60,
               "local-address":{ }
            }
         ],
         "route":[ ],
         "dns-server":[ ],
         "dns-search":[ ],
         "neighbors":[ ],
         "inactive":{
            "ipv4-address":[ ],
            "ipv6-address":[ ],
            "route":[ ],
            "dns-server":[ ],
            "dns-search":[ ],
			"neighbors":[ ]
			},
         "data":{ }
      }
   ],
   "error":null
}
```

### System
System only has 2 parameter
- 1. `board` = get data from the board device system you are using, ex (version, kernel, hostname, board, etc).
- 2. `info` = get information data, ex (uptime, cpu load, memory).

#### How to call JSON system value.
open your browser and type this link `http://yourip/api/api.php?system=yourparameter`

example JSON structure from this api with parameter `board`
```json
{
      "status":true,
      "data":[
         {
            "kernel":"5.4",
            "hostname":"terongWrt",
            "system":"ARMv8 Processor rev 4",
            "model":"Amlogic Meson GXL (S905X) P212 Development Board",
            "board_name":"amlogic,p212",
            "release":{
               "distribution":"OpenWrt",
               "version":"21.02.5",
               "revision":"r16688-fa9a932fdb",
               "target":"armvirt/64",
               "description":"OpenWrt 21.02.5 r16688-fa9a932fdb"
            }
         }
      ],
      "error":null
}
```
example JSON structure from this api with parameter `info`
```json
{
   "status":true,
   "data":[{
         "localtime":1675889498,
         "uptime":1270,
         "load":[
            0,
            2656,
            4512
         ],
         "memory":{
            "total":843821056,
            "free":477286400,
            "shared":17694720,
            "buffered":3760128,
            "available":638783488,
            "cached":211587072
         },
         "swap":{
            "total":0,
            "free":0
         }
      }
   ],
   "error":null
}
```

### Vnstat
Vnstat has only saved Interface structure, if your vnstat configuration is `eth0`, you can only call with parameter `eth0`

#### How to call JSON vnstat value.
open your browser and type this link `http://yourip/api/api.php?vnstat=yourparameter`

### NetData
NetData has similiar to network,,, has some parameter, i'm just add temperature parameter

#### How to call JSON NetData temperature value.
open your browser and type this link `http://yourip/api/api.php?netdata=temp`

#### How to call JSON NetData value.
open your browser and type this link `http://yourip/api/api.php?netdata=yourparameter`
`yourparameter` is a your calling value
example:
- you want to fetch `Network ETH0` Device
- you can call with parameter `net.eth0`, this parameter has similarities with netdata, ex `http://yourip/api/api.php?netdata=net.eth0`
- get **information netdata** data, with parameter `info`, ex `http://yourip/api/api.php?netdata=info`
- get **system usage** data, with parameter `cpu ram` and etc, ex `http://yourip/api/api.php?netdata=info`

if you want to show all data you can add `data=all` function. ex `http://yourip/api/api.php?netdata=net.eth0&data=all`

## About
nosignal is gone

## Credits
> - [nosignal](https://github.com/nosignals)
> - [indoWRT](https://www.facebook.com/groups/728998271085718)
> - [DBAI](https://www.facebook.com/groups/421688359852864)
> - GTerongers
