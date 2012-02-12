<?php
//basic configuration
$config['sql']['host']="localhost";
$config['sql']['user']="root";
$config['sql']['pass']="secret01";
$config['sql']['name']="klanten";
$config['email']["from"]="call-in.agent@pricon.nl";
$config['email']["report"]="call-center.reports@pricon.nl";
if(!empty($_COOKIE['klant'])){
	$config['url']['klant_path']="per_klant/".$_COOKIE['klant']."";
	include($config['url']['klant_path']."/config.php");
}else{
	$config['url']['klant_path']=".";
}
$config['ks']=false; //als het een klant specefiek script is kan dit in het script worden ingesteld met ks();

//includes
include("includes/error.class.php");
include("includes/sql.class.php");
include("includes/output.class.php");
include("includes/layout.class.php");
include("includes/wissel.class.php");
include("includes/functions.php");
include("includes/components.php");
include("includes/user.class.php");
include("includes/zoeken.class.php");

//klant kiezen
if(!empty($_GET['klantnummer'])){
	cookie("klant",$_GET['klantnummer']);
	goto("index.php");
}


$klantinfo=$sql->query("select * from klanten where id=".$_COOKIE['klant']);

//taalarray
$janee[0]="nee";
$janee[1]="ja";


?>
