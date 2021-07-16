<?php 

session_start();

//============================
// VEHICLES CONTROLLER
//============================
// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/vehicles-model.php';
// Get the functions model
require_once '../model/uploads-model.php';

require_once '../library/functions.php';
// Get the reviews model
require_once '../model/reviews-model.php';


$pageTitle = 'PHPMotors Main Vehicles';
// Get the array of classifications

$classifications = getClassifications();

//this is for the dynamic navigation
$navList = dynamicNav();

//=================================
// ADD CLASSIFICATION CONTROLLER
//=================================

$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }


 switch ($action){

  // add a new classifcation defualt
  case 'newClassification':
    include ('../view/add-classification.php');
    break;


case 'addClassification':
  $classificationName = filter_input(INPUT_POST, 'classificationName' , FILTER_SANITIZE_STRING);

// Check for missing data
if(empty($classificationName)){
  $message = '<p class="error">Please provide information for all empty form fields.</p>';
  include '../view/add-classification.php';
  exit; 
 }
 $checkClass = checkClassification($classificationName);

  // Check and report the result
if($checkClass == 1){
    $message = "<p id=\"warning\">Sorry! '$classificationName' classification already exists. Please enter another classification name.</p>";
    include '../view/add-classification.php';
    exit;
  }else{
    $regOutcome = regClass($classificationName);
    $checkClass = 0;
    if($regOutcome == 1){
      header ('Location: /phpmotors/vehicles/');
      exit;
    }else{
      $message = "<p id=\"warning\">Sorry the registration failed. Please try again.</p>";
      include '../view/add-classification.php';
      exit;
    }

  }
break;


//==============================
 // ADD VEHICLES CONTROLLER
//==============================

case 'newVehicle':
  include ('../view/add-vehicle.php');
  break;

 case 'addVehicle':
  $classificationId = filter_input(INPUT_POST, 'classificationId',FILTER_SANITIZE_NUMBER_INT);
  $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
   $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
   $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
   $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
   $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
   $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);//decimal(10,2)
   $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
   $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_STRING);
   



// Check for missing data
if(empty($invMake) || empty($invModel) || empty($invDescription) || empty($invPrice) || empty($invStock) ||  empty($invColor)){
  $message = '<p class="error">Please provide information for all empty form fields.</p>';
  include '../view/add-vehicle.php';
  exit; 
}


 // Send the data to the model
 $vehicleOutcome = regVehicle($classificationId, $invMake, $invModel, $invDescription, $invImage,$invThumbnail, $invPrice, $invStock, $invColor);

// Check and report the result

if ($vehicleOutcome === 1){
  $message = "<p class='error'>$invMake has been created!</p>";
  include '../view/add-vehicle.php';
  exit;
} else {
  $message = '<p class="error">Oops, new inventory not created. Please try again.</p>';
  include '../view/add-vehicle.php';
  exit;
}
break;


/* ==============================================
====== Get vehicles by classificationId ========= 
=== Used for starting Update & Delete process ===
================================================= */ 
case 'getInventoryItems': 
  // Get the classificationId 
  $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
  // Fetch the vehicles by classificationId from the DB 
  $inventoryArray = getInventoryByClassification($classificationId); 
  // Convert the array to a JSON object and send it back 
  echo json_encode($inventoryArray); 
  break;

// ===========================
// ===== UPDATE VEHICLE ======
//============================

case 'mod':
  $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
  $invInfo = getInvItemInfo($invId);
  if(count($invInfo)<  1){
   $message = 'Sorry, no vehicle information could be found.';
  }
  
  include '../view/vehicle-update.php';

  exit;
break;

case 'updateVehicle':

    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
    $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
     $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
     $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
     $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
     $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
     $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);//decimal(10,2)
     $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_STRING);
     $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
     $classificationId = filter_input(INPUT_POST, 'classificationId',FILTER_SANITIZE_NUMBER_INT);
     
  
    if (empty($invMake) || empty($invModel) || empty($invDescription) 
    || empty($invPrice) || empty($invStock) ||  empty($invColor)){
      $message = '<p class="error">All fields are required.</p>';
      include '../view/vehicle-update.php';
      exit;
    }
   
    
    //send the data to the model
    $updateResult = updateVehicle($classificationId,$invMake, $invModel, $invDescription, $invImage,  $invThumbnail, $invPrice, $invStock, $invColor,  $invId);
    if ($updateResult) {
      $message = "<p class='error'>Congratulations, the $invMake $invModel was successfully updated.</p>";
       $_SESSION['message'] = $message;
       header('location: /phpmotors/vehicles/');
       exit;
     } else {
       $message = "<p class='error'>Error. the $invMake $invModel was not updated.</p>";
        include '../view/vehicle-update.php';
        exit;
       }
     break;


// ===========================
// ===== DELETE VEHICLE ======
//============================
case 'del':
  $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
$invInfo = getInvItemInfo($invId);
if (count($invInfo) < 1) {
		$message = 'Sorry, no vehicle information could be found.';
	}
	include '../view/vehicle-delete.php';
	exit;
break;




case 'deleteVehicle':
  $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
  $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
  $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
  
  $deleteResult = vehicleDelete($invId);

//check and report the result
  if ($deleteResult) {
    $message = "<p class='error'>Congratulations the, $invMake $invModel was successfully deleted.</p>";
    $_SESSION['message'] = $message;
    header('location: /phpmotors/vehicles/');
    exit;
  } else {
    $message = "<p class='error'>Error: $invMake $invModel was not
  deleted.</p>";
    $_SESSION['message'] = $message;
    header('location: /phpmotors/vehicles/');
    exit;
  }
  break;

// ===========================
// ==VEHICLE CLASSIFICATION ==
//============================

case 'classification':
  $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
  $vehicles = getVehiclesByClassification($classificationName);
  
  if(!count($vehicles)){
    $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
  } else {
    $vehicleDisplay = buildVehiclesDisplay($vehicles);
  }
  include '../view/classification.php';
  break;

// ===========================
// ==== VEHICLE DETAILS =====
//============================
case 'vehicle-details':
   $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
    $vehicle = getInvItemInfo($invId);
    $productThumbnails = getAllProductThumbnails($invId);
    $itemReviews = getItemReviews($invId);
    if(!$vehicle) {
        $message = "<p class='errore'>Vehicle $invId could not be found.</p>";
        //include '../view/vehicle-details.php';
        //exit;
    } else {
        $vehicleDisplay = buildVehicleDisplay($vehicle);
        $thumbnailDisplay = buildThumbnailDisplay($productThumbnails);
        $reviewsDisplay = buildReviewDisplay($itemReviews);
        include '../view/vehicle-details.php';
    }
    break;

// ===========================
// ===== DEFUALT VEHICLE ======
//============================
  
 default:
 $classificationList = buildClassificationList($classifications);
 include ('../view/vehicle-main.php');
 break;
}


?>