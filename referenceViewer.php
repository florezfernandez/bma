<?php
require_once("business/Gene.php");
require_once("business/Reference.php");
require_once("persistence/Conection.php");
$idGene = $_GET ['idGene'];
$gene = new Gene($idGene);
$gene->select();
$idPosition = $_GET['idPosition'];
$reference = new Reference();
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title"><?php echo $gene->getName(); ?></h4>
</div>
<div class="modal-body">
	<h4>References <i>in vitro</i></h4>
	<?php 
	$references = $reference -> selectByPosition(1, $idPosition);
	for ($j = 0; $j < count($references); $j++) {
		echo "<p>"
			.$references[$j]->getAuthors().". "
			."<strong><i>".$references[$j]->getPaperName()."</i></strong>. "
			.$references[$j]->getJournal().". "
			.$references[$j]->getYear().". "
			.$references[$j]->getVolume().". "
			.$references[$j]->getPages().". "
			."<a href='https://scholar.google.com.co/scholar?hl=en&q=".$references[$j]->getPaperName()."' target='_blank'>Find at Google Scholar.</a>"
			."</p>";
	}	
	?>
	<hr>	
	<h4>References <i>in vivo</i></h4>
	<?php 
	$references = $reference -> selectByPosition(2, $idPosition);
	for ($j = 0; $j < count($references); $j++) {
		echo "<p>"
			.$references[$j]->getAuthors().". "
			."<strong><i>".$references[$j]->getPaperName()."</i></strong>. "
			.$references[$j]->getJournal().". "
			.$references[$j]->getYear().". "
			.$references[$j]->getVolume().". "
			.$references[$j]->getPages().". "
			."<a href='https://scholar.google.com.co/scholar?hl=en&q=".$references[$j]->getPaperName()."' target='_blank'>Find at Google Scholar.</a>"
			."</p>";
	}
	
	?>
</div>