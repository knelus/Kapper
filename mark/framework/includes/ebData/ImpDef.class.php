<?php
	class ImpDef extends EbData{
		var $data;
		var $name;
		
		function start(){
			$content=file_get_contents($this->file);
			$this->data=json_decode($content,true);			
			$this->mkTable();
			$this->getColumns();	
			$this->cleanUp();
		}
		
		function getColumns(){
			global $sql,$userId;
			$columns=$this->data['columns'];
			if(is_array($columns)){
				$tabelResult=$sql->result("select * from tabel where naam='".$this->name."' and user='".$userId."'");
				$tabelId=$tabelResult["id"];
				foreach($columns as $val){
					if(!$sql->aantal($sql->query("select * from kolom where naam='".$val['name']."' and tabel='".$tabelId."'"))){
						$sql->query("insert into kolom (id,tabel,naam,`primary`,dataType,viewOrder,importOrder) values ('','".$tabelId."','".$val['name']."','".$val['primary']."','".$val['type']."','".$val['viewOrder']."','".$val['importOrder']."')");
					}else{
						$sql->query("update kolom set `primary`='".$val['primary']."',`dataType`='".$val['type']."',viewOrder='".$val['viewOrder']."',importOrder='".$val['importOrder']."'
									where naam='".$val['name']."' and tabel='".$tabelId."'");

					}
				}
			}
		}
		
		function cleanUp(){
			global $sql,$userId;
			$columns=$this->data['columns'];
			$tabelResult=$sql->result("select * from tabel where naam='".$this->name."' and user='".$userId."'");
			$tabelId=$tabelResult["id"];
			$query=$sql->query("select * from kolom where tabel='".$tabelId."'");
			
			while($show=$sql->fetch($query)){
				$delete=true;
				foreach($columns as $val){
					if($val['name']==$show['naam']){
						$delete=false;
					}
				}
				
				if($delete){
					$sql->query("delete from kolom where id='".$show['id']."'");
				}
				
			}
			
		}
		
		function mkTable(){
			global $sql,$userId;
			if($this->data['info']['name']){
				$this->name=$this->data['info']['name'];
			}
			
			if(!$sql->aantal($sql->query("select * from tabel where naam='".$this->name."' and user='".$userId."'"))){
				$sql->query("insert into tabel (id,naam,user) values ('','".$this->name."','".$userId."')");
			}
			
			
		}
		
		
	}
?>