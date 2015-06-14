/**
 * Created by tomi on 14/06/15.
 */

function get_short_url(input_url) {
    //use API to get short url
    var api_domain = 'http://url-shorten.tomi.dev/api';
    var full_url_value = 'test.example.com';
    //call the api function with my callback
    var short_url_api_return = send_api_request(api_domain, 'url', full_url_value, function(result) {
        result = JSON.parse(result);
        var short_url = result.short_url;
        console.log(short_url);
    });
}

function process_api_return(result) {
    console.log(result);
}

function send_api_request(url, parameter, value, callback) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    }
    else {
        //show message that the browser does not support xmlhttp
        return false;
    }
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            callback(xmlhttp.responseText);
        }
    };

    var full_request_url = url+'/?'+parameter+'='+value;
    xmlhttp.open("GET",full_request_url,true);
    xmlhttp.send();
}