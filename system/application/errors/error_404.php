<html>
<head>
<title><?php echo $heading; ?></title>
<style type="text/css">

body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
}

#content  {
margin-left: auto;
margin-right: auto;
width: 800px;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

#content h1 {
    font-family: Georgia, Times, serif;
	font-weight: normal;
    font-size: 28pt;
    line-height: 24pt;
    letter-spacing: -3px;
    margin: 14px 0 14px 0;	
}

#content h2 {
font-weight:		normal;
font-size:			16px;
color:				#000;
margin: 			0 0 4px 0;
width: 750px;
background-color: #F5f5f5;
padding: 18px;
padding-left: 52px;
}
#content h2 img {
	position: absolute;
	margin-left: -36px;
	margin-top: -6px;
}
p {
 margin-left: 20px;
 font-size: 14px;
}

a {
	font-size: 14px;
	margin-left: 20px;
	text-decoration: none;
	color: #0099cc;
}
</style>
</head>
<body>

	<div id="content">
		<h1>Hospital Entrepreneur</h1>
		<h2><img src="/template/images/icons/cancel-32x32.png" /><?php echo $heading; ?></h2>
		<p><?php echo $message; ?></p>

		<a href="/index.php/front">Return to front page</a>
	</div>
</body>
</html>
