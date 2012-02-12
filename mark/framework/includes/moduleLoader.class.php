<?php
	class moduleLoader{
		var $parent;
		var $paginaInfo;
		var $module;
		
		function moduleLoader($parent=0){
			$this->parent=$parent;
		}
		
		function load($program,$module=""){
			global $url,$error,$sql,$output,$lang,$user;
			
			//pagina opvragen
			if(!empty($module)){
				$pagina=$module;
			}else{
				$pagina=$url->get(0);
			}
			

			$paginaInfo['naam']=$pagina;
			$paginaInfo['module']=$paginaInfo['naam'];

			
			//handler voor de pagina inladen
			if(file_exists("modules/".$program."/".$paginaInfo['module'].".php")){
				include_once("modules/".$program."/".$paginaInfo['module'].".php");
				eval('$module=new M_'.$paginaInfo['module'].'();');
				$module->__setInfo($paginaInfo,$program);
				$module->__start();
			}else{
				$error->add("Module niet gevonden");
			}
			
			$this->module=$module;
			$this->paginaInfo=$paginaInfo;
		
		}
	}
?>
