<?php	
	include("includes/operators.php");
	$layout=new layout("codes/voorwaarden");
	$db=new db();
	$db->where("tabel='".$_GET["id"]."'");
	$query=$db->getTable("kolom");
	$columns=$query->getAll();
	
	$layout=new layout("codes/voorwaarden");
	$layout->assign("columns",$columns);
	$layout->assign("operators",$operators);
	out($layout->draw());
?>