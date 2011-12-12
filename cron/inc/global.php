<?php

error_reporting(E_ALL & ~E_NOTICE);

$path = dirname(__FILE__) . "/../../";
define("BASEPATH", $path);

include($path."system/application/config/config.php");
include($path."system/application/config/database.php");

echo " [".date("H:i:s")."] SYSTEM Including the necessary files......COMPLETED\n";

if(mysql_connect( $db["default"]["hostname"] , $db["default"]["username"] , $db["default"]["password"] ))
	echo " [".date("H:i:s")."] DB: Connected to database\n";

if(mysql_select_db( $db["default"]["database"]))
	echo " [".date("H:i:s")."] DB: Logged into database\n";
