<?php
/**
 * Created by PhpStorm.
 * User: tomi
 * Date: 13/06/15
 * Time: 10:20
 */

function shorten_url($input_url) {

    $input_url=tomi_escape_string($input_url);
    $input_url=htmlspecialchars($input_url);

    $url_hash = get_short_url($input_url);

    $input_url = http_pad_url($input_url);

    $short_url = insert_url($input_url, $url_hash);

    return($short_url);
}


function get_url($short_url) {

    $short_url=tomi_escape_string($short_url);
    $short_url=htmlspecialchars($short_url);

    $full_url = get_full_url($short_url);

    return $full_url;
}