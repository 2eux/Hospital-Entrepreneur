// Functions related to edit
function editNewsPage()
{
	$(".admintools li ul").removeClass("active");

	$("h1#title").hide();
	$("h2#sub_title").hide();
	$("div#article").hide();
	$("ul.authors").hide();

	$("h1.title_update").show();
	$("div.form_update").fadeIn();

}

var timeout;

function showAdminProgress()
{
	scroll(0,0);
	$(".ajaxloading").fadeIn();
	$(".admintools li.top").addClass("removeBorder");
	timeout = setTimeout("showAdminError()", 30000);

}

function showAdminError()
{
	$(".ajaxloading").hide();
	$(".ajaxfailure span").text("Timeout. Please try again...");
	$(".ajaxfailure").fadeIn();
}
function showAdminSuccess()
{
		clearTimeout(timeout);
		$(".ajaxloading").hide();

		$(".ajaxsuccess").fadeIn();
		$("div#article").html( $("textarea#textarea_information").val() );
		$("div#sub_article").html( $("textarea#content_short").val() );
		$("div#title").html( $("input#title") );
		$("ul#authors li#author").html( "Author: <a href=\"/index.php/user/profile/"+ $("input#author_id").val() + "\">"+ $("input#author").val() + "</a>" );

		$("div.form_update").hide();
		$("div.title_update").hide();

		$("div#information").show();
		
		$("h1#title").show();

		$("div#article_view").fadeIn();
}

function newsAdd_showAdminSuccess()
{
	showAdminSuccess();

	// Get last news ID
	var newsID = $.ajax({
  url: "/index.php/skipauth/getLastNewsID",
  async: false
 }).responseText;

	$("h2#sub_title").html( $("textarea#content_short").val() );
	$("h1#title").html ( $("input#title").val() );

	$("ul.authors li#author").html("Author: <a>"+ $("input#author").val() + "</a>" );

	$(".ajaxsuccess").html('<img src="/template/images/icons/accept.png" />Success! <a href="/index.php/news/read/' + newsID + '">Click here to read the Article</a>');
}
function fadeOutAll()
{
	$(".ajaxloading").fadeOut();
	$(".ajaxsuccess").fadeOut();
	$(".ajaxfailure").fadeOut();

	$(".admintools li.top").removeClass("removeBorder");
}

function formUpdateAndSubmit()
{

		var textarea = $("textarea#textarea_information").html();

		$("textarea#textarea_information").val(textarea);

		$("#newsForm").submit();

		setTimeout( "fadeOutAll()", 50000 );

}
/*
* Experimenting with AJAX Error. Further development of this is required!
*/
function deleteNewsArticle(id)
{
	
	$.ajax({
				type: "GET",
				url:	"/index.php/news/delete/"+id+"/true",
				success: function(html) {
					$("#article_"+id).css("background-color","#fafaf0");
					$("#article_"+id).slideUp();
					$(".ajaxloading").hide();
					$(".ajaxsuccess").html("News Article with ID:"+id+" have been deleted");
					$(".ajaxsuccess").fadeIn();
				},
				beforeSend: function() {
					$(".ajaxloading").show();
				},
				error: function(xml, text, error) {
					$(".ajaxloading").hide();
					$(".ajaxfailure").html( capitaliseFirstLetter(text) + ": " + xml.status + " " + xml.statusText);
					$(".ajaxfailure").fadeIn();
				}
		});
}
function capitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// wait for the DOM to be loaded 
$(document).ready(function() { 
	// bind 'myForm' and provide a simple callback function 

	var options = {
		beforeSubmit	: showAdminProgress,
		success			: showAdminSuccess
	}


    $('#infoForm').ajaxForm(options); 

	var options = {
		beforeSubmit	: showAdminProgress,
		success			: newsAdd_showAdminSuccess
	}

	$('#newsForm').ajaxForm(options);



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
