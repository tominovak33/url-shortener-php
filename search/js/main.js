/**
 * Created by tomi on 11/10/15.
 */

var tag_input = document.getElementById("url_input");
tag_input.onkeyup = function(){
  if (tag_input.value.length > 0) {
    sendSearchQuery(tag_input.value, processSearchResults);
  }
  else {
    clearDropdown();
  }
 };

function sendSearchQuery (search_term, callback) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //console.log(xmlhttp.responseText);
            callback(xmlhttp.responseText);
        }
    };
    var searchAPIUrl = location.protocol + "//" + location.host + "/api/";
    xmlhttp.open("GET", searchAPIUrl +"?search="+ search_term, true);
    xmlhttp.send();
}

function processSearchResults(search_results) {
    var returnedItems = JSON.parse(search_results);
    clearDropdown();
    var shortUrls = $('#shortUrls');

    for (var key in returnedItems) {
        if (returnedItems.hasOwnProperty(key)) {
            var returnedItem = returnedItems[key];
            var shortUrl = location.protocol + "//" + location.host + "/" + returnedItem.url_short;
            var shortUrlLink = $("<p><a href=\""+shortUrl+"\">"+returnedItem.url_short+"</a></p>");
            shortUrls.append(shortUrlLink);
        }
    }
}

function clearDropdown () {
    $('#shortUrls').empty(); // remove all the existing options to avoid duplicates
}
