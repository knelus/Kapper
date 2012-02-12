<?php

	//classje om van kleuren te wisselen.  zou bijv met fmod() kunnen, dat is alleen c.a. 50% slomer.
	class wissel{
		var $huid;
		var $aant;
		
		//wisselaar initialiseren
		function wissel($aant=2){
			$this->aant=$aant;
		}
		
		
		//wisselwaarde terug geven
		function out(){
			if($this->huid==$this->aant){
				$this->huid=1;
			}else{
				$this->huid++;
			}
			
			return $this->huid;
			
			
		}
	
	}

?>
