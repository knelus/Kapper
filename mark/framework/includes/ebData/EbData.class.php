<?php
	class EbData{
		var $name;
		var $file;
		
		function ebData(){

		}
		function setData($file,$naam){
			$this->name=$naam;
			$this->file=$file;
			
		}
		
		function lastUpdate(){
			global $sql,$userId;
			$sql->query("update tabel set lastUpdate='".time()."' where  naam='".$this->name."' and user='".$userId."'");
		}
		
	}
?>