/**
 * Created by tomi on 14/06/15.
 */

var get_short_url_action = document.getElementById("shorten-action");

get_short_url_action.addEventListener("click", function(){
    get_short_url();
});

function display_ui () {
    var response_container = document.getElementById('response-wrapper');
    var ui_container = document.getElementById('ui-wrapper');
    ui_container.className = '';
    response_container.className = 'hidden';
}

function display_response () {
    var response_container = document.getElementById('response-wrapper');
    var ui_container = document.getElementById('ui-wrapper');
    ui_container.className = 'hidden';
    response_container.className = '';
}