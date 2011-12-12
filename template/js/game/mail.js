$(document).ready(function() {

	$("#mail_to").autocomplete(
		"/index.php/mail/ajaxUsername",
		{
			delay:10,
			minChars:2,
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			autoFill:true
		}
	);
});

function lookupAjax(){
	var oSuggest = $("#CityAjax")[0].autocompleter;

	oSuggest.findValue();

	return false;
}


