
<?php

//============================================================================
//======================= validate email address =============================
//============================================================================
//
function checkEmail($clientEmail){
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
   }
 
   
//============================================================================
//=============== server side validates password inputs =================
// Check the password for a minimum of 8 characters,
 // at least one 1 capital letter, at least 1 number and
 // at least 1 special character
//============================================================================


 function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
    return preg_match($pattern, $clientPassword);
   }


//============================================================================
//========== dynamically build the car categories from the database ==========
//============================================================================


function carClassList(){
    //this runs the getClassifications function from the vehicles-model.php file
    $classifications = getClassifications();
  
    //this builds the dynamic list of classifications options found on /view/add-vehicle.php file
    $classificationList = "<select id='classificationId' name='classificationId'>";
    $classificationList .= "<option selected disabled>Select a category</option>";
    foreach ($classifications as $classification) {
      $classificationList .= "<option id='$classification[classificationId]' value='$classification[classificationId]'>$classification[classificationName]</option>";
    }
    $classificationList .='</select>';
    return $classificationList;
  }



//============================================================================
//==================== dynamically populate main navigation ==================
//============================================================================

function dynamicNav(){
    $classifications = getClassifications();
 // Build a navigation bar using the $classifications array
 $navList = "<ul id='menu'>";
 $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
 foreach ($classifications as $classification) {
  $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName="
  .urlencode($classification['classificationName']).
  "' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
 }
 $navList .= '</ul>';
 return $navList;
  }



//============================================================================
// ===============Build the classifications select list ======================
//============================================================================
function buildClassificationList($classifications){ 
  $classifications = getClassifications();
  $classificationList = '<select name="classificationId" id="classificationList">'; 
  $classificationList .= "<option>Choose a Classification</option>"; 
  foreach ($classifications as $classification) { 
   $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
  } 
  $classificationList .= '</select>'; 
  return $classificationList; 
 }

//============================================================================
// =============== Functions for working with images ======================
//============================================================================

// Adds "-tn" designation to file name
function makeThumbnailName($image) {
  $i = strrpos($image, '.');
  $image_name = substr($image, 0, $i);
  $ext = substr($image, $i);
  $image = $image_name . '-tn' . $ext;
  return $image;
 }
  
 // Build images display for image management view
function buildImageDisplay($imageArray) {
  $id = '<ul id="image-display">';
  foreach ($imageArray as $image) {
   $id .= '<li>';
   $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
   $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
   $id .= '</li>';
 }
  $id .= '</ul>';
  return $id;
 }

 // Build the vehicles select list
function buildVehiclesSelect($vehicles) {
  $prodList = '<select name="invId" id="invId">';
  $prodList .= "<option>Choose a Vehicle</option>";
  foreach ($vehicles as $vehicle) {
   $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
  }
  $prodList .= '</select>';
  return $prodList;
 }


// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
  // Gets the paths, full and local directory
  global $image_dir, $image_dir_path;
  if (isset($_FILES[$name])) {
   // Gets the actual file name
   $filename = $_FILES[$name]['name'];
   if (empty($filename)) {
    return;
   }
  // Get the file from the temp folder on the server
  $source = $_FILES[$name]['tmp_name'];
  // Sets the new path - images folder in this directory
  $target = $image_dir_path . '/' . $filename;
  // Moves the file to the target folder
  move_uploaded_file($source, $target);
  // Send file for further processing
  processImage($image_dir_path, $filename);
  // Sets the path for the image for Database storage
  $filepath = $image_dir . '/' . $filename;
  // Returns the path where the file is stored
  return $filepath;
  }
}


// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
  // Set up the variables
  $dir = $dir . '/';
 
  // Set up the image path
  $image_path = $dir . $filename;
 
  // Set up the thumbnail image path
  $image_path_tn = $dir.makeThumbnailName($filename);
 
  // Create a thumbnail image that's a maximum of 200 pixels square
  resizeImage($image_path, $image_path_tn, 200, 200);
 
  // Resize original to a maximum of 500 pixels square
  resizeImage($image_path, $image_path, 500, 500);
 }

 // Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
  // Get image type
  $image_info = getimagesize($old_image_path);
  $image_type = $image_info[2];
 
  // Set up the function names
  switch ($image_type) {
  case IMAGETYPE_JPEG:
   $image_from_file = 'imagecreatefromjpeg';
   $image_to_file = 'imagejpeg';
  break;
  case IMAGETYPE_GIF:
   $image_from_file = 'imagecreatefromgif';
   $image_to_file = 'imagegif';
  break;
  case IMAGETYPE_PNG:
   $image_from_file = 'imagecreatefrompng';
   $image_to_file = 'imagepng';
  break;
  default:
   return;
 } // ends the swith
// Get the old image and its height and width
$old_image = $image_from_file($old_image_path);
$old_width = imagesx($old_image);
$old_height = imagesy($old_image);

// Calculate height and width ratios
$width_ratio = $old_width / $max_width;
$height_ratio = $old_height / $max_height;

// If image is larger than specified ratio, create the new image
if ($width_ratio > 1 || $height_ratio > 1) {

 // Calculate height and width for the new image
 $ratio = max($width_ratio, $height_ratio);
 $new_height = round($old_height / $ratio);
 $new_width = round($old_width / $ratio);

 // Create the new image
 $new_image = imagecreatetruecolor($new_width, $new_height);

 // Set transparency according to image type
 if ($image_type == IMAGETYPE_GIF) {
  $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
  imagecolortransparent($new_image, $alpha);
 }

 if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
  imagealphablending($new_image, false);
  imagesavealpha($new_image, true);
 }

 // Copy old image to new image - this resizes the image
 $new_x = 0;
 $new_y = 0;
 $old_x = 0;
 $old_y = 0;
 imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

 // Write the new image to a new file
 $image_to_file($new_image, $new_image_path);
 // Free any memory associated with the new image
 imagedestroy($new_image);
 } else {// Write the old image to a new file
  $image_to_file($old_image, $new_image_path);
  }
  // Free any memory associated with the old image
  imagedestroy($old_image);
} // ends resizeImage function

//==================== Thumbnail Display =============================

function buildThumbnailDisplay($productThumbnails) {
  $id = '<div id="image-display-container">';
  $id .= '<h2 class="hidden-mobile">Thumbnails</h2>';
  $id .= '<ul id="image-display">';
  foreach ($productThumbnails as $image) {
  $id .= '<li>';
  $id .= "<img src='$image[imgPath]' title='$image[imgName] image on phpmotors.com' alt='$image[imgName] image on phpmotors.com'>";
  $id .= '</li>';
  }
  $id .= '</ul>';
  $id .= '</div>';
  return $id;
}

//==================== Review Display =============================

function  buildReviewDisplay($itemReviews) {
  $rd = '<ul id="vehicle-reviews-table">';
  foreach ($itemReviews as $review) {
    $date = date("F jS, Y", strtotime($review['reviewDate']));
    $firstName = substr($review['clientFirstname'], 0, 1);
    $lastName = $review['clientLastname'];
    $name = $firstName . $lastName;
    $reviewText = $review['reviewText'];
    $rd .= "<li class='review-list-item'><p class='meta-text'>$name on <strong>$date</strong><br></p> ";
    $rd .= "<span class='review-list-item-text'>$reviewText</span></li>";
  }
  $rd .= "</ul>";
  return $rd;
}

function buildReviewList($reviews){
  $reviewList = '<table id="your-product-reviews-table">';
  $reviewList .= '<thead>';
  $reviewList .= '<tr><th>Product Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>';
  $reviewList .= '</thead>';
  $reviewList .= '<tbody>';
  foreach ($reviews as $review) {
    $reviewList .= "<tr><td class='table-main-content-column'>$review[reviewText]</td>";
    $reviewList .= "<td class='table-action-button-column'><a href='../reviews/index.php?action=editReview&reviewId=$review[reviewId]' title='Edit review'>Edit</a></td>";
    $reviewList .="<td class='table-action-button-column'><a href='../reviews/index.php?action=deleteReview&reviewId=$review[reviewId]' title='Delete review'>Delete</a></td></tr>";
  }
  $reviewList .= '</tbody></table>';
  return $reviewList;
}



?>


 