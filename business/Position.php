<?php
require_once ("persistence/PositionDAO.php");

class Position {
	private $id;
	private $idGene;
	private $position;
	private $mutation;
	private $antiviral;
	private $inhibitor;
	private $main;
	
	private $positionDAO;
	private $conection;

	function Position($i = "", $idg = "", $pos = "", $mut = "", $ant = "", $inh = "", $mai="") {
		$this -> id = $i;
		$this -> idGene = $idg;
		$this -> position = $pos;
		$this -> mutation = $mut;
		$this -> antiviral = $ant;
		$this -> inhibitor = $inh;
		$this -> main = $mai;
		$this -> positionDAO = new PositionDAO($this -> id, $this -> idGene, $this->position, $this->mutation, $this->antiviral, $this->inhibitor, $this->main);
		$this -> conection = new Conection();
	}

	function getId() {
		return $this -> id;
	}

	function getIdGene() {
		return $this -> idGene;
	}
	
	function getPosition() {
		return $this -> position;
	}

	function getMutation() {
		return $this -> mutation;
	}

	function getAntiviral() {
		return $this -> antiviral;
	}
	
	function getInhibitor() {
		return $this -> inhibitor;
	}

	function getMain() {
		return $this -> main;
	}
	
	function select() {
		$this -> conection -> run($this -> positionDAO -> select());
		$result = $this -> conection -> fetch();
		$this -> idGene = $result[1];
		$this -> position = $result[2];
		$this -> mutation = $result[3];
		$this -> antiviral = $result[4];
		$this -> inhibitor = $result[5];
		$this -> main = $result[6];
	}

	function selectByGene($idGene) {
		$this -> conection -> run($this -> positionDAO -> selectByGene($idGene));
		$results = array();
		$numRows = 0;
		while ($result = $this -> conection -> fetch()) {
			$results[$numRows] = new Position($result[0], $result[1], $result[2], $result[3], $result[4], $result[5], $result[6]);
			$numRows++;
		}
		return $results;
	}
	

}
?>