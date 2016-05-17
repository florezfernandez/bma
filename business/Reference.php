<?php
require_once ("persistence/ReferenceDAO.php");

class Reference {
	private $id;
	private $authors;
	private $paperName;
	private $journal;
	private $year;
	private $volume;
	private $pages;
	
	private $referenceDAO;
	private $conection;

	function Reference($i = "", $aut = "", $paN = "", $jou = "", $yea = "", $vol = "", $pag = "") {
		$this -> id = $i;
		$this -> authors = $aut;
		$this -> paperName = $paN;
		$this -> journal = $jou;
		$this -> year = $yea;
		$this -> volume = $vol;
		$this -> pages = $pag;
		$this -> referenceDAO = new ReferenceDAO($this -> id, $this -> authors, $this->paperName, $this->journal, $this->year, $this->volume, $this->pages);
		$this -> conection = new Conection();
	}

	function getId() {
		return $this -> id;
	}

	function getAuthors() {
		return $this -> authors;
	}
	
	function getPaperName() {
		return $this -> paperName;
	}

	function getJournal() {
		return $this -> journal;
	}

	function getYear() {
		return $this -> year;
	}
	
	function getVolume() {
		return $this -> volume;
	}
	
	function getPages() {
		return $this -> pages;
	}
	
	function getCite() {
		$indAuthors = split(",", $this->authors);
		return $indAuthors[0].", ".$this->year;
	}
	
	
	//refType: 1=inVitro; 2=inVivo
	function selectByPosition($refType, $idPosition) {
		$this -> conection -> run($this -> referenceDAO -> selectByPosition($refType, $idPosition));
		$results = array();
		$numRows = 0;
		while ($result = $this -> conection -> fetch()) {
			$results[$numRows] = new Reference($result[0], $result[1], $result[2], $result[3], $result[4], $result[5], $result[6]);
			$numRows++;
		}
		return $results;
	}
}
?>