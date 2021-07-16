<?php 
  if($_SESSION['clientData']['clientLevel'] < 2) {
    header('Location: /phpmotors/');
    exit;
  }
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/library/functions.php';
$pageTitle = "$invInfo[invMake] $invInfo[invModel] | PHP Motors";
$clientLevel = $_SESSION['clientData']['clientLevel'];


 //====================================================
 //====== Build the classifications option list =======
 //====================================================
 $classifList = "<select id='classificationId' name='classificationId'>";
 $classifList .= "<option selected disabled>Select a Class</option>";
 foreach ($classifications as $classification) {
   $classifList .= "<option  value='$classification[classificationId]'";
   if(isset($classificationId)){
     if($classification['classificationId'] === $classificationId){
       $classifList .= ' selected ';
     }
   }elseif(isset($invInfo['classificationId'])){
    if($classification['classificationId'] === $invInfo['classificationId']){
      $classifList .= ' selected ';
    }
  }
   $classifList .= ">$classification[classificationName]</option>";
 }
 $classifList .="</select>";


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
<div class="container">
<main class='padding'>
<h1>
    <?php 
    if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
        echo "Modify $invInfo[invMake] $invInfo[invModel]";
    }elseif(isset($invMake) && isset($invModel)) {
        echo "Modify$invMake $invModel"; 
    }
  ?>
  </h1>
  <p><a href="/phpmotors/accounts/">&#8592; Back to account</a></p>

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
      <?php if(isset($invDescription)){ echo "value='$invDescription'"; } 
      elseif(isset($invInfo['invDescription'])) {echo "value='$invInfo[invDescription]'"; }?>
      </textarea>
      <br>
  </div>
 

  <div class="row">
    
      <label for="invImage">Image Path</label> <br>
      <input type="text" id="invImage" name="invImage" placeholder="./images/vehicles/no-image.png" value="./images/vehicles/no-image.png" required 
      <?php if(isset($invImage)){ echo "value='$invImage'"; } 
      elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'"; }?>>
      <br>
      <label for="invThumbnail">Thumbnail Path</label><br>
      <input type="text" id="invThumbnail" name="invThumbnail" placeholder="./images/vehicles/no-image-tn.png" value="./images/vehicles/no-image-tn.png" required 
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
      echo $classifList;
      ?>
    <br>
  
    <input type="submit" id="regbtn" value="Delete Vehicle"> <br>
    <input type="hidden" name="action" value="deleteVehicle">
    <input type="hidden" name="invId" value="<?php if(isset($invId)){ echo "value='$invId'"; } 
      elseif(isset($invInfo['invId'])) {echo "value='$invInfo[invId]'"; }?>">
  </div>
</form>
</main>

<!-- FOOTER -->
<?php require_once $_SERVER['DOCUMENT_ROOT'].'../snippets/footer.php'; ?>

</div>


</script>   
</body>
</html>