<?php
class M_index extends Controller
{
	function index(){	
		$layout = new layout("index");
		$layout -> assign("plaats", $this -> _getPlaats());
		if(isset($_POST['plaats'])){
			$plaats = $_POST['plaats'];
			$layout -> assign("plaatsSelected", $plaats);
			$layout -> assign("kapsalon", $this -> _getKapsalon($plaats));
		}
		if(isset($_POST['kapsalon'])){
			$kapsalon = $_POST['kapsalon'];
			$layout -> assign("plaatsSelected", $_POST["plaatsSelected"]);
			$layout -> assign("kapsalonSelected", $kapsalon);
			$layout -> assign("kapsalonName", $this -> _setKapsalonToName($kapsalon));
			$layout -> assign("behandeling", $this -> _getBehandeling($kapsalon));
		}
		if(isset($_POST['behandeling'])){
			$behandeling = $_POST['behandeling'];
			$layout -> assign("plaatsSelected", $_POST["plaatsSelected"]);
			$layout -> assign("kapsalonSelected", $_POST["kapsalonSelected"]);
			$layout -> assign("kapsalonName", $this -> _setKapsalonToName($_POST["kapsalonSelected"]));
			$layout -> assign("behandelingName", $this -> _setBehandelingToName($behandeling));
			$layout -> assign("behandelingSelected", $behandeling);	
			$layout -> assign("kapper", $this -> _getKapper($behandeling));		
		}
		out($layout -> draw());
	}	
	
	function _getPlaats(){
		$query = $this -> db -> getTable("kapsalon");
		$output = $query -> getAll();
		return $output;	
	}
	
	function _getKapsalon($data){
		$this -> db -> where("plaats='$data'");
		$query	= $this -> db -> getTable("kapsalon");
		$output = $query -> getAll();
		return $output;
	}
	
	function _getBehandeling($data){
		$this -> db -> where("kapsalonId='$data'");
		$query = $this -> db -> getTable("kapperBehandeling");
		$kapperBehandeling = $query -> getAll();
		$behandelingenArray = array();
		foreach($kapperBehandeling as $value){
			$id = $value['behandelingId'];
			$this -> db -> where("behandelingId='$id'");
			$query = $this -> db -> getTable("behandeling");
			$behandelingen = $query -> getAll();
			$behandelingenArray[]= $behandelingen;
		}
		print_r($behandelingenArray);
		return $behandelingenArray;
	}
	
	function _getKapper($data){
		$this -> db -> where("behandelingId='$data'");
		$query = $this -> db -> getTable("kapperBehandeling");
		$kapperBehandeling = $query -> getAll();
		$kappersArray = array();
		foreach($kapperBehandeling as $value){
			$id = $value['kapperId'];
			$this -> db -> where("kapperId='$id'");
			$query = $this -> db -> getTable("kapper");
			$kappers = $query -> getAll();
			$kappersArray[] = $kappers;
		}
		return $kappersArray;
	}
	
	function _setKapsalonToName($data){
		$this -> db -> where("kapsalonId='$data'");
		$query = $this -> db -> getTable("kapsalon");
		$output = $query -> getAll();
		return $output;
	}
	
	function _setBehandelingToName($data){
		$this -> db -> where("behandelingId='$data'");
		$query = $this -> db -> getTable("behandeling");
		$output = $query -> getALl();
		return $output;
	}
	
}
?>