<?php
	class EbTable{
		
		var $wheres;
		var $order;
		var $limit;
		var $tabel;
		var $user;
		
		function ebTable($user,$tabel=""){
			if($table){
				$this->user=$user;
				$this->initTable($tabel);
			}else{
				$this->initTableById($user);
			}
			$this->initOrder();
		}
		
		function initTableById($id){
			global $sql;
			$result=$sql->result("select * from tabel where id='".$id."'");
			$this->user=$result['user'];
			$this->tabel=$result;
		}
		
		function initTable($tabel){
			global $sql;
			$result=$sql->result("select * from tabel where user='".$this->user."' and naam='".$tabel."'");
			$this->tabel=$result;
			
		}
		
		function initOrder(){
			global $sql;
			$result=$sql->result("select * from kolom where tabel='".$this->tabel['id']."' order by `primary` desc limit 0,1");
			$this->setOrder($result['naam']);
		}
		
		function setWhere($field,$operator,$value){
			$where['field']=$this->getColumn($field);
			$where['operator']=$operator;
			$where['value']=$value;
			$this->wheres[]=$where;
		}
		
		function setLimit($start,$amount){
			$this->limit['start']=$start;
			$this->limit['amount']=$amount;
		}
		
		function setOrder($field,$type="asc"){
			$this->order['field']=$this->getColumn($field);
			$this->order['type']=$type;
		}
		
		function getColumn($naam){
			global $sql;
			$result=$sql->result("select * from kolom where naam='".$naam."' and tabel='".$this->tabel['id']."'");
			return $result['id'];
		}
		
		function getData(){
			global $sql;
			
			if($this->isCached()){

				$data=$this->getCache();
				
				
				
				return $data;
			}
			
			$columns=$this->getColumns();
			$rows=$this->getRows();
			if(is_array($rows)){
				foreach($rows as $val){
					$row=NULL;
					if(is_array($columns)){
						foreach($columns as $vala){
							$result=$sql->result("select * from cell where rij='".$val."' and kolom='".$vala['id']."'");
							$cell["data"]=$result['data'];
							$row[]=$cell;
						}
						$data[]=$row;
					}
				}
			}
			$data=$this->checkWheres($data,$columns);
			$data=$this->killLimit($data);
			return $data;
		}
		
		function killLimit($data){
			if(is_array($this->limit)){
				$i=0;
				foreach($data as $key=>$val){
					if($i<$this->limit['start'] or $i>=$this->limit['start']+$this->limit['amount']){
						unset($data[$key]);
					}
					$i++;
				}
			}
			return $data;
		}
		
		function checkWheres($data,$columns){
			$time_start = microtime(true);
			



				
				include("includes/ebData/EbCheck.class.php");
				$ebCheck=new EbCheck();
				if(is_array($this->wheres)){
					foreach($this->wheres as $val){
						$cnum=$this->getColumnNumber($val['field'],$columns);
						foreach($data as $key=> $vald){
							if(!$ebCheck->voldoet($vald[$cnum]['data'],$val['operator'],$val['value'])){
								unset($data[$key]);
							}
						}
					}
				}
				$this->saveCache($data);
				
	
				
				return $data;
			
		
		}
		
		function getColumnNumber($id,$columns){
			if(is_array($columns)){
				foreach($columns as $key=>$val){
					if($val['id']==$id){
						$column=$key;
					}
				}
			}
			return $column;
		}
		
		
		function getColumns(){
			global $sql;
				$query=$sql->query("select * from kolom where tabel='".$this->tabel['id']."' order by viewOrder");
				while($show=$sql->fetch($query)){
					$columns[]=$show;
				}
				return $columns;
		}
		
		function getRows(){
			global $sql;
			$query=$sql->query("select rij from cell where kolom='".$this->order['field']."' order by data ".$this->order['type']);
			while($show=$sql->fetch($query)){
				$rows[]=$show['rij'];
			}
			return $rows;
			
		}
		
		function getCacheName(){

			return "tableCache/".base64_encode($this->tabel['id']."_".md5(print_r($this,true))).".php";
		}
		
		function isCached(){
			global $sql,$userId;
			$name=$this->getCacheName();
			
			if(!file_exists($name)){
				return false;
			}else{
				$cTime= @filemtime($name);
				$tTimeResult=$sql->result("select lastUpdate from tabel where id='".$this->tabel['id']."'");
				$tTime=$tTimeResult['lastUpdate'];
				if($tTime>$cTime){
					return false;
				}else{
					return true;
				}
			}
			
			
		}
		function getCache(){
			include($this->getCacheName());
			return $data;
		}
		
		function saveCache($data){
			
			$code="<?php ".
			$code.=$this->buildArrayCode($data);
			$handler=fopen($this->getCacheName(),"w+");
			fwrite($handler,$code);
			fclose($handler);
		}
		
		function buildArrayCode($data,$tussen=""){
			foreach($data as $key=>$val){
				if(is_array($val)){
					$output.=$this->buildArrayCode($val,$tussen.'["'.$key.'"]');
				}else{
					$output.='$data'.$tussen.'["'.$key.'"]="'.$val.'";'."\n";
				}
				
			}
			return $output;
			
		}
		
			
	}
?>