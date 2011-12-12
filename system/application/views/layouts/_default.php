<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Hospital Entrepreneur - <?=$title?></title>
	<link rel="stylesheet" type="text/css" href="{baseurl}/template/css/main.css">
	<link rel="stylesheet" type="text/css" href="{baseurl}/template/css/jquery-ui-1.7.2.custom.css">
	
	<script type="text/javascript" language="javascript" src="{baseurl}template/js/jquery-1.3.2.min.js"></script>
	<?php if(isset($jQuery) && count($jQuery) > 0) foreach($jQuery as $j) { echo $j . "\n"; } ?>
	<script type="text/javascript" language="javascript" src="{baseurl}template/js/jquery-ui-1.7.2.custom.min.js"></script>
  </head>
  <body>
        <div class="wrapper">
            <p>{yield}</p>
             <div class="push"></div>
         </div>
         <div class="footer">
             <p><ul class="menu">
<li class="text"><span>Logged in as: <strong><?php $CI =& get_instance(); echo $CI->authlib->getUserName(); ?></strong> (<a href="/index.php/auth/logout">Logout</a>)</span></li>
<li class="text seperator border-left"></li>
<li class="text information_link money">

<span class="tipsyTooltip" title="Money remaining:">
<a href="#">
<img src="/template/images/icons/money.png" border="0" alt="Money"/></a> <span class="ajaxMoneyCall moneyText">LOADING</span>
</span>

<span  class="tipsyTooltip" title="Hospital building area remaining:">
<a href="/index.php/hospital">
<img src="/template/images/icons/building.png" border="0" alt="Hospital area left" /></a> <span class="ajaxAreaCall moneyText">LOADING</span>m&#178;
</span>

<span  class="tipsyTooltip" title="Patients cured:">
<a href="#">
<img src="/template/images/icons/user_suit.png" title="Patients cured" id="tipsy_peopl" border="0" alt="Patients cured" /></a> <span class="ajaxPatientsCall moneyText">LOADING</span>
</span>

<span  class="tipsyTooltip" title="Pills:">
<a href="#">
<img src="/template/images/icons/pill.png" title="Patients cured" id="tipsy_peopl" border="0" alt="Patients cured" /></a> <span class="ajaxPillsCall moneyText">10</span>
</span>

</li>
<li class="text seperator border-right"></li>
<li class="link"><a href="/index.php/">Overview</a></li>
<li class="link border-left"><a href="/index.php/building">Manage rooms</a></li>
<li class="link border-left"><a href="/index.php/highscore/acheivements/<?php echo $CI->authlib->getUserId(); ?>">Acheivements</a></li>
<li class="link border-left border-right"><a href="/index.php/units">Employee manager</a></li>
<!--
**
** We have to find a other way to display highscores
**

<li class="link border-right"><a href="/index.php/highscore">Hi-score</a></li>
-->
<!--
**
** Research is added later on. For now deal wit the basics
**

 <li class="link border-left"><a href="/index.php/research">Research manager</a></li>

 -->
<!--
**
** Markets is also disabed for now
**
<li class="link border-left border-right"><a href="#">Market</a></li>
-->
<li class="link border-right"><a href="/index.php/stocks">Stocks</a></li>
<li class="right loading" style="display: none;">Loading...</li>

</ul></p>
         </div>
<div id="mailbox_cache" style="display: none;">  

</div>
</body>
</html> 
