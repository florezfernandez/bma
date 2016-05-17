<?php
function getItems($dirPath,$nivel,$selectorType,$selectorName){
	$dir= opendir($dirPath);
	$items = array();
	$numItems=0;
	if($nivel==1){
		echo "<div class='tree well'>";
	}	
	while($content = readdir($dir)){
		if($content!="." && $content!=".." && $content!="Thumbs.db"){
			if(is_dir($dirPath."/".$content)){
				echo "<ul>";				
				echo "<li>
			    <span><img src='../img/folder.ico' width='20' />".$content."</span>
			    <ul>";
				getItems($dirPath."/".$content,$nivel+1,$selectorType,$selectorName);
				echo "</ul>
				</li>
				</ul>";
			}else{
				echo "<li><span>
				<input type='".$selectorType."' name='".$selectorName."' value='".$dirPath."/".$content."'> ".$content."
		        <a href='viewFile.php?filePath=" . base64_encode($dirPath."/".$content) . "' target='_blank' ><img src='../img/viewFile.ico' width='20' data-toggle='tooltip' data-placement='top' data-original-title='View File'/></a>
		        </span>
		        </li>";							
			}
		}					
	}
	if($nivel==1){
		echo "</div>";	
	}
}

function calculateTripletsChanges($referenceString, $patientString, $positions){		
	//echo "<pre>".$referenceString."</pre>";
	//echo "<pre>".$patientString."</pre>";
	$equivalencies = getEquivalencies();
	$changes = array();
	$changesCount = array();
	$equChanges = array();
	$equChangesConf = array();
	for($i=0; $i<count($positions); $i++){
		$pos = ($positions[$i]-1)*3;
		$referenceTrip=substr($referenceString, $pos, 3);
		$patientTrip=substr($patientString, $pos, 3);
		if($referenceTrip != $patientTrip){
			$changeFound=$referenceTrip." => ".$patientTrip;
			$changed=false;
			for($j=0; $j<count($changes); $j++){
				if($changes[$j]==$changeFound){
					$changesCount[$j]++;
					$changed=true;
				}
			}
			if(!$changed){				
				$changes[count($changes)]=$changeFound;
				$changesCount[count($changesCount)]=1;
			}						
		}
		$equChanges[count($equChanges)]=$positions[$i].": ".$referenceTrip." (".$equivalencies[$referenceTrip].") => ".$patientTrip." (".$equivalencies[$patientTrip].")";
		if($equivalencies[$referenceTrip]!=$equivalencies[$patientTrip]){
			$equChangesConf[count($equChangesConf)]="yes";			
		}else{
			$equChangesConf[count($equChangesConf)]="no";
		}
	}
	return array($changes, $changesCount, $equChanges, $equChangesConf);
}

function getEquivalencies(){
	return array(
			'TTT' => 'F','TTC' => 'F',
			'TTA' => 'L','TTG' => 'L','CTT' => 'L','CTC' => 'L','CTA' => 'L','CTG' => 'L',
			'TCT' => 'S','TCC' => 'S','TCA' => 'S','TCG' => 'S','AGT' => 'S','AGC' => 'S',
			'TAT' => 'Y','TAC' => 'Y',
			'TGT' => 'C','TGC' => 'C',
			'TGG' => 'W',
			'CCT' => 'P','CCC' => 'P','CCA' => 'P','CCG' => 'P',
			'CAT' => 'H','CAC' => 'H',
			'CAA' => 'Q','CAG' => 'Q',
			'CGT' => 'R','CGC' => 'R','CGA' => 'R','CGG' => 'R','AGA' => 'R','AGG' => 'R',
			'ATT' => 'I','ATC' => 'I','ATA' => 'I',
			'ATG' => 'M',
			'ACT' => 'T','ACC' => 'T','ACA' => 'T','ACG' => 'T',
			'AAT' => 'N','AAC' => 'N',
			'AAA' => 'K','AAG' => 'K',
			'GTT' => 'V','GTC' => 'V','GTA' => 'V','GTG' => 'V',
			'GCT' => 'A','GCC' => 'A','GCA' => 'A','GCG' => 'A',
			'GAT' => 'D','GAC' => 'D',
			'GAA' => 'E','GAG' => 'E',
			'GGT' => 'G','GGC' => 'G','GGA' => 'G','GGG' => 'G'			
	);
	
}

function microtime_float(){
	list($useg, $seg) = explode(" ", microtime());
	return ((float)$useg + (float)$seg);
}

function graphStream($selectedReferenceName, $secuenceChanges){
$fileStream="
{
  \"nodes\":[
    {\"name\":\"".$selectedReferenceName."\",\"group\":1},
    ";
$countTotal=0;
for($i=0; $i<count($secuenceChanges); $i++){
	$group=$i+2;
	for($j=1; $j<count($secuenceChanges[$i]); $j++){
		$pos=$countTotal+1;
		$fileStream.="{\"name\":\"".$secuenceChanges[$i][$j][0]." (".$secuenceChanges[$i][$j][1]."). ".$secuenceChanges[$i][$j][2]."\",\"group\":".$group."},
		";
		$nodes[$countTotal][0]=$group;
		$nodes[$countTotal][1]=$secuenceChanges[$i][$j][1];
		$countTotal++;
	}
}
$lastIndexComma=strrpos($fileStream, ",", -1);
$fileStream=substr($fileStream, 0, $lastIndexComma);
$fileStream.="
  ],
  \"links\":[
  ";  
for($i=0; $i<count($nodes); $i++){
	$target=$i+1;
	$value=$nodes[$i][1]+1;
	$fileStream.="{\"source\":0,\"target\":".$target.",\"value\":". $value."},
	";
}

for($i=0; $i<count($nodes)-1; $i++){
	for($j=$i+1; $j<count($nodes); $j++){
		if($nodes[$i][0] == $nodes[$j][0] && $nodes[$i][1] == $nodes[$j][1]){
			$source=$i+1;
			$target=$j+1;
			$value=$nodes[$i][1]+1;
			$fileStream.="{\"source\":".$source.",\"target\":".$target.",\"value\":". $value."},
			";			
		}
	}
}
$lastIndexComma=strrpos($fileStream, ",", -1);
$fileStream=substr($fileStream, 0, $lastIndexComma);
$fileStream.="
  ]
}";	
return $fileStream;
}

?>