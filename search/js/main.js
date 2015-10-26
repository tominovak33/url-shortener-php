/**
 * Created by tomi on 11/10/15.
 */

 $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});


var tag_input = document.getElementById("url_input");
tag_input.onkeyup = function(){
    //document.getElementById('foo').innerHTML = inputBox.value;
    console.log(tag_input.value);
    var search_results = sendSearchQuery(tag_input.value, processSearchResults);
 };

chosenSearch = document.getElementsByClassName('chosen-search');
console.log(chosenSearch);
chosenSearch = chosenSearch[0].firstChild;
console.log(chosenSearch);

chosenSearch.onkeyup = function(){
   //document.getElementById('foo').innerHTML = inputBox.value;
   //console.log(chosenSearch.value);
   var search_results = sendSearchQuery(chosenSearch.value, processSearchResults);
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
    //console.log(search_results);

    var returnedItems = JSON.parse(search_results);
    currentSearch = chosenSearch.value;
    clearDropdown();

    var newOption = $('<option value="1">test</option>');
    $('#url_dropdown').append(newOption);

    //var url_dropdown = document.getElementById('url_dropdown');
    //console.log(returnedItems);

    for (var key in returnedItems) {
        if (returnedItems.hasOwnProperty(key)) {
            var returnedItem = returnedItems[key];

            var newOption = $("<option value="+returnedItem.url_short+">"+returnedItem.url_short+"</option>");
            $('#url_dropdown').append(newOption);
            /*
            //console.log(returnedItem);
            var url_item = document.createElement('option');
            url_item.setAttribute('value', returnedItem.url_short);
            url_item.innerHTML = returnedItem.url_short;
            console.log(url_item);
            url_dropdown.appendChild(url_item);
            */
        }
    }


    $('#url_dropdown').trigger("chosen:updated");

    chosenSearch.value = currentSearch;
    //$(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
}

function clearDropdown () {
    //var url_dropdown = document.getElementById('url_dropdown');

    $('#url_dropdown').empty(); //remove all child nodes

    /*
    while (url_dropdown.firstChild) {
        url_dropdown.removeChild(url_dropdown.firstChild);
    }
    */
}
