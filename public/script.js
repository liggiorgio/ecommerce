/*jslint browser: true*/
/*global $, jQuery, alert*/

$(document).ready(function () {
    $(".navbutton").hover(function () {
        $(this).css({"background-color": "#ff7402", "transition":"background-color 0.25s ease"});
    }, function () {
        $(this).css({"background-color":""});
        });
});