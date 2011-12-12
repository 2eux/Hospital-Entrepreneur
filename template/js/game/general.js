jQuery.fn.exists = function(){return jQuery(this).length>0;}

if( window.console && window.console.firebug ) {
   $(".wrapper").append("<div onclick=\"this.style.display = 'none'\" style='position:absolute; top:0; width:100%; padding: 5px 0; background: #ff7; border-bottom: 1px solid #770; font-weight: bold; text-align: center;'>Firebug can make this web page slow, we suggest you disable it for this web page. Click to close this warning.</div>");
}

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function accordion(id)
{
	var element = $("."+id+"_");
	var image = $("."+id+"_img");
	
	if(element.css("display") == "block")
	{
		element.hide();
		image.attr("src", "/template/images/icons/delete.png");
		element.parent().css("padding-bottom","0");
	}
	else
	{
		element.show();
		image.attr("src", "/template/images/icons/add.png");
		element.parent().css("padding-bottom", "10px");
	}
}


function area_change(id)
{
	var lenght = $("#L_" + id).val();
	var width  = $("#W_" + id).val();
	var price  = $("#price_"+id).text();
	var hospitalID = $("#hospitalID").text();
	var multiplier;
	switch(hospitalID)
	{
		case "1":
			multiplier = 1;
		break;
		case "2":
			multiplier = 4;
		break;
		case "3":
			multiplier = 16;
		break;
		case "4":
			multiplier = 40;
		break;
		case "5":
			multiplier = 90;
		break;
		default: 
			multiplier = 1;
		break;
	}

	var area = lenght * width;
	var tpri = area * price * multiplier;

	tpri = addCommas(tpri);

	$("#TP_"+ id).html(tpri);
	$("#T_" + id).html(area);
}

var en = 0;
$(document).ready(function () 
{


	//accordion("password"); accordion("timezone"); accordion("admin"); accordion("logo");
	accordion("admin");


	$("#ExpireyDate").datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true });

	$("ul.menu_bottom li.nav").click(function () { $("ul.menu_bottom li.sub").toggle(); });

	// Load money & hotel area
	//timerLoadXMLData();
	// Set a timer to do it automaticly.

	timerLoadOnlineUsers();

	setInterval( "timerLoadOnlineUsers()", 10000);
	setInterval( "timerLoadXMLData()", 500000);

	// Hide the loading by default
	$(".loading").hide();


	// Menu styles w/Tipsy
	$('.tipsyTooltip').tipsy({gravity: 'w', fade: 'true'});
	$('.tipsyMessage').tipsy({gravity: 'e'});

	$(".tipsyNorth").tipsy({gravity: 's', fade: 'true'});
	$(".tipsySouth").tipsy({gravity: 'n', fade: 'true'});


	$("#event").toggle(function () {
		$(this).addClass("active");
		$(".eventList").show();
	}, function () {
		$(this).removeClass("active");
		$(".eventList").hide();
	});




	$(function(){
		$.extend($.fn.disableTextSelect = function() {
			return this.each(function(){
				if($.browser.mozilla){//Firefox
					$(this).css('MozUserSelect','none');
				}else if($.browser.msie){//IE
					$(this).bind('selectstart',function(){return false;});
				}else{//Opera, etc.
					$(this).mousedown(function(){return false;});
				}
			});
		});
		$('.eventList').disableTextSelect();//No text selection on elements with a class of 'noSelect'
	});

});

function eventLink(id)
{
	window.location = "http://www.hospital-entrepreneur.com/index.php/event/interact/"+id;
}

$().ajaxStart(function(){
  				$(".loading").fadeIn(); 
 });
// unblock when ajax activity stops 
$().ajaxStop(function() { $(".loading").fadeOut(); }); 


	var mailMax = 9;
	var mailNow = 0;

function FormatNumberBy3(num, decpoint, sep) {
  // check for missing parameters and use defaults if so
  if (arguments.length == 2) {
    sep = ",";
  }
  if (arguments.length == 1) {
    sep = ",";
    decpoint = ".";
  }
  // need a string for operations
  num = num.toString();
  // separate the whole number and the fraction if possible
  a = num.split(decpoint);
  x = a[0]; // decimal
  y = a[1]; // fraction
  z = "";


  if (typeof(x) != "undefined") {
    // reverse the digits. regexp works from left to right.
    for (i=x.length-1;i>=0;i--)
      z += x.charAt(i);
    // add seperators. but undo the trailing one, if there
    z = z.replace(/(\d{3})/g, "$1" + sep);
    if (z.slice(-sep.length) == sep)
      z = z.slice(0, -sep.length);
    x = "";
    // reverse again to get back the number
    for (i=z.length-1;i>=0;i--)
      x += z.charAt(i);
    // add the fraction back in, if it was there
    if (typeof(y) != "undefined" && y.length > 0)
      x += decpoint + y;
  }
  return x;
}

