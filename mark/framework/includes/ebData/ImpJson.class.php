<?php
		class ImpJson extends EbData{		
		
			function start(){
				global $sql,$userId;
				$content=file_get_contents($this->file);
				$data=json_decode($content,true);

				


				
				$table=$sql->result("select * from tabel where user='".$userId."' and naam='".$this->name."'");
				$query=$sql->query("select * from kolom where tabel='".$table['id']."'");
				$this->cleanTable($table['id']);
				
				
				while($show=$sql->fetch($query)){
					$columns[$show['importOrder']]=$show['id'];
				}
				
				foreach($data as $val){
					$row=$this->mkRow($table['id']);
					foreach($val as $keya=>$vala){
						$sql->query("INSERT INTO `cell` (
										`id` ,
										`rij` ,
										`kolom` ,
										`tabel` ,
										`data` 
										)
										VALUES (
										NULL , '".$row."', '".$columns[$keya]."', '".$table['id']."', '".$vala."'
										);
										
										");
					}
				}
				
				
			}
			
			
			function mkRow($table){
				global $sql;
				$query=$sql->query("insert into rij (id,tabel) values  ('','".$table."')");
				$result=$sql->result("select * from rij where tabel ='".$table."' order by id desc limit 0,1");

				return $result['id'];
			}
			
			function cleanTable($table){
				global $sql;
				$sql->query("delete from rij where tabel='".$table."'");
				$sql->query("delete from cell where tabel='".$table."'");
			}
			
			
		}
?>