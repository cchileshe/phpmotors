<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
   }
?>  
<!DOCTYPE html>
<html lang="en-US"> 
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php'; 
 require_once $_SERVER['DOCUMENT_ROOT']."/phpmotors/snippets/nav.php"; 
 ?>
 
 <div id="container" class='padding'>
<h1>Welcome <?php echo "$clientFirstname $clientLastname";?></h1>
<h2 >What Would You like to do</h2>
<p><a href="/phpmotors/accounts/">&#8592; Back to account</a></p>


<ul>
    <li> <a href="/phpmotors/vehicles/index.php?action=newClassification">Add Classification</a> </li>
    <li><a href="/phpmotors/vehicles/index.php?action=newVehicle">Add Vehicle</a> </li>

</ul>
<br>

<?php
if (isset($message)) { 
 echo $message; 
} 
if (isset($classificationList)) { 
 echo '<h2>Vehicles By Classification</h2>'; 
 echo '<p>Choose a classification to see those vehicles</p>'; 
 echo $classificationList; 
}
?>
</div>
<noscript>
<p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
</noscript>
<table id="inventoryDisplay"></table>
<hr>
</main>
<!-- <input type="hidden" name="action" value="regClass"> -->

<!-- footer -->
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>


<script src="/phpmotors/js/inventory.js"> </script>   
</div>

<?php require_once '../snippets/footer.php'; ?>



</body>
</html>
<?php unset($_SESSION['message']); ?>