var executedNum = 0;

function timerLoadOnlineUsers()
{
	var playSound;


	$.ajax({
		type: "GET",
		url: "/index.php/overview/users_xml",
		dataType: "xml",
		success: function(xml) {
			var userOnline = $(xml).find("userOnline").text();

			$("ul.menu_bottom li.sub ul.user").html('<li style="color: #666666" id="noUser">No users online....</li>');
			if(userOnline !== "0") { $("#noUser").hide(); } else { $("#noUser").show(); }
	
			$(".chatstatus").attr("src","/template/images/icons/status_offline.png");

			$(xml).find("user").each(function () { 
				var userID = $(this).find("id").text();
				var status = $(this).find("status").text();
				var userName = $(this).find("name").text();

				$("#status_"+userName).attr("src","/template/images/icons/status_online.png");

				//alert(userName);

				//if($("#chatbox_user_online_"+userID).exists() == false)
				//{
					$("ul.menu_bottom li.sub ul.user").append("<li id=\"chatbox_user_online_"+userID+"\" onclick=\"javascript: chatWith('"+userName+"');\"><img src=\"/template/images/icons/status_"+status+".png\" /><a>"+userName+"</a></li>");
				//}

			});

			$(xml).find("userdata").each(function () {
				/**
				** Money Updating
				**/
				var currentMoney = $("#money").text();
				var newMoney = $(this).find("money").text();
				// Reformat
				currentMoney = currentMoney.replace(/\s+/g,"");
				currentMoney = currentMoney.replace(",00","");
				
				currentMoneyFloat = parseFloat(currentMoney);

				if( newMoney > currentMoneyFloat ) {

					$("li#money").colorBlend([{fromColor:'#ffffff', toColor:'#00ff00', param:'color', isFade:'true', fps:'40', cycles:'1'}]);
					var num = FormatNumberBy3( newMoney, ",", " ");
					$("li#money").text(num);
 
				} else if ( newMoney < currentMoneyFloat ) {

					$("li#money").colorBlend([{fromColor:'#ffffff', toColor:'#ff0000', param:'color', isFade:'true', fps:'40', cycles:'1'}]); 
					var num = FormatNumberBy3( newMoney, ",", " ");
					$("li#money").text(num);

				} 
				/**
				** Hospital Area Updating
				**/

				var currArea	= $("li#hospitalarea").text();
				var newArea		= $(this).find("hospitalArea").text();

				currArea 		= parseInt(currArea);
				newArea			= parseInt(newArea);

				if( newArea < currArea ) 
				{
					$("li#hospitalarea").colorBlend([{fromColor:'#ffffff', toColor:'#ff0000', param:'color', isFade:'true', fps:'40', cycles:'1'}]);
					$("li#hospitalarea").text( newArea );
				}

			});

			$(xml).find("event").each(function () {
			   	var name 	= 	$(this).find("name").text();
			   	var link 	= 	$(this).find("link").text();
			   	var id 		= 	$(this).find("id").text();
				var icon 	= 	$(this).find("icon").text();

			   	var exist = $("#growl_"+id);

			   	if($("#growl_"+id).exists() == false && executedNum > 0) {
			   	$.jGrowl("<span id='growl_"+id+"' onclick='javascript: eventLink('"+id+"');'>"+name+"</span>", 
			   			{ 
			   				header: "<div class='growlHeader'><img src='http://hospital-entrepreneur.com/template/images/icons/date.png' />" + "New Event!</div>", 
			   				sticky: true, 
			   				growlID: id,
			   				growlType: "eventLink",
			   				open: function () { 
	//		   					playSound = true;
	//$("#soun").volume(40);
	//$("#soun").load("http://www.hospital-entrepreneur.com/sound/res/event.mp3");
			   					} 
			   
						});

				$(".eventList .last").before("<li onclick='javascript: eventLink("+id+");'><img src='/template/images/icons/"+icon+".png' /><span id='growl_"+id+"'><a href='"+link+"'>"+name+"</a></span></li>");
				} else if( $("#growl_"+id).exists() == false ) {
					$(".eventList .last").before("<li onclick='javascript: eventLink("+id+");'><img src='/template/images/icons/"+icon+".png' /><span id='growl_"+id+"'><a href='"+link+"'>"+name+"</a></span></li>");
				}

				$(".eventList .noNew").hide();

				$("#event").removeClass("noNew");
				$("#event").addClass("New");
			
			});

			executedNum++;	

			$("ul.menu_bottom").find("span").each(function (empty, domEle) { 
			   	$(domEle).text(userOnline);
			   	//alert(index + ': ' + $(this).text()); 
			   });
			}
	});
}


