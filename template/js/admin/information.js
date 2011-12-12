function editInfoPage()
{
	$(".admintools li ul").removeClass("active");

	var title = $("h1#title").html();
	var content = $("div#information").html();

	$("h1#title").hide();
	$("div#information").hide();

	$("#title_information").html("Editing " +title);
	$("#textarea_information").val(content);

	$("h1.title_update").show();
	$("div.form_update").fadeIn();

}

var timeout;

function showAdminProgress()
{
	scroll(0,0);
	$(".adminloading").fadeIn();
	$(".admintools li.top").addClass("removeBorder");
	timeout = setTimeout("showAdminError()", 90000);

}

function showAdminError()
{
	$(".adminloading").hide();
	$(".adminfailure span").text("Timeout. Please try again...");
	$(".adminfailure").fadeIn();
}
function showAdminSuccess()
{
		clearTimeout(timeout);
		$(".adminloading").hide();

		$(".adminsuccess").fadeIn();
		$("div#information").html( $("#infoForm textarea").val() );

		$("div.form_update").hide();
		$("div.title_update").hide();

		$("div#information").show();
		$("h1#title").show();
}

function fadeOutAll()
{
	$(".adminloading").fadeOut();
	$(".adminsuccess").fadeOut();
	$(".adminfailure").fadeOut();

	$(".admintools li.top").removeClass("removeBorder");
}

function formUpdateAndSubmit()
{

		var textarea = $("textarea#textarea_information").html();

		$("textarea").val(textarea);

		$("#infoForm").submit();

		setTimeout( "fadeOutAll()", 50000 );

}

// wait for the DOM to be loaded 
$(document).ready(function() { 
	// bind 'myForm' and provide a simple callback function 

	var options = {
		beforeSubmit	: showAdminProgress,
		success			: showAdminSuccess
	}


    $('#infoForm').ajaxForm(options); 



		$('textarea#textarea_information').tinymce({
			// Location of TinyMCE script
			script_url : '/template/js/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

			// Theme options
			theme_advanced_buttons1 : "save,|,bold,italic,underline,strikethrough,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			save_enablewhendirty : false,
			save_onsavecallback : formUpdateAndSubmit,


			// Example content CSS (should be your site CSS)
			content_css : "/template/css/formating.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

		});


}); 
