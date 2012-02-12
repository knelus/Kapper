<?php
	class postcode{
		var $wijkcode;
		var $plaatscode;
		var $letters;
		
		function postcode($postcode){
			$postcode=strtolower(str_replace(" ","",$postcode));
			$this->plaatscode=substr($postcode,0,2);
			$this->wijkcode=substr($postcode,2,2);
			$this->letters=substr($postcode,4,2);
		}
		
		function getCijfercode(){
			return $this->plaatscode.$this->wijkcode;
		}
		
		function getPlaatscode(){
			return $this->plaatscode;
		}
		
		function getWijkcode(){
			return $this->wijkcode;
		}
		
	}
?>