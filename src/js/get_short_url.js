/**
 * Created by tomi on 14/06/15.
 */

function get_short_url(input_url) {
    //use API to get short url
    var api_domain = 'http://url-shorten.tomi.dev/';
    var full_url_value = document.getElementById('url').value;
    //call the api function with my callback
    var short_url_api_return = send_api_request(api_domain + 'api', 'url', full_url_value, function(result) {
        var short_url = short_url_from_api_return(result);
        var response_data = document.getElementById('response-data');
        var response_link = create_short_url_link(api_domain, short_url);
        response_data.appendChild(response_link);
        display_response();
    });
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

function create_short_url_link (domain, short_url) {
    var response_link = document.createElement('a');
    response_link.href = domain+short_url;
    response_link.innerHTML = short_url;
    return response_link;
}

function short_url_from_api_return(returned_date ){
    returned_date = JSON.parse(returned_date);
    return returned_date.short_url;
}