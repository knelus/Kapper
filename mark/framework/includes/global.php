<?php ob_start();
include("config.php");



//includes
include("includes/error.class.php");
include("includes/sql.class.php");
include("includes/output.class.php");
include("includes/layout.class.php");
include("includes/wissel.class.php");
include("includes/functions.php");
include("includes/components.php");
include("includes/zoeken.class.php");
include("includes/urlReader.class.php");
include("includes/db.class.php");
include("includes/controller.class.php");
include("includes/mysql_fix.php");
include("includes/lang.class.php");
include("includes/user.class.php");
include("includes/pageNumbering.class.php");
include("includes/images.class.php");
include("includes/moduleLoader.class.php");
include("spaw2/spaw.inc.php");

//het menu
include("includes/menu.inc.php");

//sassigns:
layout::sAssign("path",$config['path']['http']);



//headers
header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$userId=$user->userdata['usersId'];





?>
