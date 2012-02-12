<?php
	
	class db{
		
		var $where;
		var $limit;
		var $order;
		var $fields;
		
		//sorteren 
		function order($order){
			$this->order=$order;
		}
		
		//where toevoegen
		function where($where){
			$this->where=$where;
		}
		
		
		//limit toevoegen
		function limit($limit){
			$this->limit=$limit;
		}
		
		//velden kiezen
		function fields($fields){
			$this->fields=$fields;
		}
		
		//tabel ophalen
		function getTable($table){
			$qString="select ";
			
			//velden bepalen
			if(!empty($this->fields)){
				$qString.=$this->fields." ";
				$this->fields="";
			}else{
				$qString.="* ";
			}
			
			$qString.="from ".$table." ";
			
			
			if(!empty($this->where)){
					$qString.="where ".$this->where." ";
					$this->where="";
			}
			
			if(!empty($this->order)){
				$qString.="order by ".$this->order." ";
				$this->order="";
			}
			
			if(!empty($this->limit)){
				$qString.="limit ".$this->limit." ";
				$this->limit="";
			}
			

		
			//return new query($qString,$table,$table."Id",true);
			return new query($qString,$table,"id",true);
		}
		
		//1 resultaat ophalen
		function getOne($table,$resultnummer=0){
			$this->limit($resultnummer.",1");
			$query=$this->getTable($table);
			$query->fetch();
			return $query;
		}
			
		//gewoon een losse query uitvoeren	
		function query($queryString){
			return new query($queryString);
		}
	}
	
	class query{
		var $query;
		var $results;
		var $sql;
		var $pointer;
		var $editable;
		var $primaryKey;
		var $table;
		var $changed;
		var $queryString;
		
		
		//query initialiseren
		function query($queryString,$table="",$primaryKey=NULL,$editable=false){
			global $sql;
			$this->sql=$sql;
			$this->query=$this->sql->query($queryString);
			$this->moveFirst();
			if(isset($table)){
				$this->editable=$editable;
				$this->table=$table;
				$this->primaryKey=$primaryKey;
			}
			$this->queryString=$queryString;			
		}
		
		
		//terug gaan naar begin
		function moveFirst(){
			$this->pointer=0;
			
			if($this->sql->goRow($this->query,0)){
				return true;
			}
	
		}
		

		//item terug gaan
		function moveBack(){
			$this->pointer--;
			if($this->sql->goRow($this->query,$this->pointer)){
				return true;
			}
		}
		
		//item vooruit gaan
		function moveNext(){
			$this->pointer++;
			if($this->sql->goRow($this->query,$this->pointer)){
				return true;
			}
		}
		
		
		//item fetchen
		function fetch(){
			if($show=$this->sql->fetch($this->query)){
				$this->result=$show;
				return true;
			}
		}
		
		//aantal resultaten ophalen
		function count(){
			return $this->sql->aantal($this->query);
		}
		

		//veld ophalen
		function get($field,$changed=false){
			if($changed==true and $this->changed[$field]){
				return $this->changed[$field];
			}else{
				return $this->result[$field];
			}
		}
		
		//resultarray ophalen
		function getArray(){
			return $this->result;
		}
		
		function getAll(){
			$this->moveFirst();
			while($this->fetch()){
				$array=$this->getArray();
				$all[]=$array;
			}
			
			return $all;
		}
		
		//item setten
		function set($field,$data){
			if($this->editable and ( !is_array($this->result) or isset($this->result[$field]) ) ){
				$this->changed[$field]=$data;
			}
		}
		
		//item removen
		function remove(){
			if($this->editable){
					$this->sql->query("delete from ".$this->table." where ".$this->primaryKey."='".$this->result[$this->primaryKey]."'");
			}
		}
		
		//data updaten
		function update(){
			if($this->editable){
				$qString="update ".$this->table." set ";
				$i=0;
				foreach($this->changed as $key=>$val){
					if($i!=0){
						$qString.=",";
					}
					$qString.= $key."='".$val."' ";
					$i++;
				}
				$qString.="where ".$this->primaryKey."='".$this->result[$this->primaryKey]."'";
				if($this->sql->query($qString)){
					return true;
				}
			}
		}
		
		
		//data inserten
		function insert($array=""){
			
			if($this->editable){
				//qstring beginnen
				$qString="insert into ". $this->table . " set ";
				
				//array bepalen
				if(!$array){
					$array=$this->changed;
				}
				
				//array doorlopen
				$i=0;
				foreach($this->changed as $key=>$val){
					if($i!=0){
						$qString.=",";
					}
					$qString.= $key."='".$val."' ";
					$i++;
				}
				
				if($this->sql->query($qString)){
					return true;
				}
				
			}
		}	
		
		
		//refresh de query
		function refresh(){
			$this->query=$this->sql->query($this->queryString);
			$this->moveFirst();
			$this->fetch();
		}
		
		
	}

?>
