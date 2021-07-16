<?php

//Other variables and statements

if(isset($_SESSION['loggedin'])) {
  $clientFirstname = $_SESSION['clientData']['clientFirstname'];
  $clientLastname = $_SESSION['clientData']['clientLastname'];
  $clientEmail = $_SESSION['clientData']['clientEmail'];
  $clientPassword = $_SESSION['clientData']['clientPassword'];
  $clientId = $_SESSION['clientData']['clientId'];
  }

?>

<!DOCTYPE html>
<html lang="en-US">
<?php 
//============================
// GET RELEVANT FILES 
//============================
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php';
require_once $_SERVER['DOCUMENT_ROOT']."/phpmotors/snippets/nav.php"; 
$pageTitle = "$vehicle[invMake] $vehicle[invModel] | PHP Motors";
?>

<div id="container" class="padding">

<?php 
                if (isset($_SESSION['message'])) {
                    $message = $_SESSION['message'];
                }
                if (isset($message)) {
                    echo $message;
                }
                unset($_SESSION['message']);
                
                if(isset($vehicleDisplay)){
                    echo $vehicleDisplay;} 
                   
                    if(isset($thumbnailDisplay)){ 
                        echo $thumbnailDisplay; } 
                        ?>
<hr />

<?php
  if (isset($_SESSION['loggedin'])) {
    $first = substr($_SESSION['clientData']['clientFirstname'], 0, 1);
    $last = $_SESSION['clientData']['clientLastname'];
    $fullName = $first . $last;
    $sessionClientDataId = $_SESSION['clientData']['clientId'];

    if (isset($reviewMessage)) {
      echo $reviewMessage;
    }

    echo '<form action="/phpmotors/reviews/index.php" method="post" id="review-form">'."\n";
    echo "<label for='reviewText'>Review this product as $fullName</label>"."\n";
    echo '<br>'."\n";
    echo '<textarea cols="50" id="reviewText" name="reviewText" placeholder="Leave a vehicle review here" required rows="5"></textarea>'."\n";
    echo '<br>'."\n";
    echo '<input class="button" name="submit" type="submit" value="Submit Review">'."\n";
    echo "<input type='hidden' name='clientId' value='$sessionClientDataId'>"."\n";
    echo "<input type='hidden' name='invId' value='$invId'>"."\n";
    echo '<input type="hidden" name="action" value="addReview">'."\n";
    echo '</form>'."\n";
  } else {
    echo "<p><a href='/phpmotors/accounts/index.php?action=login'>Login here</a> to write a review for this vehicle."."\n";
  }

  echo '<br>';
  echo '<a id="bottom"></a>';
  echo '<br>';
  echo '<hr/>';
  echo '<br>';
  echo '<h2>Customer Reviews</h2>';
 
  if (count($itemReviews) > 0) {
    echo $reviewsDisplay;
  } else {
    echo '<p>This vehicle has not been reviewed yet.</p>'."\n";
  }
?>

                
        
</div>

<?php require_once '../snippets/footer.php'; ?>



</body>
</html>