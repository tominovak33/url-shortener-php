<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 09/02/2015
 * Time: 20:43
 */

require('includes/constants.php');
require('includes/database.php');
require('includes/functions.php');
$server_url=$_SERVER['SERVER_NAME'];
//$servername=gethostname();
//variable_dump($servername);
$current_timestamp=time();
$input_url=$_GET['long_url'];
$input_url=tomi_escape_string($input_url);
$input_url=htmlspecialchars($input_url);

$url_array=hash_url($input_url);
if (isset($_GET['url_category'])) {
    $url_category=$_GET['url_category'];
    $url_category=tomi_escape_string($url_category);
}
else {
    $url_category='none';
}

if (isset($_GET['short_url']) && ($_GET['short_url'] != '')) {
    $short_url = $_GET['short_url'];
    $short_url = tomi_escape_string($short_url);
    $long_url  = check_if_short_url_already_taken($short_url);
    if ($long_url !== false ) {
        $feedback_html=feedback_url_already_used($long_url, $short_url);
        echo $feedback_html;
        die();
    }
}

else {
    $short_url=$url_array['url_partial_hash'];
}

echo feedback_short_url($short_url);
$url_hash=$url_array['url_hash'];
$url_partial_hash=$url_array['url_partial_hash'];
if (strpos($input_url, 'http') === false) {
    $input_url="http://"."$input_url";
}
$fields_string="`url_short`, `url_value` , `url_category` , `url_date`";
$values_string="'$short_url', '$input_url', '$url_category' , '$current_timestamp'";
$sql_query=insert_query_builder('url_table', $fields_string , $values_string);
//variable_dump($sql_query);
$result=db_query($sql_query);