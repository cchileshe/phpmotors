<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/library/functions.php'; 

if(!$_SESSION['loggedin']){
  header('Location: /phpmotors/');
}

if(isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
}

$clientFirstname = $_SESSION['clientData']['clientFirstname'];
$clientLastname = $_SESSION['clientData']['clientLastname'];
$clientEmail = $_SESSION['clientData']['clientEmail'];
$clientLevel = $_SESSION['clientData']['clientLevel'];

$pageTitle = 'My Phpmotors Account';
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
<div id="container" class="padding">


  <h1><?php echo "Welcome $clientFirstname $clientLastname";?></h1>
  <?php if (isset($message)) {echo $message;} ?>


  <ul>
          <li> <strong>Firstname:</strong>  <?php echo $clientFirstname ?></li>
          <li> <strong>Lastname:</strong>  <?php echo $clientLastname; ?></li>
          <li> <strong>Email:</strong>  <?php echo $clientEmail; ?></li>
            
        </ul>
  

<h2>Update Account </h2>
<a class="inline-link-group" href="/phpmotors/accounts/index.php?action=update">Update Account Information</a>


<?php
     if($clientLevel > 1){
       echo '<hr />
             <h2>Admin Tools</h2>
             <p>To add, edit and delete vehicles, use the link below.</p>
             <p><a class="" href="/phpmotors/vehicles/">Manage Inventory</a></p>';
     }
   
   ?>

<hr/>
  <h2>Manage Your Reviews</h2>
  <?php
    if (isset($reviewList)) {
      echo $reviewList;
    } else {
      echo "You have <strong>not</strong> written any reviews yet. When you do, they'll show up right here.";
    }
  
  
?>



<?php require_once '../snippets/footer.php'; ?>

</div><!-- end container -->
</body>
</html>
<?php unset($_SESSION['message']); ?>