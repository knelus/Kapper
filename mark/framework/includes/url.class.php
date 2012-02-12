<?php
	
	class url{
		
		var $urlString;
		var $urlArray;
		var $startPos;
		
		function url(){
			$this->urlString=$_GET["path"];
			$this->urlArray=explode("/",$this->urlString);
		}
		
		
		function fStartPos(){
			$this->startPos++;
		}
		
		funciton bStartPos(){
			$this->startPos--;
		}
		
		
		function get($deel){
			$deel+=$this->startPos;
			if(isset($this->urlArray[$deel])){
				return $this->urlArray[$deel];
			}else{
				return false;
			}
		}
		
		
		
	}
	
	

?>
