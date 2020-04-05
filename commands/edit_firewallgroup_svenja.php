<?php

require_once('UniFi-API-client/src/Client.php');

require_once('config.php');

$action = $argv[1];

$debug=false;

$ip_svenja = array('192.168.1.103','192.168.1.112','192.168.1.115');
$ip_jule = array('192.168.1.104','192.168.1.113','192.168.1.116');

$group_id = "5cc750e2b6574a0223c15764";
$site_id = 'default';
$group_name = "Svenja";
$group_type = "address-group";

/**
 * initialize the UniFi API connection class and log in to the controller
 */
$unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
$set_debug_mode   = $unifi_connection->set_debug($debug);
$loginresults     = $unifi_connection->login(); // always true regardless of site id

if ($action == "block") {
    $unifi_connection->edit_firewallgroup($group_id, $site_id, $group_name, $group_type, $ip_svenja);
} else {
    $unifi_connection->edit_firewallgroup($group_id, $site_id, $group_name, $group_type, array());
}

sleep(5);

$groups = $unifi_connection->list_firewallgroups($group_id);
$group_members = $groups[0]->group_members;

if ($action == "block") {
        $count = sizeof($ip_svenja);

        foreach ($group_members as $ip) {
            if (in_array($ip,$ip_svenja)) {
                $count--;
            }
        }

        echo $count;
} else {
    echo sizeof($group_members);
}
