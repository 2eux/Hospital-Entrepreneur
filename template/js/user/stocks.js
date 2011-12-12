var globalID;
var method;
var timer;

function purchaseStocks(id)
{
	$("#form_"+id).attr("action", "/index.php/stocks/ajax_buy_stocks/"+id);
	$("#form_"+id).submit();
	method = "buy";
}
function sellStocks(id)
{
	$("#form_"+id).attr("action", "/index.php/stocks/ajax_sell_stocks/"+id);
	$("#form_"+id).submit();
	method = "sell";
}


function showStockProgress(xml)
{
	//alert(dump(xml));

	var id = xml[2]['value'];

	globalID = id;

	var amount = $("#form_"+id+" input#amount").val();
	
}

function showStockSuccess(data)
{
	clearTimeout(timer);
	$(".ajaxmove").show();

	$(".ajaxsuccess").hide();
	$(".ajaxfailure").hide();

	var type = data.split(" ");
	
	if(type[0] == "Success!")
	{
		$(".ajaxsuccess span").html( data );

		$("#stocks_"+globalID).parent().parent().find("input#amount").val("");
		$("#stocks_"+globalID+"") .load("/index.php/stocks/getStocks/"+globalID, "", function() { 

			if(method == "sell")
			{
				$("#stocks_value_"+globalID).load("/index.php/stocks/getStockValue/"+globalID);
				var numStocks = parseInt( $("#stocks_"+globalID).text() );
			
				if(numStocks == 0) {
					$("#row_"+globalID).fadeOut();
				}
			}

		});

		$("#stocks_"+globalID).parent().parent().colorBlend([{fromColor:'parent', toColor:'#ffff88', param:'background-color', isFade:'true', fps:'100', cycles:'1'}]);

		timerLoadOnlineUsers();

		$(".ajaxsuccess").fadeIn();
	}
	else
	{
		$(".ajaxfailure span").html( data );
		$(".ajaxfailure").fadeIn();
	}

	timer = setTimeout("hideAll()", 10000);

}
function showStockError(xml, text, error)
{
	$(".ajaxmove").show();
	$(".ajaxfailure span").html( capitaliseFirstLetter(text) + ": " + xml.status + " " + xml.statusText);
	$(".ajaxfailure").fadeIn();
}

$(document).ready(function() { 
	// Hide Normal Form Buttons
	$(".button_purchase").hide();

	var options = {
		beforeSubmit	: showStockProgress,
		success			: showStockSuccess,
		error			: showStockError
	}
	$(".ajaxForm").ajaxForm(options);
});

