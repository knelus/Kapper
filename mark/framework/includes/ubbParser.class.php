<?php
	
	class ubbParser{
		
		var $tekst;
		
		function parse($actions,$tekst){
			
			$this->tekst=$tekst;
			
			$exp=explode(",",$actions);
			foreach($exp as $val){
				if($val=="br"){$this->br();}
				if($val=="html"){$this->html();}
			}
			
			return $this->tekst;
		}
		
		function br(){
			$this->tekst=nl2br($this->tekst);
		}
		
		function html(){
			$this->tekst=htmlspecialchars($this->tekst);
		}
		
	}

?>