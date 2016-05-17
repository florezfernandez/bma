<?php
require_once ("persistence/ReferenceDAO.php");
require_once ("persistence/Conection.php");

class ReferenceDAO {
	private $id;
	private $authors;
	private $paperName;
	private $journal;
	private $year;
	private $volume;
	private $pages;
	
	function ReferenceDAO($i = "", $aut = "", $paN = "", $jou = "", $yea = "", $vol = "", $pag = "") {
		$this -> id = $i;
		$this -> authors = $aut;
		$this -> paperName = $paN;
		$this -> journal = $jou;
		$this -> year = $yea;
		$this -> volume = $vol;
		$this -> pages = $pag;
	}

	//refType: 1=inVitro; 2=inVivo
	function selectByPosition($refType, $idPosition) {
		if($refType==1){
			return "select re.*
				from reference re, referenceinvitro rv
				where re.idreference=rv.reference_idreference and rv.position_idposition = " . $idPosition;
		}else{
			return "select re.*
				from reference re, referenceinvivo rv
				where re.idreference=rv.reference_idreference and rv.position_idposition = " . $idPosition;
		}
	}
}
?>