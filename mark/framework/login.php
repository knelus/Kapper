<?php
	
	//global includen
	//include("includes/global.php");
	
	
	if(!$user->loggedin()){
		//variabelen zetten
		$showForm=true;
		
		//taal inladen
		$lang=new lang("back");
		$lang->load("login");
		
		
		if(!empty($_POST['submit'])){
			if($user->login($_POST['naam'],$_POST['wachtwoord'])){
				$url->go("index");
			}
		}

		$form=new layout("forms/login");
		$form->assign($lang->getAll(),"lang_");
		$form->assign("naam",$_POST['naam']);
		echo $form->draw();
	}else{
		$url->go("index");
	}
?>
