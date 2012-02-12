<?php
	
	//dit is een test
	 include("includes/global.php");
	
	/* invoegen als je pagina niet bereikbaar wil voor niet ingelogden
	if(!$user->loggedin()){
		include("login.php");
		die();
	}
	*/
	
	layout::sAssign("userMode",$user->mode);
	
	//taal inladen
	$lang=new lang("front");
	
	//pagina opvragen
	$pagina=$url->get(0);
	
	if(!$pagina){
		$pagina="index";
	}
	
	$moduleLoader=new ModuleLoader();
	$moduleLoader->load("website",$pagina);
	$paginaInfo=$moduleLoader->paginaInfo;

	//menu maken
	foreach($menuItem as $key=>$val){

			out(mlink($val,$key),"menu");

	}

	
	

	//als de layout geparsed moet worden
	if($config['parse_layout']){
		//basisjavascripts inladen
		javascript("basic");
		
		
		//mainlayout inladen
		$mainlayout=new layout("main");
		
		 //Alles in de layout assignen.
		 $mainlayout->assign("head",$output->draw("head"));
		 $mainlayout->assign("menu",$output->draw("menu"));
		 $mainlayout->assign("submenu",$output->draw("submenu"));
		 $mainlayout->assign("content",$output->draw("text"));
		 $mainlayout->assign("onload",$output->draw("onload"));
		 $mainlayout->assign("subtitel",$paginaInfo['subtitel']);
		 //output blaat
		 out($mainlayout->draw(),"main");
		 echo $output->draw("main");
	}else{
		echo $output->draw("text");
	}
	 
?>
