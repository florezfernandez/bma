<?php 
$idMicroorganism=$_GET['idMicroorganism'];
$microorganism = new Microorganism($idMicroorganism);
$microorganism -> select();
$type = new Type($microorganism->getIdType());
$type->select();

?>
<script type="text/javascript">
$('body').on('show.bs.modal', '.modal', function (e) {
	var link = $(e.relatedTarget);
	$(this).find(".modal-content").load(link.attr("href"));
});
$('body').on('hidden.bs.modal', '.modal', function () {
	document.getElementById("modalContent").innerHTML="";
});
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="modalContent">
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12 text-left">
			<h3><?php echo $type->getName() . " " . $microorganism->getName() ?></h3>
			<p><?php echo $microorganism->getDescription() ?></p>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Genes of <?php echo $microorganism->getName() ?></h3>
				</div>
				<div class="panel-body">					
					<table class="table table-striped table-hover">
						<tr>
							<td><strong>Name</strong></td>
							<td><strong>Description</strong></td>
							<td></td>
							</tr>
							<?php 
								$gene = new Gene("",$idMicroorganism);
								$genes = $gene->selectByMicroorganism();
								for ($i = 0; $i < count($genes); $i++) {
									echo "<tr>";
									echo "<td>", $genes[$i]->getName(), "</td>";
									echo "<td>", $genes[$i]->getDescription(), "</td>";
									echo "<td class='text-center' nowrap>
									<a href='sequenceViewer.php?idGene=".$genes[$i]->getId()."' data-toggle='modal' data-target='#myModal' ><img src='img/view.ico' width='30' data-toggle='tooltip' data-placement='left' data-original-title='View Sequence'/></a>						
									<a href='index.php?pid=".base64_encode("ui/viewPositions.php")."&idGene=".$genes[$i]->getId()."&nameMicroorganism=".$microorganism->getName()."&nameType=".$type->getName()."' ><img src='img/list.ico' width='30' data-toggle='tooltip' data-placement='left' data-original-title='View Positions'/></a>						
									</td>";
									echo "</tr>\n";
								}
								echo "<tr><td colspan='10'><strong>" . count($genes) . " registries<strong></td></tr>";											
							?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