function timerLoadXMLData()
{
	$.ajax({
        type: "GET",
		url: "/index.php/overview/ajax_xml",
		dataType: "xml",
		success: function(xml) {
 			$(xml).find("info").each(function () {
				var money		= $(this).find("money").text();
				var patients	= $(this).find("patients").text();
				var hospital	= $(this).find("area_left").text();

				$(".ajaxMoneyCall").text(money);
				$(".ajaxPatientsCall").text(patients);
				$(".ajaxAreaCall").text(hospital);
			});
			$(xml).find("unread_mail").each(function () {
				
				mailNow++;

				var id = $(this).attr("id");
				var title = $(this).find("title").text();
				
				var mail_loaded = $("#mail_"+id).exists();
				var content = $(this).find("content").text();
				var time = $(this).find("time").text();
				var from = $(this).find("from").text();
	
				if(mailNow > mailMax && $("#mail_alert").exists() == false) { $(".loading").before("<li class='right border-left' id='mail_alert'>Warning: Maximum Mails reached. Please read your Email</li>");  return false; }

				if(mail_loaded == 0)
				{
					if($(this).find("priority").text() == "1")
					{
						loadPriority(id, title);
					}
					else
					{
						loadNotification(id, title);
					}

$("#mailbox_cache").append(""+
"<div id=\"mail_content_"+id+"\">\n"+
"	<b>From:</b> "+from+"<br />\n"+
"	<b>Time sent:</b> "+time+"<br /><hr >\n"+

""+nl2br(content)+"<br />\n"+
"</div>\n");

				}
			});
			
		}
	});
}

function nl2br(str) { return str.replace(/\n/g, '<br />'); }

function showMail(id, title)
{
	$("#mail_content_"+id).dialog({
		modal: true,
		width: 400,
		height: 500,
		title: "Mail: "+title,
		close: function () { $(this).dialog('destroy'); },
		buttons: {
			"OK" : function () { mail_closeMail(id); },
			"Cancel": function () { mail_cancelMail(id); }
		}


	});
}

function mail_closeMail(id)
{
		$.ajax({
			   type: "POST",
			   url: "/index.php/overview/ajax_post/mail",
			   data: { mail : id } ,
			   success: function() {
					$("#mail_"+id).hide(); 
					$("#mail_content_"+id).dialog('destroy');
					$("#mail_content_"+id).html(""); 
				}
	});
	mailNow = mailNow - 1;
}
function mail_cancelMail(id)
{
	$("#mail_content_"+id).dialog('destroy');
}

function loadNotification(id, title)
{
	$(".loading").before("<li class=\"right border-left\" id=\"mail_"+id+"\"><a href=\"javascript: void(0);\" onclick=\"javascript: showMail("+id+", '"+title+"');\">"+
						 "<img src=\"/template/images/icons/email.png\" border=\"0\" alt=\"Notification\" title=\""+title+"\" class=\"tipsyMessage\" /></a>"+
						 "</li>");
}
function loadPriority(id, title)
{
	$(".loading").before("<li class=\"right border-left\" id=\"mail_"+id+"\"><a href=\"javascript: void(0);\" onclick=\"javascript: showMail("+id+", '"+title+"');\">"+
						 "<img src=\"/template/images/icons/exclamation.png\" border=\"0\" alt=\"Notification\" title=\""+title+"\" class=\"tipsyMessage\" /></a>"+
						 "</li>");
}

function capitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function growlEvent()
{
$.jGrowl("Hello world!");
}

function dump(arr,level) {
var dumped_text = "";
if(!level) level = 0;

//The padding given at the beginning of the line.
var level_padding = "";
for(var j=0;j<level+1;j++) level_padding += "    ";

if(typeof(arr) == 'object') { //Array/Hashes/Objects
 for(var item in arr) {
  var value = arr[item];
 
  if(typeof(value) == 'object') { //If it is an array,
   dumped_text += level_padding + "'" + item + "' ...\n";
   dumped_text += dump(value,level+1);
  } else {
   dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
  }
 }
} else { //Stings/Chars/Numbers etc.
 dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
}
return dumped_text;
} 



function hideAll() {
	$(".ajaxfailure").fadeOut();
	$(".ajaxsuccess").fadeOut();
	$(".ajaxloading").fadeOut();
	$(".ajaxmove").slideUp();
}
