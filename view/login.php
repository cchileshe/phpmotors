<!doctype html>
<html lang="en-us">
<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php';
 require_once $_SERVER['DOCUMENT_ROOT']."/phpmotors/snippets/nav.php"; 
 $pageTitle = 'PHPMotors - Login';
?>

<div class="container">
<h1>PHP Motors Login</h1>
<?php
if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
 }
?>


  <form action="/phpmotors/accounts/index.php" method="POST" >
    <div class="row">
      <div class="col-25">
        <label for="clientEmail">Email</label>
      </div>
      <div class="col-75">
        <input 
        <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?>
        type="text" 
        id="clientEmail" 
        name="clientEmail" 
        placeholder="Your email.." 
        required>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="clientPassword">Password</label>
      </div>
      <div class="col-75">
      <span>Password should at least be 8 Characters and contain at least 1 number, 1 capital letter and 1 special character</span>
      <input 
      type="password" 
      id="clientPassword" 
      name="clientPassword" 
      placeholder="Your password.." 
      required 
      pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
      </div>
    </div>
    <div class="row">
      <input type="submit" value="Submit" name="login">
      <input type="hidden" name="action" value="login-page">
    </div>
    <div class="row">
      <a href="/phpmotors/accounts/index.php?action=signUp">Sign Up</a>
    </div>

</form>
  
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
    
</body>
</html>