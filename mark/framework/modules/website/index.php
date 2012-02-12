<?php
class M_index extends Controller
{
	function index(){
		$layout = new layout("index");
		$layout -> assign("plaats", $this -> _getPlaats());
		if(isset($_GET['plaats'])){
			$plaats = $_GET['plaats'];
			$layout -> assign("kapsalon", $this -> _getKapsalon($plaats));
		}
		out($layout -> draw());
	}	
	
	function _getPlaats(){
		$query = $this -> db -> getTable("kapsalon");
		$output = $query -> getAll();
		print_r($_GET);
		return $output;	
	}
	
	function _getKapsalon($data){
		$this -> db -> where("plaats='$data'");
		$query	= $this -> db -> getTable("kapsalon");
		$output = $query -> getAll();
		return $output;
	}
	
	function _getBehandeling($data){
	
	}
	
	function _getKapper($data){
	
	}
}