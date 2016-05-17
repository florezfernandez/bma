<?php
require_once("business/Gene.php");
require_once("persistence/Conection.php");
$idGene = $_GET ['idGene'];
$gene = new Gene($idGene);
$gene->select();
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title"><?php echo $gene->getName(); ?></h4>
</div>
<div class="modal-body">
	<textarea style="resize:none" class="form-control" rows="15"><?php echo $gene->getSequence(); ?></textarea>
</div>