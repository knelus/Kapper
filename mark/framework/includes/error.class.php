<?

class error{
	
	var $error;
	var $counter;
	
	

	function add($text,$type='warning',$advanced=''){
		$error['text']=strip_tags($text);
		$error['type']=strip_tags($type);
		$error['advanced']=strip_tags($advanced);
		if($type=='fatal'){
			die($text);
		}
		if($type=='hack'){
			die($text);
		}
		$this->error[]=$error;
		$this->counter[$type]++;
		$this->counter['total']++;
	}

	function aantal($type='total'){
			return $this->counter[$type];
	}
		
	
	function clear(){
		$this->counter=NULL;
		$this->error=NULL;
	}
	
			
	function output(){
		if(is_array($this->error)){
			foreach($this->error as $key=>$val){
				if(!empty($val['advanced'])){
					$advanced=' (<span class="error_advanced" title="'.$val['advanced'].'">Geavanceerd</span>)';
				}else{
					$advanced=NULL;
				}
				$output.='<font size="1">'.$val['text'].''.$advanced.' </font><br>';
			}	
			$output=venster("Er zijn fouten opgetreden",$output,"100%","both");
		}
		
		return($output);
	}
	

}

$error=new error();

?>