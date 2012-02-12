<?php
class M_kapsalon extends Controller
{
	function lijst(){
		$kapsalon = $this -> db -> getTable("kapsalon");
		$layout = new layout("kapsalon/lijst");
		$layout -> assign("lijst",$kapsalon -> getAll());	
		out($layout -> draw());
	}
}
?>