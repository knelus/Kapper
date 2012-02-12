<?php
	class image{
		var $config;
		var	$actions;

		function image($image=""){
			global $config;
			$this->config=$config['image'];
			$this->config['img']=$image;
		}
		function load($image){
			$this->config['img']=$image;
		}
		
		function action($action,$parameters="",$key=NULL){
			if(empty($key)){
				$this->actions[]="-".$action." ".$parameters;
			}else{
				$this->actions[$key]="-".$action." ".$parameters;
			}
		}
		
		function rmAction($action){
			unset($this->actions[$action]);
		}
		

		
		function save($file,$alwaysSave=true){
			$actionString= $this->config['IMpath']." ".$this->config['img']." ";
			foreach($this->actions as $val){
				$actionString.=$val." ";
			}
			$actionString .= $this->config['savedir'].$file;
			shell_exec($actionString);
			if(!file_exists($this->config['savedir'].$file) and $alwaysSave){
				copy($this->config['img'],$this->config['savedir'].$file);
			}
		}
		
	}
?>
