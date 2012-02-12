<?

	class output{
		
		var $output;
		
			
		function clear($plaats=''){
			global $error;
			if($plaats){
				$this->output[$plaats]=NULL;
			}else{
				$this->output=NULL;
			}
			$error->clear();
		}
					
		function add($text,$plaats='text'){
			
			$this->output[$plaats].=$text;
			
		}
		
	
		function draw($plaats='text'){
			if($plaats=='text'){
				global $error;
				$out= $error->output();
			}
			$out.= $this->output[$plaats];
			return $out;
		}
		
		
		
	}
	
	$output=new output;
	


?>