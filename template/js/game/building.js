$(document).ready(function() {
	$(".manageRoom tbody tr").click( function ()
		{
			var x = $(this).css("background-color");

			if(x != "transparent")
			{
				var rgbString = "rgb(0, 70, 255)"; // get this in whatever way.
				
				var parts = rgbString
				        .match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/)
				;
				// parts now should be ["rgb(0, 70, 255", "0", "70", "255"]
				
				delete (parts[0]);
				for (var i = 1; i <= 3; ++i) {
				    parts[i] = parseInt(parts[i]).toString(16);
				    if (parts[i].length == 1) parts[i] = '0' + parts[i];
				}
				var hexString = parts.join(''); // "0070ff"
			}
		
			var styleHTML = "background-color: #FFFF88";
			var styleHTMLRGB = "background-color: rgb(255, 255, 136);";

			if(x == "transparent" && $(this).attr("style") !== styleHTMLRGB || hexString == "0046ff" && $(this).attr("style") !== styleHTMLRGB)
			{				

				$(this).attr("style", styleHTML );
				$(this).find("input[type=checkbox]").attr("checked","checked");
			}
			else
			{


				$(this).removeAttr("style");
				$(this).find("input[type=checkbox]").removeAttr("checked");
			}
		});


	$(".ajaxBuildForm").submit(function () {
			var submitButton = $(this).find("input:submit");		
			
			$(".ajaxmove").show();

			$(".ajaxsuccess").hide();
			$(".ajaxfailure").hide();

			submitButton.removeClass("inputSubmit");
			submitButton.addClass("inputButtonDisabled");			
			submitButton.attr("value", "Building....");

			var str = $(this).formSerialize();

			$.ajax({
						url: "/index.php/building/build_ajax",
						type: "POST",
						data: str,
						success: function(data) {
							var s = data.split(":");
							var id_part1 = str.split("_");
							var id_part2 = id_part1[1].split("=");
							
							var id = id_part2[0];


							switch(s[0])
							{
								case "SUCCESS":

									$(".ajaxsuccess span").html(data);

									timerLoadOnlineUsers();

									var num = $("#num_"+id).text();
									num = parseInt(num);

									$("#num_"+id).parent().colorBlend([{fromColor:'#3a3a3a', toColor:'#ffff88', param:'background-color', isFade:'true', fps:'20', cycles:'1'}]);
									$("#num_"+id).text( num + 1 );

									$(".ajaxsuccess").fadeIn();
								break;

								default:
									$(".ajaxfailure span").html(data);
									$(".ajaxfailure").fadeIn();
								break;
							}

							submitButton.removeClass("inputButtonDisabled");
							submitButton.addClass("inputSubmit");
							submitButton.attr("value", "Build");
							$(this).resetForm();
							
						}
					});

			return false;
		});
});