function showAdminLog(id)
{
	$("#AdminLog_"+id).dialog({
							modal: true,
							title: 'Administration Log',
							width: 600,
							height: 400,
							close: function() { $(this).dialog('destroy'); },
							buttons: { 'Close' : function() { $(this).dialog('destroy'); } }
							});
}

function updateImage()
{

	var src = $("#imageSrc").attr("value");

	//alert(src);

	$("#image_ads").attr("src", src);
}
