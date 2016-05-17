<?php
class GeneDAO {
	private $id;
	private $idMicroorganism;	
	private $name;
	private $description;
	private $sequence;
	
	function GeneDAO($i = "", $idm = "", $nam = "", $des = "", $seq = "") {
		$this -> id = $i;
		$this -> idMicroorganism = $idm;
		$this -> name = $nam;
		$this -> description = $des;
		$this -> sequence = $seq;
	}
	
	function select() {
		return "select * 
				from gene 
				where idgene = " . $this -> id;
	}

	function selectAll() {
		return "select *  
				from gene"; 
	}		

	function selectByMicroorganism() {
		return "select *
				from gene
				where microorganism_idmicroorganism = " . $this -> idMicroorganism;
	}
	
}
?>