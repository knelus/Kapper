<?php
	class EbCheck{
		function voldoet($key,$operator,$val){
			if($operator=="startsWith"){
				return $this->startsWith($key,$val);			
			}elseif($operator=="="){
				return $key==$val;
			}elseif($operator==">"){
				return $key>$val;
			}elseif($operator=="<"){
				return $key<$val;
			}
			return false;
		}
		
		function startsWith($haystack, $needle) {    
			$length = strlen($needle);     
			return (substr($haystack, 0, $length) === $needle); 
		} 
		
	}
?>