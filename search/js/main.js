/**
 * Created by tomi on 11/10/15.
 */

var tag_input = document.getElementById("url_input");
tag_input.onkeyup = function(){
    //document.getElementById('foo').innerHTML = inputBox.value;
    console.log(tag_input.value);
    var search_results = sendSearchQuery(tag_input.value, processSearchResults);
 };


function sendSearchQuery (search_term, callback) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //console.log(xmlhttp.responseText);
            callback(xmlhttp.responseText);
        }
    };
    xmlhttp.open("GET", "http://url_search.local.dev/url-shortener/api/?search="+ search_term, true);
    xmlhttp.send();
}

function processSearchResults(search_results) {
  //console.log(search_results);
  var returnedItems = JSON.parse(search_results);
  //console.log(returnedItems);

  for (var key in returnedItems) {
    if (returnedItems.hasOwnProperty(key)) {
        var returnedItem = returnedItems[key];
        console.log(returnedItem);
    }
  }
}
