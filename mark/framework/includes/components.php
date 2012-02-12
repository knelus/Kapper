<?php


	function spaw($name,$value=""){
		$spaw = new SpawEditor($name, $value);
		return $spaw->getHTML();  
	}
	//een button
	function  button($link,$tekst){
		$button = new layout("componenten/button");
		$button->assign("link",$link);
		$button->assign("tekst",$tekst);
		return $button->draw();
	}

	//een onklikbarebutton
	function  gButton($tekst){
		$button = new layout("componenten/gButton");
		$button->assign("tekst",$tekst);
		return $button->draw();
	}

    //alert maken
    function alert($bericht){
        $alert = new layout("componenten/alert");
        $alert->assign("bericht",$bericht);
        onload($alert->draw());
    }

    //iframe maken
	function iframe($url,$height="400",$width="700"){
		$iframe= new layout("componenten/iframe");
		$iframe->assign("url",$url);
		$iframe->assign("width",$width);
		$iframe->assign("height",$height);
		return $iframe->draw();	
	}

    //hveld maken
	function hfield($name="hfield",$value=""){
		$hfield=new layout("componenten/hfield");
		$hfield->assign("name",$name);
		$hfield->assign("value",$value);
		return $hfield->draw();
	}

    //radiobutton maken
	function radiobutton($name="radio",$value="",$tekst="",$clear="both"){
		$radiobutton=new layout("componenten/radiobutton");
		$radiobutton->assign("name",$name);
		$radiobutton->assign("value",$value);
		$radiobutton->assign("tekst",$tekst);
		$radiobutton->assign("clear",$clear);
		return $radiobutton->draw();
	}
	
	//submitbutton
	function  submit($name="submit",$tekst="verwerk"){
		$button = new layout("componenten/submit");
		$button->assign("name",$name);
		$button->assign("tekst",$tekst);
		return $button->draw();
	}
	
	//een form
	function form($inhoud,$width="100%"){
		$form = new layout("componenten/form");
		$form->assign("inhoud",$inhoud);
		$form->assign("width",$width);
		return $form->draw();
	}
	
	//een formline
	function formline($naam,$inhoud){
		$formline = new layout("componenten/formline");
		$formline->assign("naam",$naam);
		$formline->assign("inhoud",$inhoud);
		return $formline->draw();
	}
	
	function alink($tekst){
		$button=new layout("componenten/alink");
		$button->assign("tekst",$tekst);
		return $button->draw();
	}
	
	//een link
	function mlink($link,$tekst,$ext=""){
		$button = new layout("componenten/mlink");
		$button->assign("link",$link);
		$button->assign("tekst",$tekst);
		
		if(!empty($ext)){
			$ext=$ext;
		}elseif(!empty($_GET['ext'])){
			$ext=$_GET['ext'];
		}else{
			$ext="html";
		}
		
		$button->assign("ext",$ext);
		
		return $button->draw();
	}
	
	function bold($tekst){
		$bold = new layout("componenten/bold");
		$bold->assign("tekst",$tekst);
		return $bold->draw();
	}
	//options voor selectbox
	function optionbox($tekst,$value,$selected=false){
		$optionbox = new layout("componenten/optionbox");
		$optionbox->assign("value",$value);
		$optionbox->assign("tekst",$tekst);
		if($selected){
			$optionbox->assign("selected","selected");
		}else{
			$optionbox->assign("selected","");
		}
		return $optionbox->draw();
	}
	//selectbox zelf
	function selectbox($name,$inhoud,$onchange="",$disabled=false){
		$selectbox = new layout("componenten/selectbox");
		$selectbox->assign("name",$name);
		$selectbox->assign("inhoud",$inhoud);
		$selectbox->assign("onchange",$onchange);
		if($disabled){
			$selectbox->assign("disabled",'disabled="disabled"');
		}else{
			$selectbox->assign("disabled","");
		}
		return $selectbox->draw();
	}

	//een venster in beeld toveren
	function venster($titel,$inhoud,$width="100%",$clear="none",$float="left"){
		$layout=new layout("componenten/venster");
		$layout->assign("titel",$titel);
		$layout->assign("content",$inhoud);
		$layout->assign("width",$width);
		$layout->assign("clear",$clear);
		$layout->assign("float",$float);
		return $layout->draw();
	}
	

	//stylesheet inladen
	function style($file,$ks=false){
		global $output;
		global $config;
		$style = new layout("componenten/style");
		$style->assign("file",$file);


		out($style->draw(),"head");
	}
	
	//javascript inladen
    function javascript($file,$ks=false){
		global $output;
		global $config;
		$script = new layout("componenten/javascript");
		$script->assign("file",$file);
		
		
		out($script->draw(),"head");
	}
	
	function img($file){
		$img = new layout("componenten/img");
		$img->assign("file",$file);
		return $img->draw();
	}
	
	//tab in het midden zetten
	function tab($id,$link,$tekst,$selected=false){
		global $output;
		$layout = new layout("componenten/midmenubutton");
		$layout->assign("tekst",$tekst);
		$layout->assign("id",$id);
		$layout->assign("onclick","goto('".$link."');");
		if($selected){
			$layout->assign("selected","_selected");
			onload("midden_selected='".$id."';");
		}else{
			$layout->assign("selected","");
		}
		
		out($layout->draw(),"midden");
	}
	
	
	//ajax tab in het midden zetten
	function taba($id,$link,$tekst,$moet_reloaden=false,$selected=false){
		global $output;
		$layout = new layout("componenten/midmenubutton");
		$layout->assign("tekst",$tekst);
		$layout->assign("id",$id);
		if(substr($link,0,1)=="?"){
			$layout->assign("onclick","tabajax('ajax.php".$link."','".$id."','".$moet_reloaden."');");
		}else{
			$layout->assign("onclick","tabajax('".$link."','".$id."','".$moet_reloaden."');");
		}
		
		if($selected){
			if(substr($link,0,1)=="?"){
				onload("tabajax('ajax.php".$link."','".$id."');");
			}else{
			 	onload("tabajax('".$link."','".$id."');");
			}
			$layout->assign("selected","_selected");
		}else{
			$layout->assign("selected","");
		}
		
		out($layout->draw(),"midden");
	}
	
	//ajaxfield
	function  ajaxfield($id,$inhoud=""){
		$ajaxfield = new layout("componenten/ajaxfield");
		$ajaxfield->assign("id",$id);
		$ajaxfield->assign("inhoud",$inhoud);
		return $ajaxfield->draw();
	}
	
	
	//navbar
	function navbar($url,$items,$perpage=5,$lengte=21){
		
		if(empty($_GET['pp'])){
			$pp=1;
		}else{
			$pp=$_GET['pp'];
		}
		
		$aantal_pages=ceil($items/$perpage);
		$nu=$pp;
		$perkant=ceil(($lengte-1)/2);
		
		if($pp<=$perkant){
			$begin=1;
			$eind=$perkant*2+1;
		}else{
			$begin=$pp-$perkant;
			$eind=$pp+$perkant;
		}
		
		if($eind>$aantal_pages){
			$eind=$aantal_pages;
		}
		
		$i=$begin;
		while($i<=$eind){
			if($i==$pp){
				tab("pagina".$i,$url."&pp=".$i,$i,true);
			}else{
				tab("pagina".$i,$url."&pp=".$i,$i);
			}
			$i++;
		}
		
		
	}
?>
