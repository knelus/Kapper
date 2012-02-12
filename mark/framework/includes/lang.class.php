<?php
	class lang{
		
		var $language;
		var $defaultLang;
		var $langArray;
		var $mode;
		
		//taal initialiseren
		function lang($mode){
				global $config;
				$this->mode=$mode;
				$this->defaultLang=$config['lang']['default'];
				if(isset($_COOKIE['language'])){
					$this->language=$_COOKIE['language'];
				}else{
					$this->language=$this->defaultLang;
				}

				$this->load("global");
				
		}
		
		
		//taal ophalen (e.v.t. met prefix)
		function load($module,$prefix=""){
				if(file_exists("lang/".$this->defaultLang."/".$this->mode."/".$module.".php")){
					include("lang/".$this->defaultLang."/".$this->mode."/".$module.".php");				
				}
				
				if(file_exists("lang/".$this->language."/".$this->mode."/".$module.".php")){
					include("lang/".$this->language."/".$this->mode."/".$module.".php");				
				}
				

				if(is_array($langArray)){
					
					if($prefix){
						foreach($langArray as $key=>$val){
							$TlangArray[$prefix.$key]=$val;
						}
						$langArray=$TlangArray;
					}
				
					if(is_array($this->langArray)){
						$this->langArray=array_merge($langArray,$this->langArray);
					}else{
						$this->langArray=$langArray;
					}
				}
				
			layout::sAssign("lang",$this->getAll());
		}
		
		//item ophalen
		function get($item){
			return $this->langArray[$item];
		}
		
		//alle items ophalen
		function getAll(){
			return $this->langArray;
		}
		
		//een taalhandler maken met een item
		function getHandler($item,$newItem){
			return new langHandler($this->langArray[$item],$this,$item,$newItem);
		}
		
	}
	
	
	class langHandler{
		
		function langandler($opener,$item,$newItem){
			$this->opener=$opener;
			$this->item=$item;
			$this->newItem=$newItem;
			$this->opener->langArray[$newItem]=$this->opener->langArray[$item];
		}
		
		//variable assignen
		function assign($var,$string){
			$this->opener->langArray[$newItem]=str_replace("[".$var."]",$string,$this->opener->langArray[$newItem]);
		}
		
		//uiteindelijk toch de taal invoegen
		function draw(){
			return $this->langString;
		}
	}
	
	
?>
