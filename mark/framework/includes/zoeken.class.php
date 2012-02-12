<?php

	class zoeken{
		
		var $data;
		var $query;
		var $aantal;
		var $zoekvelden;
		var $zoekvelden_alias;
		var $hoogste;
		var $score;
		var $zoekstring;
		var $pointer;
		var $cursor;
		
		
		
		//zoekopdracht
		function zoek($query,$zoekwoorden,$zoekvelden,$zoekvelden_alias="",$limit=5){
			
			$this->cursor=1;
			$this->limit=$limit;

			//fix voor paginanummeringloosheid
			if(!$_GET['pp']){
				$_GET['pp']=1;
			}
			
			
			//aliasses bepalen
			foreach($zoekvelden as $key=>$val){
				if(empty($zoekvelden_alias[$key])){
					$exp=explode(".",$key);
					$zoekvelden_alias[$key]=$exp[count($exp)-1];
				}
			}
			
			$this->zoekvelden_alias=$zoekvelden_alias;
			//informatie in array zetten
			$this->query=$query;
			$this->zoekvelden=$zoekvelden;
			$this->zoekwoorden=explode(" ",$zoekwoorden);
			
			//als er geen zoekwoorden zijn ingevuld, de array toch voorzien van een key zodat zoeken wel goed gaat			
			$this->get_data();
			
			
			//puntensysteem in werking zetten en sorteren
			if($this->zoekwoorden[0]==''){
				$this->rate_dummy();
			}else{
				$this->rate();
			}
			
			
		} 
		
		//data opzoeken
		function get_data(){
			global $sql;
			

			//array ophalen
			$zoekwoorden=$this->zoekwoorden;
			$zoekvelden=$this->zoekvelden;
		
			//where samenstellen
			$i=1;
			$where="(";
			foreach($zoekwoorden as $k=>$woord){
				foreach($zoekvelden as $veld=>$waarde){
					
					//als nodig een or praten
					if($i>1){
						$where.=" or ";
					}
					
					//plaats zoekterm
					$where.="".$veld." like '%".$woord."%'";
					
					
					$i++;
				}
			}
			$where.=")";
			
			//data ophalen
			if($zoekwoorden[0]!=''){
				$query_str=str_replace("[where]",$where,$this->query);
			}else{
				$query_str=str_replace("[where]",$where,$this->query." limit ".($this->limit*($_GET['pp']-1).",".$this->limit));
			}

			
			

			$query=$sql->query($query_str);
			$i=1;
			while($show=$sql->fetch($query)){
				foreach($show as $key=>$val){
					$this->data[$i][$key]=$val;
				}
				$this->aantal=$i;
				$i++;
			}			
		}
		
		
	//raten van alles
	function rate(){
		
	
		//aaliasses ophalen
		$alias= $this->zoekvelden_alias;
		
		if(is_array($this->data)){
				//doorloop de data
				foreach($this->data as $rij=>$inhoud){
			
				//vergelijk de data en tel het bij elkaar op
				foreach($this->zoekvelden as $veld=>$rating){
					foreach($this->zoekwoorden as $woornr=>$woord){
						$aant=count(@explode(strtolower($woord),strtolower($inhoud[$alias[$veld]])))-1;
						$score[$rij]+=$aant*$rating;
						
						//voor berekenen van percentages even hogste waarde bijhouden.
						if($score[$rij]>$this->hoogste){
							$this->hoogste=$score[$rij];
						}
						
						
					}
				}
			}
		}
		if(is_array($this->data)){
			arsort($score);
		}
		$this->score=$score;
		
		//pointersets
		$i=1;
		if(is_array($this->data)){
			foreach($score as $key=>$val){
				$this->pointer[$i]=$key;
				$i++;
			}
		}
		

	}
		
		//alle ratingen op 0 zetten en de pointers aanmaken als er geen zoekwoorden zijn ingevult
		function rate_dummy(){
			$i=1;
			if(is_array($this->data)){
				foreach($this->data as $key=>$val){
					$this->pointer[$i]=$key;
					$this->score[$key]=0;
					$i++;
				}
			}
			
		}
		
		
		//cursor locatie setten
		function set_cursor($pos){
			$this->cursor=$pos;
		}
		
		//item fetchen en cursor naar volgende item zetten
		function fetch(){
			$array=$this->data[$this->pointer[$this->cursor]];
			if($this->score[$this->pointer[$this->cursor]]>0){
				$array['score']=round($this->score[$this->pointer[$this->cursor]]/$this->hoogste*100);
				//$array['score']=$this->score[$this->pointer[$this->cursor]];
			}else{
				$array['score']=0;
			}
			
			
				$this->cursor++;
				
			if($this->cursor-2 < $this->aantal){
				return $array;
			}else{
				return false;
			}
			
		
			

		}
		

		
		
	}

?>