function showAdminMenu()
{
	var status = $(".admintools li ul").hasClass("active");

	if(status == true)
	{
		$(".admintools li ul").removeClass("active");
	}
	else
	{
		$(".admintools li ul").addClass("active");
	}
}
