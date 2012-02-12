<?php
	class pageNumbering{
		
		var $now;
		var $perPage;
		var $where;
		var $query;
		var $pointer=0;
		var $aantPages=0;
		
		function pageNumbering($perPage=25){
			$this->perPage=$perPage;
		}
		
		
		//now waarde instellen
		function setNow($now){
			$this->now=$now;
		}
		
		//where waarde instellen
		function setWhere($where){
			$this->where=$where;
		}
		
		
		//tabel inladen voor paginanummering
		function loadOnTable($table){
			//fixje voor eerste pagina.
			if(!$this->now){
				$this->now=1;
			}
			
			//query uitvoeren
			$query="select * from `".$table."` ";
			if($this->where){
				$query.="where ".$this->where;
			}
			$this->query = new query($query);
			
			//aantal pagina's berekenen
			$this->aantPages=ceil($this->query->count()/$this->perPage);
		}
		
		
		//limiet ophalen
		function getLimit(){
			return (($this->now-1)*$this->perPage).",".$this->perPage;
		}
		
		
		//now waarde ophalen
		function getNow(){
			return $this->now;
		}
		
		
		//volgende waarde ophalen. voor doorlopen van alle waarden
		function next(){
			if($this->pointer<$this->aantPages){
				$this->pointer++;
				return true;
			}else{
				return false;
			}
		}
		
		//pointer waarde ophalen
		function get(){
			return $this->pointer;
		}
		
		function reset(){
			$this->pointer=0;
		}
		
		
		
	}
?>
