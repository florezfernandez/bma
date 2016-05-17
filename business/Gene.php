<?php
require_once ("persistence/GeneDAO.php");

class Gene {
	private $id;
	private $idMicroorganism;	
	private $name;
	private $description;
	private $sequence;
	
	private $geneDAO;
	private $conection;

	function Gene($i = "", $idm = "", $nam = "", $des = "", $seq = "") {
		$this -> id = $i;
		$this -> idMicroorganism = $idm;
		$this -> name = $nam;
		$this -> description = $des;
		$this -> sequence = $seq;
		$this -> geneDAO = new GeneDAO($this -> id, $this -> idMicroorganism, $this -> name, $this->description, $this->sequence);
		$this -> conection = new Conection();
	}

	function getId() {
		return $this -> id;
	}

	function getIdMicroorganism() {
		return $this -> idMicroorganism;
	}
	
	function getName() {
		return $this -> name;
	}

	function getDescription() {
		return $this -> description;
	}
	
	function getSequence() {
		return $this -> sequence;
	}

	function select() {
		$this -> conection -> run($this -> geneDAO -> select());
		$result = $this -> conection -> fetch();
		$this -> name = $result[2];
		$this -> description = $result[3];
		$this -> sequence = $result[4];
	}

	function selectAll() {
		$this -> conection -> run($this -> geneDAO -> selectAll());
		$results = array();
		$numRows = 0;
		while ($result = $this -> conection -> fetch()) {
			$results[$numRows] = new Gene($result[0], $result[1], $result[2], $result[3], $result[4]);
			$numRows++;
		}
		return $results;
	}

	function selectByMicroorganism() {
		$this -> conection -> run($this -> geneDAO -> selectByMicroorganism());
		$results = array();
		$numRows = 0;
		while ($result = $this -> conection -> fetch()) {
			$results[$numRows] = new Gene($result[0], $result[1], $result[2], $result[3], $result[4]);
			$numRows++;
		}
		return $results;
	}
	
	function validatePatientSequence($patientSequence){
		if(strlen($this->sequence)!=strlen($patientSequence)){
			return 1;
		}	
		$firstLetterPos=strlen($this->sequence);
		$lastLetterPos=0;
		for($i=0; $i<strlen($patientSequence); $i++){
			if($patientSequence[$i]=="A" || $patientSequence[$i]=="C" || $patientSequence[$i]=="G" || $patientSequence[$i]=="T"){
				if($i<$firstLetterPos){
					$firstLetterPos=$i;
				}
				if($i>$lastLetterPos){
					$lastLetterPos=$i;
				}
			}
			else{
				if($patientSequence[$i]!="-"){
					return 2;
				}				
			}
		}
		for($i=0; $i<strlen($patientSequence); $i++){
			if($patientSequence[$i]=="-" && $i>$firstLetterPos && $i<$lastLetterPos){
				return 3;
			}
		}					
		return 0;
	}
}
?>