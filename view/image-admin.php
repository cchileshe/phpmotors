<!DOCTYPE html>
 <html lang="en-US">
 <?php 
 //============================
 // GET RELEVANT FILES 
 //============================
 $pageTitle = 'Image Management';
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/nav.php';

if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
   }
?>

<h1><?php echo $pageTitle; ?></h1>
<p><a href="/phpmotors/vehicles/">&#8592; Back to Vehicles</a></p>
  <p>Add or delete vehicle images below.</p>

<h2>Add New Vehicle Image</h2>
<?php

 if (isset($message)) {echo $message;} ?>

<form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data">

 <label for="invItem">Vehicle</label>
	<?php echo $prodSelect; ?>
	<fieldset>
		<label>Is this the main image for the vehicle?</label>
		<label for="priYes" class="pImage">Yes</label>
		<input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1">
		<label for="priNo" class="pImage">No</label>
		<input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0">
	</fieldset><br>
 <label>Upload Image:</label>
 <input type="file" name="file1"><br>
 <input type="submit" class="regbtn" value="Upload">
 <input type="hidden" name="action" value="upload">
 <br>
</form>

<hr/>

<h2>Existing Images</h2>
<p class="error">If deleting an image, delete the thumbnail too and vice versa.</p>

<?php if (isset($imageDisplay)) {echo $imageDisplay;} ?>
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/snippets/footer.php'; ?>
</div>


</body>
</html>
<?php unset($_SESSION['message']); ?>