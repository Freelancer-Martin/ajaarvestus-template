jQuery(document).ready(function($) {
$('#tabs').tabs();

//hover states on the static widgets
$('#dialog_link, ul#icons li').hover(
function() { $(this).addClass('ui-state-hover'); },
function() { $(this).removeClass('ui-state-hover'); }
);


var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1;

var yyyy = today.getFullYear();
today = mm+'/'+dd+'/'+yyyy;

$('#theDate').html( today );



});
