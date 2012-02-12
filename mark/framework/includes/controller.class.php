<?php

	class controller{
		
		var $info;
		var $error;
		var $url;
		var $output;
		var $sql;
		var $db;
		var $lang;
		var $user;
				
		function controller(){
			global $url,$error,$sql,$output,$lang,$user;
			$this->error=$error;
			$this->url=$url;
			$this->sql=$sql;
			$this->lang=$lang;
			$this->db=new db();
			$this->output=$output;
			$this->user=$user;
		}

		function __start(){
			

			
			$method=$this->url->get(1);
			if(!$method){
					$method="index";
			}
			

			
			$this->lang->load($this->info['module']);
			if(method_exists($this,$method)){
				$all=$this->url->getAll();
				if(is_array($all)){
					foreach($all as $key=>$val){
						if($key>1){
							if($key>2){
								$parameters.=",";
							}
							$parameters.="'".$val."'";
						}
					}
				}
				$this->__init();
				eval('$this->$method('.$parameters.');');
				$this->__destroy();
			}else{
				if(method_exists($this,"unknown")){
					$this->__init();
					$this->unknown();
					$this->__destroy();
				}else{
					$this->error->add("Pagina niet gevonden","pagina");
				}
			}

			if( file_exists("style/".$this->info['mode']."/".$this->info['module'].".css") ){
				style($this->info['mode']."/".$this->info['module']);
			}
			
			if( file_exists("javascript/".$this->info['mode']."/".$this->info['module'].".js") ){
				javascript($this->info['mode']."/".$this->info['module']);
			}
			

			
		}		
		
		function __init(){}
		function __destroy(){}
		function __setInfo($info,$mode){
			$this->info=$info;
			$this->info["mode"]=$mode;
		}
	
			
		function out($text,$plaats="text"){
			$this->output->add($text,$plaats);
		}
	}
	
?>
