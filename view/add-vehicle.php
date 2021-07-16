
<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/library/functions.php'; 

if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}


 //====================================================
 //builds the dynamic drop down menu & makes it sticky
 //====================================================
$classificationList = "<select id='classificationId' name='classificationId'>";
$classificationList .= "<option selected disabled>Select a Class</option>";
foreach ($classifications as $classification) {
  $classificationList .= "<option id='$classification[classificationId]' value='$classification[classificationId]'";
  if(isset($classificationId)){
    if($classification['classificationId'] === $classificationId){
      $classificationList .= ' selected ';
    }
  }
  $classificationList .= ">$classification[classificationName]</option>";
}
$classificationyList .='</select>';
?>
<!DOCTYPE html>
<html lang="en-US">
<?php 
//============================
// GET RELEVANT FILES 
//============================
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php';
 require_once $_SERVER['DOCUMENT_ROOT']."/phpmotors/snippets/nav.php"; 
 $pageTitle = 'PHPMotors - Add Vehicle';

?> 

<div class="container">

  <form action="/phpmotors/vehicles/index.php" method="POST" >
  <h1>Add Vechile</h1>
  <?php
if (isset($message)) {
 echo $message;
}
?>


    <div class="row">
        <label for="invMake" >Car Make</label><br>
        <input type="text" id="invMake" name="invMake" placeholder=" Car Make" required><br>
    
        <label for="invModel" >Car Model</label><br>
        <input type="text" id="invModel" name="invModel" placeholder="Car Model" required>
        <br>
        <label for="invDescription" >Description</label> <br>
        
        <input type="text" name="invDescription" id="invDescription" placeholder="Enter description" required><br>
    </div>
   

    <div class="row">
      
        <label for="invImage">Image Path</label> <br>
        <input type="text" id="invImage" name="invImage" placeholder="../images/vehicles/no-image.png" value="../images/vehicles/no-image.png" required>
        <br>
        <label for="invThumbnail">Thumbnail Path</label><br>
        <input type="text" id="invThumbnail" name="invThumbnail" placeholder="../images/vehicles/no-image-tn.png" value="../images/vehicles/no-image-tn.png" required>
        <br>
        <label for="invPrice">Price</label> <br>
        <input type="text" id="invPrice" name="invPrice" required>
        <br>
        <label for="invStock"># Inventory Stock</label> <br>
        <input type="text" id="invStock" name="invStock" required>
    </div>


    <div class="row">
      <label for="invColor">Vehicle Color</label><br>
        <input type="text" id="invColor" name="invColor" required >
        <br>
        <label for="classificationName">Car Class</label> <br>
        <?php
        echo carClassList();
        ?>
      <br>
    
      <input type="submit" name="submit" id="regbtn" value="Add Vehicle"> <br>
      <input type="hidden" name="action" value="addVehicle">
    </div>
  </form>
<!-- FOOTER -->
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/snippets/footer.php'; ?>

</div>

 
</body>
</html>