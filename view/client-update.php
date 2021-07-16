<?php
$pageTitle = 'Update Account';

if(!$_SESSION['loggedin']){
  header('Location: /phpmotors/accounts/');
}


$clientFirstname = $_SESSION['clientData']['clientFirstname'];
$clientLastname = $_SESSION['clientData']['clientLastname'];
$clientEmail = $_SESSION['clientData']['clientEmail'];
$clientPassword = $_SESSION['clientData']['clientPassword'];
$clientId = $_SESSION['clientData']['clientId'];
?>

<!DOCTYPE html>
<html lang="en-US">
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/nav.php'; 
?>

<div id="container">
    <main class='padding'>
    <h1> Welcome <?php echo "$clientFirstname $clientLastname";?></h1>
    <p><a href="/phpmotors/accounts/">&#8592; Back to account</a></p>
    <section>
    <h2>Update name &amp; email</h2>
      <?php if (isset($message)) {echo $message;} ?>


      
<form method="post" action="/phpmotors/accounts/"  >
      <div class="row"> 
        <label for="clientFirstname">First Name</label>
        <input <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?>
               id="clientFirstname"
               maxlength="15"
               name="clientFirstname"
               placeholder="Enter your first name"
               required
               type="text">
       </div>

    <div class="row">

        <label for="clientLastname">Last Name</label>
        <input <?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?>
               id="clientLastname"
               maxlength="25"
               name="clientLastname"
               placeholder="Enter your last name"
               required
               type="text">
        
       </div>

    <div class="row">
        <label for="clientEmail">Email</label>
        <input <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?>
               id="clientEmail"
               name="clientEmail"
               placeholder="Enter your email address"
               required
               type="text">
    </div>

    <div class="row">        

        <input class="button"
               id="updateClientInfoButton"
               name="submit"
               type="submit"
               value="Update my info" >

        <input name="clientId"
               type="hidden"
                value="<?php if(isset($clientData['clientId'])){ 
                       echo $clientData['clientId'];} 
                       elseif(isset($clientId)){ 
                              echo $clientId; } ?>">

        <input name="action"
               type="hidden"
               value="updateClientInfo" >
        </div>
   
      </form>
    </section>
    <hr />

<!-- PASSWORD FORM -->
    <section>
      <h2>Change password</h2>
      <?php if (isset($passwordMessage)) {echo $passwordMessage;} ?>
      
      <form method="post" action="/phpmotors/accounts/" class="stacked-form">
       
        <div class="row">
        <label for="clientPassword">New Password</label>
        <input id="clientPassword"
               name="clientPassword"
               pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
               placeholder="Enter a new password"
               required
               type="password"><br>
        <p class="error">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character.</p>
        
    </div>

        <div class="row">
        <input class="button"
               id="updateClientPasswordBtn"
               name="submit"
               type="submit"
               value="Update" >
            </div>
<div class="row">
    <p class="error">Note: This form will change your password.</p>

        <input name="clientId"
               type="hidden"
                value="<?php 
                if(isset($clientData['clientId'])){ 
                       echo $clientData['clientId'];} 
                       elseif(isset($clientId)){ 
                              echo $clientId; } ?>">

        <input name="action"
               type="hidden"
               value="updateClientPassword" >

        </div>
    </form>
</section>

    </main>

<!-- FOOTER -->
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/snippets/footer.php'; ?>
</div><!-- end container -->

</body>
</html>
