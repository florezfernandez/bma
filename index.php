<?php 
require_once("business/Type.php");
require_once("business/Microorganism.php");
require_once("business/Gene.php");
require_once("business/Position.php");
require_once("business/Reference.php");
require_once("persistence/Conection.php");

ini_set('display_errors',"1");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" lang="<?php echo $lang ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>BMA</title>
		<link rel="icon" type="image/png" href="img/logo.png">
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/jquery-ui.min.css" rel="stylesheet" />
		<link href="css/bootstrap-multilevel-menu.css" rel="stylesheet" />
		<link href="css/bootstrap-tree.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">		
		<script src="js/jquery-1.11.1.min.js"></script>		
		<script src="js/jquery-ui.min.js"></script>		
		<script src="js/bootstrap.min.js"></script>		
		<script src="js/bootstrap-tree.js"></script>		
		<script type="text/javascript" charset="utf-8">
			$(function () { 
				$("[data-toggle='tooltip']").tooltip(); 
			});
		</script>
		</head>
<body>
<div align="center">
	<?php include("ui/menu.php"); ?>
	<?php include("ui/header.php"); ?>
</div>
<?php 
if(empty($_GET['pid'])){
	include('ui/home.php' );
}else{
	$pid=base64_decode($_GET["pid"]);
	$validPages = array(
		'ui/about.php',
		'ui/publications.php',
		'ui/contributors.php',
		'ui/viewGenes.php',
		'ui/viewPositions.php',
		'ui/selectPatients.php',
		'ui/validate.php',
		'ui/graphViewer.php',
		'ui/results.php',
		'ui/sendMail.php',
		'ui/screencast.php'
	);
	$validPage=false;
	for($i=0; $i<count($validPages); $i++){
		if($validPages[$i]==$pid){
			$validPage=true;
			break;
		}
	}
	if($validPage){
		include($pid);
	}else{
		include('ui/home.php');
	}
}
?>
<div class="text-center text-muted">ITI Research Group<br>&copy; <?php echo date("Y")?> All rights reserved</div>
</body>
