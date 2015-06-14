<?php
/**
 * Created by PhpStorm.
 * User: tomi
 * Date: 13/06/15
 * Time: 08:42
 */

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require('includes/constants.php');
require('includes/database.php');
require('includes/functions.php');
require('main_functions.php');

$response = [];

if (isset($_GET['url'])) {
    $response['short_url'] = shorten_url($_GET['url']);
}

elseif (isset($_GET['short_url'])) {

    $full_url =get_url($_GET['short_url']); //todo increment url counter

    if (isset($_GET['redirect'])) {
        header('Location: ' . $full_url);
    }

    $response['full_url'] = $full_url;
}

$response = json_encode($response);
echo $response;