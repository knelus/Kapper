<?php
	
	//javascript regels di ebij het inladen moeten worden gedaan.
	function onload($string){
		global $output;
		out($string."\n","onload");
	}
	
	//output inbrengen
	function out($text,$plaats='text'){
		global $output;
		$output->add($text,$plaats);
	}

	
	//email versturens
	function email($adres,$subject,$file,$data='',$spoed=true){
		global $error;
		global $config;
		global $sql;
		
		$inhoud=new layout("emails/".$file);
		if(is_array($data)){
			$inhoud->assign($data);
		}
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers.="From:".$config['email']["from"]."\r\n";
		$headers.="BCC:".$config['email']["report"]."\r\n";
		$headers.="BCC:".$config['email']["report"]."\r\n";
		//if($spoed){
			@mail($adres,$subject,$inhoud->draw(),$headers) or $error->add("Het versturen van deze email is mislukt","mail",$adres);
		/*}else{
			$sql->query("INSERT INTO `klanten`.`email` (
				`id` ,
				`tekst` ,
				`titel` ,
				`to` ,
				`headers` 
				)
				VALUES (
				NULL , '".$inhoud->draw()."', '".$subject."', '".$adres."', '".$headers."'
				);
				");
		}*/
				
	}
	
	//cookie maken
	function cookie($naam,$inhoud,$tijd=0){
		global $config;
		setcookie($naam,$inhoud,$tijd,"/");
	}
	
	//ga naar
	/*
	function goto($url){
		header("location: ". $url);
	}
	*/
	
	function datum($stamp,$mode="full"){
		if($mode=="time"){
			return date("H:i:s",$stamp);
		}
		elseif($mode=="date"){
			return date("d-m-Y",$stamp);
		}
		else{
			return date("d-m-Y H:i:s",$stamp);
		}
	}
	
	function write_backup($tabel,$id){
		global $sql;
		$show=$sql->result("select * from ".$tabel." where id=".$id);
		$aant=count($show);
		$i=1;
		$keys="(";
		$vals="(";
		foreach($show as $key=>$val){
			if($key=="id"){
				$keys.="id_oud";
				$vals.=$val;
			}else{
				$keys.=$key;
				$vals.="'".$val."'";
			}
			if($i<$aant){
				$keys.=",";
				$vals.=",";
			}
			$i++;
		}
		$keys.=")";
		$vals.=")";
		
		$sql->query("insert into ".$tabel."_oud ".$keys." values ".$vals);
		
	}
	
	//klant specefiek script maken
	function ks(){
		global $config;
		$config['ks']=true;
	}
	
	function no_layout(){
		global $config;
		$config['parse_layout']=false;
	}
	
	


?>
