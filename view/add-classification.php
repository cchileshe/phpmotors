<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
?>
<!doctype html>
<html lang="en-us">
<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php';
 require_once $_SERVER['DOCUMENT_ROOT']."/phpmotors/snippets/nav.php"; 
 $pageTitle = 'PHPMotors Add Classification';
?>

<div class="container">


  <form action="/phpmotors/vehicles/index.php" method="POST" >
  <h1>Add Car Classification</h1>
  <?php
if (isset($message)) {
 echo $message;
}
?>
    <div class="row">
      <div class="col-25">
        <label for="classificationName">Classification Name</label>
      </div>
      <div class="col-75">
        <input type="text" id="classificationName" name="classificationName" required >
      </div>
    </div>
    
    <div class="row">
      <input type="submit" value="Add Class" name="submit">
      <input type="hidden" name="action" value="addClassification">
    </div>
   

</form>
  
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
    
</body>
</html>