<!doctype html>
<html lang="en-us">
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php';
 require_once $_SERVER['DOCUMENT_ROOT']."/phpmotors/snippets/nav.php"; 
 $pageTitle = 'PHPMotors - Create Account';
?>


<div class="container">

<?php
if (isset($message)) {
 echo $message;
}

if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
 }
?>


<form action="/phpmotors/accounts/index.php" method="POST" >
    <div class="row"> 
      <label for="clientFirstname">First Name</label><br>
      <input <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?>
      
        type="text" 
        id="clientFirstname" 
        name="clientFirstname" 
        placeholder="Your First name.." 
        required>
    </div>

    <div class="row">
      <label for="clientLastname">Last Name</label><br>
      <input <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?>
        type="text" 
        id="clientLastname" 
        name="clientLastname" 
        placeholder="Your Last name.." 
        required>
    </div>

    <div class="row">
      <label for="clientEmail">Email</label><br>
      <input <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>
        type="text" 
        id="clientEmail" 
        name="clientEmail" 
        placeholder="Your email.."
        required>
    </div>

    <div class="row">
      <label for="clientPassword">Password</label><br>
      <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span> <br>
        <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
    </div>
    
    <div class="row">
      <input type="button" value="Show Password" onclick="showPassword()"  id="passBtn">
    </div>

    <div class="row">
      <input type="submit" name="submit" id="regbtn" value="Register">
      <input type="hidden" name="action" value="register">
    </div>

    <div class="row">
      <a href="/phpmotors/accounts/index.php?action=login">Sign In</a>
    </div>
  </form>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
<script>
function showPassword() {
  var x = document.getElementById("clientPassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>   
</body>
</html>