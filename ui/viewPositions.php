<?php 
$idGene=$_GET['idGene'];
$nameMicroorganism=$_GET['nameMicroorganism'];
$nameType=$_GET['nameType'];
$gene = new Gene($idGene);
$gene->select();
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#selectAll').click(function(){
		$('#selectMain').attr('checked', false);
		var checked = $(this).is(":checked");
		var positions = $('[name="positions[]"]');	
		for(i=0; i<positions.length; i++){
			positions[i].checked = checked;
		} 	
	});

	$('#selectMain').click(function(){
		$('#selectAll').attr('checked', false);
		var checked = $(this).is(":checked");
		var positions = $('[name="positions[]"]');
		i=0;
		var mainPositions = [];	
		$('#positionsTable tr').each(function() {
			mainPositions[i]=$(this).find('td:eq(5)').html()
			console.log(mainPositions[i]);
			if(mainPositions[i]=="Yes" || mainPositions[i]=="No"){
				i++;
			}
		 });

		for(i=0; i<positions.length; i++){
			if(checked && mainPositions[i]=="Yes"){
				positions[i].checked = true;
			}else{
				positions[i].checked = false;	
			}			
		} 	
	});

});
</script>

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
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Positions Amino Acids</h3>
				</div>
				<div class="panel-body">
					<form id="form" role="form" method="post" action="<?php echo "index.php?pid=".base64_encode("ui/selectPatients.php")."&idGene=".$idGene."&nameMicroorganism=".$nameMicroorganism."&nameType=".$nameType ?>" >
						<div class='alert alert-success' role='alert'>
							<strong>Selected <?php echo $nameType ?>:</strong> <?php echo $nameMicroorganism ?><br>
							<strong>Selected Gene:</strong> <?php echo $gene->getName() ?>. Nucleotides: <?php echo strlen($gene->getSequence()) ?> <a href='<?php echo "sequenceViewer.php?idGene=".$idGene ?>' data-toggle='modal' data-target='#myModal' ><img src='img/viewFile.ico' width='20' data-toggle='tooltip' data-placement='top' data-original-title='View Sequence'/></a>
						</div>
						<table id="positionsTable" class="table table-striped table-hover">
							<tr>
								<td nowrap><input type="checkbox" id="selectAll" data-toggle='tooltip' data-placement='top' data-original-title='Check/Uncheck All'>
								<input type="checkbox" id="selectMain" data-toggle='tooltip' data-placement='top' data-original-title='Check/Uncheck Main'></td>
								<td><strong>Position</strong></td>
								<td><strong>Mutation</strong></td>
								<td><strong><?php echo ($gene->getName()!="HA1")?"Antiviral":"Antigenic site" ?></strong></td>
								<td><strong>Inhibitor</strong></td>
								<td><strong>Main</strong></td>
								<td nowrap><strong>References <i>in vitro</i></strong></td>
								<td nowrap><strong>References <i>in vivo</i></strong></td>
								<td></td>
								</tr>
								<?php 
									$position = new Position();
									$positions = $position->selectByGene($idGene);
									$reference = new Reference();
									for ($i = 0; $i < count($positions); $i++) {
										echo "<tr>";
										echo "<td><input type='checkbox' id='positions' name='positions[]' value=".$positions[$i]->getId()."></td>";
										echo "<td>", $positions[$i]->getPosition(), "</td>";
										echo "<td>", $positions[$i]->getMutation(), "</td>";
										echo "<td>", $positions[$i]->getAntiviral(), "</td>";
										echo "<td nowrap>", $positions[$i]->getInhibitor(), "</td>";										
										echo "<td>",($positions[$i]->getMain()==1)?"Yes":"No","</td>";
										//
										echo "<td nowrap>";
										$references = $reference -> selectByPosition(1, $positions[$i]->getId());
										for ($j = 0; $j < count($references); $j++) {
											echo $references[$j]->getCite(), ".<br>";
										}
										echo "</td>";
										echo "<td nowrap>";
										$references = $reference -> selectByPosition(2, $positions[$i]->getId());
										for ($j = 0; $j < count($references); $j++) {
											echo $references[$j]->getCite(), ".<br>";
										}
										echo "</td>";
											
										echo "<td class='text-center' nowrap>
										<a href='referenceViewer.php?idGene=".$idGene."&idPosition=".$positions[$i]->getId()."' data-toggle='modal' data-target='#myModal' ><img src='img/view.ico' width='30' data-toggle='tooltip' data-placement='left' data-original-title='View References Details'/></a>						
										</td>";
										echo "</tr>\n";
									}
									echo "<tr><td colspan='10'><strong>" . count($positions) . " registries<strong></td></tr>";											
								?>
						</table>
						<button type="submit" class="btn btn-primary" id="submit">Continue</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
