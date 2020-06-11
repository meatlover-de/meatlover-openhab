<?php

require_once('UniFi-API-client/src/Client.php');

require_once('config.php');

$action = $argv[1];

$debug=false;

$ip_jule = array('192.168.1.104','192.168.1.113','192.168.1.116','192.168.1.175','192.168.1.161');

$group_id = "5cc7510bb6574a0223c15765";
$site_id = 'default';
$group_name = "Jule";
$group_type = "address-group";

/**
 * initialize the UniFi API connection class and log in to the controller
 */
$unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
$set_debug_mode   = $unifi_connection->set_debug($debug);
$loginresults     = $unifi_connection->login(); // always true regardless of site id

if ( $action == "block" ) { 
    $unifi_connection->edit_firewallgroup($group_id, $site_id, $group_name, $group_type, $ip_jule);
} else {
    $unifi_connection->edit_firewallgroup($group_id, $site_id, $group_name, $group_type, array());
}

sleep(5);

$groups = $unifi_connection->list_firewallgroups($group_id);
$group_members = $groups[0]->group_members;

if ($action == "block") {
        $count = sizeof($ip_jule);

        foreach ($group_members as $ip) {
            if (in_array($ip,$ip_jule)) {
                $count--;
            }
        }

        echo $count;
} else {
    echo sizeof($group_members);
}
