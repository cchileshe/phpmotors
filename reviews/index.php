<?php
//============================
// REVIEWS CONTROLLER
//============================

session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model
require_once '../model/vehicles-model.php';
// Get the reviews model
require_once '../model/reviews-model.php';
// Get the functions 
require_once '../library/functions.php';
// Get the uploads model
require_once  '../model/uploads-model.php';

//==============================================================================

$pageTitle = 'PHPMotors Reviews';
// Get the array of classifications

$classifications = getClassifications();

//this is for the dynamic navigation
$navList = dynamicNav();

//==============================================================================


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
 $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {


    //============================
    // Add a new review
    //============================
    case 'addReview'://new-review'
      $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
      $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
      $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
  

// Check for missing data
      if (empty($reviewText) || empty($invId) || empty($clientId)) {
        $message = '<p class="form-error">All fields are required.</p>';
        include  '../view/vehicle-details.php';
        exit;
      }
      
      //Send data to the mode
      $reviewOutcome = newReview($reviewText, $invId, $clientId);
    
      //Check and report the result
      if ($reviewOutcome === 1) {
        $message = "<p class='error'>Thank you for your new review </p>";
        $vehicle = getInvItemInfo($invId);
        $productThumbnails = getAllProductThumbnails($invId);
        $vehicleDisplay = buildVehicleDisplay($vehicle);
        $thumbnailDisplay = buildThumbnailDisplay($productThumbnails);
        $itemReviews = getItemReviews($invId);
        
        $reviewsDisplay = buildReviewDisplay($itemReviews);

        include '../view/vehicle-details.php';
  
    } else {
      $reviewMessage = '<p class="error">Please try again</p>';
      include  '../view/vehicle-details.php';
      
    }
    break;
//=================================================
//========= Get review by reviewId ================ 
//=== Used for starting Update & Delete process ===
//=================================================

case 'editReview': 
    $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
    $reviewInfo = getReview($reviewId);

    include '../view/edit-review.php';
    break;


//============================
// Handle the review update.
//============================ 
case 'reviewUpdate':
    $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
    $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
    $reviewInfo = getReview($reviewId);

    if (empty($reviewText)) {
      $message = '<p class="message" id="redMessage">The review cannot be left blank. Please fill in the review before submitting.</p>';
      $_SESSION['message'] = $message;
      include '../view/edit-review.php';
      exit;
    }

    $updateResult = updateReview($reviewText, $reviewId);

    if (!$updateResult) {
      $message = '<p class="error" id="redMessage">Either no change was made or the review update failed. Please try again.</p>';
      $_SESSION['message'] = $message;
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/edit-review.php';
      exit;
    }
    $message = '<p class="error" id="greenMessage">Your review has been successfully updated.</p>';
    $_SESSION['message'] = $message;

    header('Location: /phpmotors/reviews/index.php');
    break;

//============================
// Deliver a view to confirm deletion of a review
//============================  
case 'deleteReview': 
  $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
    $reviewInfo = getReview($reviewId);
    if (count($reviewInfo) < 1) {
      $message = "<p class='form-error'>No reviews found</p>";
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/delete-review.php';
    exit;
    break;

//============================
// Handle the review deletion.
//============================  
case 'reviewDeleted':

  $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
  $deleteResult = deleteReview($reviewId);
 
  if($deleteResult) {
      $message = "<p class='error'>Review deleted!</p>";
      $_SESSION['message'] = $message;
      header ('location: /phpmotors/reviews/index.php');
      exit;
    } else {
      $message = "<p class='error'>Oops, review was not deleted. Try again.</p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/reviews/index.php');
      
    }
    break;

//============================
// DEFAULT  CASE
//============================  

default: 
  
 if(!isset($_SESSION['loggedin'])){
  include '../view/login.php';
  exit;
 }
 else{

  $clientId = $_SESSION['clientData']['clientId'];
   $reviews = getClientReviews($clientId);
   if (count($reviews) > 0) {
    $reviewList = buildReviewList($reviews);
   } else {
     $message = '<p class="error">You have not written any reviews.</p>';
   }
   
  include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
  exit;
 }


  break;
}
?>