<?php
class PositionDAO {
	private $id;
	private $idGene;
	private $position;
	private $mutation;
	private $antiviral;
	private $inhibitor;
	private $main;
	
	function PositionDAO($i = "", $idg = "", $pos = "", $mut = "", $ant = "", $inh = "", $mai="") {
		$this -> id = $i;
		$this -> idGene = $idg;
		$this -> position = $pos;
		$this -> mutation = $mut;
		$this -> inhibitor = $inh;
		$this -> main = $mai;
	}
	
	function select() {
		return "select *
				from position
				where idposition = " . $this -> id;
	}
	
	function selectByGene($idGene) {
		return "select *
				from position
				where gene_idgene = '". $idGene."'
				order by position";
	}
	

}
?>