<?php

//Other variables and statements
if(isset($_SESSION['clientData'])){
  $clientFirstname = $_SESSION['clientData']['clientFirstname'];
  $clientLastname = $_SESSION['clientData']['clientLastname'];
  $clientEmail = $_SESSION['clientData']['clientEmail'];
  $clientId = $_SESSION['clientData']['clientId'];
  } 
?>

<!DOCTYPE html>
<html lang="en-US">
<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php';
 require_once $_SERVER['DOCUMENT_ROOT']."/phpmotors/snippets/nav.php"; 
 $pageTitle = $classificationName . ' Vehicles | Phpmotors';
?>
<body>
<div id="container">

<main class="padding">

  <h1><?php echo $classificationName; ?> Vehicles</h1>
  
  <?php if(isset($message)){ echo $message; } ?>
  <?php if(isset($vehicleDisplay)){ echo $vehicleDisplay; } ?>

</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>

</div><!-- end container -->