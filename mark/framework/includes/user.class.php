<?php

	class user{
		
		var $userdata;
		var $loggedin;
		var $permisions;
		
		
		//user initialiseren : rechtenset instellen enz. 
		function user(){
			global $sql;
		
			$query=$sql->query("select * from users where gebruikersnaam='".$_COOKIE['naam']."' and wachtwoord='".$_COOKIE['wachtwoord']."' and hash='".$_COOKIE['hash']."'");
			if($sql->aantal($query)){
				$this->userdata=$sql->fetch($query);
				$this->loggedin=true;
				$this->permisions=$userdata['permisions'];
			}else{
				$this->userdata="";
				$this->loggedin=false;
				$this->permisions;
			}
		}
		
		
		
		//inloggen
		function login($naam,$wachtwoord){
			global $sql;
			$query=$sql->query("select * from users where gebruikersnaam='".$naam."' and wachtwoord='".md5($wachtwoord)."'");
			if($sql->aantal($query)){
				
				$hash=md5(time().$wachtwoord.$gebruikersnaam);
				$sql->query("update users set hash='".$hash."' where gebruikersnaam='".$naam."' and wachtwoord='".md5($wachtwoord)."'");
				cookie("hash",$hash);
				cookie("naam",$naam);
				cookie("wachtwoord",md5($wachtwoord));
				return true;
			}else{
				return false;
			}
		
		}
		
		//check of de user is ingelogd
		function loggedin(){
			return $this->loggedin;
		}
		
		
		//check of een user iets mag.
		function mag($min,$id=-1){
			if($this->permisions>=$min or $id==$this->userdata['userId']){
				return true;
			}else{
				return false;
			}
		}
		
		
		
		
	}
	
	$user=new user();

?>
