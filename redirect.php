<?php
/**
 * Created by PhpStorm.
 * User: tomi
 * Date: 15/02/15
 * Time: 23:10
 */
require('includes/constants.php');
require('includes/database.php');
require('includes/functions.php');
//echo "Redirect";
$short_url=$_GET['url'];
$full_url=get_full_url($short_url);
//increment url counter
increment_url_counter($short_url);
header('Location: ' . $full_url);