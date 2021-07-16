<?php

if ($_SESSION['clientData']['clientLevel'] < 1) {
       header('location: /phpmotors/');
       exit;
      }
//Sets the locale to US for all currency display
setlocale(LC_MONETARY, 'en_US');



$pageTitle = "Admin Tools - Update Review | PHPMotors";




$reviewInfo = getReview($reviewId);
?>

<!DOCTYPE html>
<html lang="en-US">
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php';
require_once $_SERVER['DOCUMENT_ROOT']."/phpmotors/snippets/nav.php";  ?>
<div id="container" class="padding">


  <h1>Update Your Review</h1>
  <?php
    if (isset($message)) {
      echo $message;
    }
    ?>


  <p><a href="/phpmotors/accounts/index.php">&#8592; Back</a></p>
  <form method="post" action="/phpmotors/reviews/index.php" class="stacked-form">
  <fieldset>

        <label for="reviewDate">Review Date:
          <input type="text" name="reviewDate" id="reviewDate" 
          <?php 
            if (isset($reviewInfo)) {
              echo "value='"
              . date('m/d/y', strtotime($reviewInfo['reviewDate']))
              . "'";
            } 
          ?> disabled>
        </label> 

        <label for="invModel">User Name:
          <input type="text" name="invModel" id="invModel" 
          <?php 
            if (isset($reviewInfo)) {
              echo "value='"
              . substr($reviewInfo['clientFirstname'], 0, 1)
              . substr($reviewInfo['clientLastname'], 0)
              . "'";
            } 
          ?> disabled>
        </label>
        <br>

        <label for="reviewText">Review:<br>
          <textarea name="reviewText" id="reviewText" ><?php if (isset($reviewInfo)) {echo $reviewInfo['reviewText'];}?></textarea>
        </label>

        <input type="submit" class="addButton" id="updateButton"  name="submit" value="Update Review">
        <input type="hidden" name="action" value="reviewUpdate">
        <input type="hidden" name="reviewId" value="<?php if(isset($reviewInfo['reviewId'])){ echo $reviewInfo['reviewId'];} elseif(isset($reviewId)){ echo $reviewId; } ?>">

      </fieldset>
  
 
</form>



<?php include_once $_SERVER['DOCUMENT_ROOT']."/phpmotors/snippets/footer.php"; ?>

</div><!-- end container -->
</body>
</html>