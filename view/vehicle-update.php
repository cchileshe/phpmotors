<?php 
if ($_SESSION['clientData']['clientLevel'] < 2) {
  header('location: /phpmotors/');
  exit;
 }
$pageTitle = "$invInfo[invMake] $invInfo[invModel] | PHP Motors";
$clientLevel = $_SESSION['clientData']['clientLevel'];


?>
<?php


 //====================================================
 //====== Build the classifications option list =======
 //====================================================

 $classificationList = '<select name="classificationId" id="classificationId">';
 $classificationList .= "<option>Choose a Car Classification</option>";
 foreach ($classifications as $classification) {
  $classificationList .= "<option value='$classification[classificationId]'";
  if(isset($classificationId)){
   if($classification['classificationId'] === $classificationId){
    $classificationList .= ' selected ';
   }
  } elseif(isset($invInfo['classificationId'])){
  if($classification['classificationId'] === $invInfo['classificationId']){
   $classificationList .= ' selected ';
  }
 }
 $classificationList .= ">$classification[classificationName]</option>";
 }
 $classificationList .= '</select>';
?>

<!DOCTYPE html>
<html lang="en-US">
<?php 
//============================
// GET RELEVANT FILES 
//============================
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php';
require_once $_SERVER['DOCUMENT_ROOT']."/phpmotors/snippets/nav.php"; 
?>

<h1><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	    echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
        elseif (isset($invMake) && isset($invModel)) { 

	    echo "Modify $invMake $invModel"; }?>Modify</h1>
  <p><a href="/phpmotors/accounts">&#8592; Back to account</a></p>

  <form action="/phpmotors/vehicles/index.php" method="POST" >

<?php
if (isset($message)) {
echo $message;
}
?>


  <div class="row">
      <label for="invMake" >Car Make</label><br>
      <input type="text" name="invMake" id="invMake" required <?php if(isset($invMake)){ echo "value='$invMake'"; } 
      elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>
      <br>
  
      <label for="invModel" >Car Model</label><br>
      <input type="text" name="invModel" id="invModel" required <?php if(isset($invModel)){ echo "value='$invModel'"; } 
      elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>>
      <br>
      <label for="invDescription" >Description</label> <br>
      
      <textarea name="invDescription" id="invDescription" required>
<?php if(isset($invDescription)){ echo $invDescription; } elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>
      <br>
  </div>
 

  <div class="row">
    
      <label for="invImage">Image Path</label> <br>
      <input type="text" id="invImage" name="invImage" placeholder="../images/vehicles/no-image.png" value="../images/vehicles/no-image.png" required 
      <?php if(isset($invImage)){ echo "value='$invImage'"; } 
      elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'"; }?>>
      <br>
      <label for="invThumbnail">Thumbnail Path</label><br>
      <input type="text" id="invThumbnail" name="invThumbnail" placeholder="../images/vehicles/no-image-tn.png" value="../images/vehicles/no-image-tn.png" required 
      <?php if(isset($invThumbnail)){ echo "value='$invThumbnail'"; } 
      elseif(isset($invInfo['invThumbnail'])) {echo "value='$invInfo[invThumbnail]'"; }?>>
      <br>
      <label for="invPrice">Price</label> <br>
      <input type="text" id="invPrice" name="invPrice" required 
      <?php if(isset($invPrice)){ echo "value='$invPrice'"; } 
      elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'"; }?>>
      <br>
      <label for="invStock">#Inventory Stock</label> <br>
      <input type="text" id="invStock" name="invStock" required 
      <?php if(isset($invStock)){ echo "value='$invStock'"; } 
      elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'"; }?>>
  </div>


  <div class="row">
    <label for="invColor">Vehicle Color</label><br>
      <input type="text" id="invColor" name="invColor" required <?php if(isset($invColor)){ echo "value='$invColor'"; } 
      elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'"; }?>>
      <br>
      <label for="classificationName">Car Class</label> <br>
    
      <?php
          if (isset($classificationList)) {
          echo $classificationList;
             }
        ?>
    <br>
  
    <input type="submit" id="regbtn" value="Update Vehicle"> <br>
    <input type="hidden" name="action" value="updateVehicle">
    <input type="hidden" name="invId" value="
      <?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} 
            elseif(isset($invId)){ echo $invId; } ?>
      ">
  </div>
</form>
</main>

<!-- FOOTER -->
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/snippets/footer.php'; ?>

</div>  
</body>
</html>