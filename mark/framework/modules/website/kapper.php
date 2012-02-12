<?php
class M_kapper extends Controller
{	
	function mogelijkheden(){
		$query = $this -> db -> getTable("behandeling");
		$layout = new layout("kapper/mogelijkheden");
		$layout -> assign("mogelijkheden", $query -> getAll());
		//$layout = -> assign("mogelijkheden", $query -> getAll());
		out($layout -> draw());
	}
	
	function mogelijkhedenToevoegen($data){
		
	}
	
	function getKapper(){
	}
	
	function setKapper($data){
	}
	
	function getKapsalon($data){
	}
	
	function setKapsalon($data){
		
	}
}
?> 