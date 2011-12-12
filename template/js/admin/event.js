function checkIfEventRandom(id) {

	var input = $("#event_"+id+" :selected").val();
	
	if(input == 'random')
	{
		$("div#random_"+id).fadeIn();
		$("div#normalArg_"+id).hide();
	}
	else
	{
		$("div#random_"+id).hide();
		$("div#normalArg_"+id).show();
	}

}

function eventAdminShowAction(id)
{
	$("#action_"+id).dialog({
							modal: true,
							title: 'Action for Event',
							width: 600,
							height: 400,
							close: function() { $(this).dialog('destroy'); },
							buttons: { 'Close' : function() { $(this).dialog('destroy'); } }
							});
}

function confirmDelete()
{
	if(confirm("Are you sure you want to delete this event?"))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function eventAdminReadMessage(id)
{
	$("#message_"+id).dialog({
							modal: true,
							title: 'Message for Event',
							width: 600,
							height: 400,
							close: function() { $(this).dialog('destroy'); },
							buttons: { 'Close' : function() { $(this).dialog('destroy'); } }
							});
}
function eventAdminSendEvent(id)
{
	$("#event_form_send").dialog({
							modal: true,
							title: 'Send Event to User',
							width: 400,
							height: 355,
							close: function() { $(this).dialog('destroy'); },
							buttons: { 
								'Close' : function() { $(this).dialog('destroy'); }, 
								'Send Event': function() {

									var eventTo  = $("input:#event_to").val();
									var eventUA  = $("input:#fromUA").val();
									var eventUID = $("input:#fromUID").val();
									var eventAll = $("#all:checked").val();

									$.ajax({
										url: "/index.php/event/admin_event_send",
										type: "POST",
										data: ({ id: id , sendto: eventTo , eventUA: eventUA, eventUID: eventUID, eventAll: eventAll }),
										success: function(msg) {
												var msg_sub = msg.substring(5,0);

												if(msg_sub == "ERROR") { 
													$("#event_form_send_error").fadeIn();
													$("#event_to").css("border","1px solid #FF0000");
													$("#event_to").css("background-color", "#FF9090");
													$("#event_to").focus();
												}
												else {
													$("#event_form_send").dialog("destroy"); 
													$(".ajaxmove").show();													
													$(".ajaxsuccess #message").text("Success! You've successfully sent the Event to "+eventTo);
													$(".ajaxsuccess").fadeIn();

													$("#event_to").css("border", "1px solid #000000");
													$("#event_to").css("background-color", "#FFFFFF");
													$("#event_to").val("");

												}
										}
									});
								 }
								}
							});
}

function disableEventTo()
{
	var checked = $("#all:checked").val();
	if(checked == "checked")
	{
		$("#event_to").attr("disabled", true);
	}
	else
	{
		$("#event_to").removeAttr("disabled");
	}
}

$(document).ready(function() {
	$(".random_event").hide();
	$("#event_to").autocomplete(
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
