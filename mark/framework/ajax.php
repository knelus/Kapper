<?php

	 include("includes/global.php");
	 
	
	//bepalen met welk script op dit moment word gewerkt
	if(!empty($_GET['page'])){
		$page=$_GET['page'];
	}else{
		$page="home";
	}
	
	//juiste script inladen.
	
	if(file_exists("ajax/".$page.".php")){
		if($user->loggedin()){
			include("ajax/".$page.".php");
		}else{
			echo"Niet ingelogd";
		}
	}else{
		$error->add("Script niet gevonden","Files","ajax/".$page.".php");
	}
	
	
	//boel op het scherm gooien
	echo $output->draw('text');
	 
?>
