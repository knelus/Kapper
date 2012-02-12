<?php
	class urlReader{
		
		var $rule;
		var $vars;
		var $ext;
		var $startPos;
		
		//een url reader initialiseren
		function urlReader($rule=""){
			if($rule){
				$this->rule=$rule;
			}
			elseif(isset($_GET['rule'])){
				$this->rule=$_GET['rule'];
			}else{
				$this->rule="";
			}
			
			if(isset($_GET['ext'])){
				$this->ext=$_GET['ext'];
			}else{
				$this->ext="html";
			}
			
			$this->rule=$this->unchar($this->rule);
			
			$this->vars=explode("/",$this->rule);
			
		}
		
		function fStartPos(){
			$this->startPos++;
		}
		
		function bStartPos(){
			$this->startPos--;
		}
		
		//deel uit url ophalen
		function get($item){
			$item+=$this->startPos;
			if(isset($this->vars[$item])){
				return $this->vars[$item];
			}else{
				return "";
			}
		}
		function set($item,$value){
			$item+=$this->startPos;
			$this->vars[$item]=$value;
		}
		
		function getAll($ignorePos=false){
			if($ignorePos){
				$startpos=0;
			}else{
				$startpos=$this->startPos;
			}
			
			$varArray=null;
			foreach($this->vars as $key=>$val){
				if($key>=$startpos){
					$varArray[]=$val;
				}
			}
			
			return $varArray;
			
		}
		
	
		function chars($input){
			$input=str_replace("?","(vraagteken)",$input);
			return $input;
		}
		
		function unchar($input){
			$input=str_replace("(vraagteken)","?",$input);
			return $input;
		}
		
		
		//statische url dynamisch genereren.
		function make($page,$method="",$parameters="",$ext="",$ignorePos=false){
			global $config;
			if(!$page){
				$page=$this->get(0);
			}
			
			
			$method=$this->chars($method);
			$parameters=$this->chars($parameters);
			$page=$this->chars($page);
			

			if(!$ext){
				$ext=$this->ext;
			}
			
			$sitepath=$config['path']['http'];
			
			if(!$ignorePos){
				$i=0;
				while($i < $this->startPos){
					$prefix.=$this->vars[$i]."/";
					$i++;
				}
			}
			
			
			if($parameters){
				return $sitepath.$prefix.$page."/".$method."/".str_replace(",","/",$parameters).".".$ext;
			}elseif($method){
				return $sitepath.$prefix.$page."/".$method.".".$ext;
			}else{
				return $sitepath.$prefix.$page.".".$ext;
			}
			
			
		}
		
		
		
		//naar een url toe gaan
		function go($page,$method="",$parameters="",$ext=""){
			header("location:".$this->make($page,$method,$parameters,$ext));
		}
		
		function goUrl($url){
			header("location:".$url);
		}
		
		
	}
	$url=new urlReader();
?>
