<?php

function variable_dump($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    die();
}

function hash_url($input_url) {
    $url_hash=md5($input_url+time());
    return $url_hash;
}

function url_substring($url_hash) {
    $url_partial_hash=substr($url_hash, 0, 6);
    return $url_partial_hash;
}

function http_pad_url($input_url) {
    if (strpos($input_url, 'http') === false) {
        $input_url="http://"."$input_url";
    }

    return $input_url;
}


function insert_url($input_url, $short_url = false) {
    $fields_string="`url_short`, `url_value`, `url_date`";
    $today = current_day();
    $values_string="'$short_url', '$input_url' , '$today'";
    $sql_query=insert_query_builder('url_table', $fields_string , $values_string);
    $result=db_query($sql_query);
    $short_url = get_url_from_last_insert();
    return $short_url;
}

/*
Return the shortened url based on the primary key
used for quickly getting back the short url generated to feed it back to the user
Better than just returning the hash as otherwise if the DB insert fails then it would falsely indicate a successful insert
*/
function get_url_from_last_insert() {
    $last_id = get_last_insert_id();
    $fields="url_short";
    $criteria="`id` = '$last_id'";
    $sql_query=select_query_builder('url_table' , $fields, $criteria);
    $query_result=db_query($sql_query);
    $short_url = query_row_by_name($query_result, 'url_short');
    return $short_url;
}

function current_day() {
    return date("Y-m-d");
}

function insert_query_builder($table, $fields, $values) {
    $query="INSERT INTO " . $table . "(" . $fields . ") VALUES" . "(" . $values . ")";
    return $query;
}

function select_query_builder($table, $fields, $criteria) {
    $query="SELECT" . " $fields " . "FROM " . " $table " . " WHERE " . "$criteria" ;
    return $query;
}

function update_query_builder($table, $field, $criteria, $value) {
    //UPDATE  `url_database`.`url_table` SET  `url_uses` =  '1' WHERE  `url_table`.`url_short` =  'amzn';
    $query="UPDATE ". "$table " . "SET " . "$field = $value"  . " WHERE " . "$criteria" ;
    return $query;
}

function check_if_url_exists($input_url) {
    //$url_array=hash_url($input_url);
    //$url_value_hash=$url_array['url_hash'];
    $fields="*";
    $criteria="`url_value` = '$input_url'";
    $sql_query=select_query_builder('url_table' , $fields, $criteria);
    $query_result=db_query($sql_query);
    $rows=tomi_number_of_rows($query_result);
    //return ($rows > 0) ? true : false;
    if ($rows == 0) {
        return false;
    }
    return true;
}

function check_if_short_url_already_taken($short_url) {
    $fields="*";
    $criteria="`url_short` = '$short_url'";
    $sql_query=select_query_builder('url_table' , $fields, $criteria);
    $query_result=db_query($sql_query);
    $rows=tomi_number_of_rows($query_result);
    //return ($rows > 0) ? true : false;
    if ($rows == 0) {
        $long_url = false;
    }
    else {
        $long_url=query_row_by_name($query_result, 'url_value');
    }
    return $long_url;
}

function get_existing_short_url ($input_url) {
    //$fields="url_short";
    $fields="*";
    $criteria="`url_value` = '$input_url'";
    $sql_query=select_query_builder('url_table' , $fields, $criteria);
    $query_result=db_query($sql_query);
    //$number_of_rows=tomi_number_of_rows($query_result);
    $url_short=query_row_by_name($query_result, 'url_short');
    return $url_short;
}

function get_all_rows ($input_url, $column) {
    $fields="*";
    $criteria="`url_value` = '$input_url'";
    $sql_query=select_query_builder('url_table' , $fields, $criteria);
    $query_result=db_query($sql_query);
    while ($row = tomi_fetch_array($query_result)) {
        $column_data=get_column_from_row($row, $column);
        var_dump($column_data);
    }
}

function get_full_url ($short_url) {
    $short_url=tomi_escape_string($short_url);
    $fields="`url_value`";
    $criteria="`url_short` = '$short_url'";
    $sql_query=select_query_builder('url_table' , $fields, $criteria);
    $query_result=db_query($sql_query);
    $full_url=query_row_by_name($query_result, 'url_value');
    return $full_url;
}

function get_url_uses($short_url) {
    $fields='`url_uses`';
    $criteria="`url_short`='$short_url'";
    $sql_query=select_query_builder('url_table', $fields, $criteria);
    //variable_dump($sql_query);
    $query_result=db_query($sql_query);
    $url_uses=query_row_by_name($query_result, 'url_uses');
    return $url_uses;
}

function increment_url_counter($short_url) {
    $url_uses=get_url_uses($short_url);
    $new_url_uses=$url_uses+1;
    $field='`url_uses`';
    $criteria="`url_short` =  '$short_url'";
    $value=$new_url_uses;
    $sql_query=update_query_builder('url_table', $field, $criteria, $value);
    $query_result=db_query($sql_query);
    $rows=tomi_number_of_rows($query_result);
    if ($rows == 0) {
        return false;
    }
    return true;
}

/*
 * Visual feedback
 */

function feedback_url_already_used ($full_url, $short_url) {
    $server_url=$_SERVER['SERVER_NAME'];
    $short_url_full=$server_url . $short_url;
    $html_string="This short url has already been taken.";
    $html_string .= "<br />";
    $html_string .= "The full url for $short_url is: ";
    $html_string .= "<a href=\"$full_url\">$full_url</a>";
    return $html_string;
}

function feedback_short_url($short_url) {
    $server_url=$_SERVER['SERVER_NAME'];
    $html_string = "Short URL: ";
    $url="$server_url". "/" . "$short_url";
    $html_string .= "<a href=\"//$url\">$url</a>" ;
    return $html_string;
}