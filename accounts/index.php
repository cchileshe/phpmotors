<?php 
//============================
// ACCOUNTS CONTROLLER
//============================

session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions model
require_once '../library/functions.php';
// Get the reviews model
require_once '../model/reviews-model.php';
//=============================================================

$pageTitle = 'PHPMotors - Accounts';
// Get the array of classifications
$classifications = getClassifications();
// Build a navigation bar using the $classifications array
$navLt = dynamicNav($classifications);

//===============================================================



$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }
 switch ($action){


//========================================
//=========== SIGN UP CASE ===============
//========================================

case 'register':
  $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
  $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
  $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
  $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
  $clientEmail = checkEmail($clientEmail);
  $checkPassword = checkPassword($clientPassword);

// Check for an existing email
 $existingEmail = checkExistingEmail($clientEmail);
 if ($existingEmail) {
   $message = '<p class="error">It looks like you already have an account. Do you want to login instead?</p>';
   include '../view/login.php';
   exit;
 }

 if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
   $message = '<p class="error">All fields are required.</p>';
   include '../view/registration.php';
   exit;
 }

 // Check for missing data
if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
  $message = '<p class="error">Please provide information for all empty form fields.</p>';
  include '../view/registration.php';
  exit; 
 }

 // Hash the checked password
 $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

 // Send the data to the model
 $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

// Check and report the result
if($regOutcome === 1){
  setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
  $_SESSION['message'] = "<p class='error'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
  header('Location: /phpmotors/accounts/?action=login');
  exit;
 } else {
  $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
  include $_SERVER['DOCUMENT_ROOT'] .'/phpmotors/view/registration.php';
  exit;
 }

    
break;

//====================================
//========== SIGN UP CASE ============
//====================================

   case 'signUp':
   $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
   $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
   $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
   $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
   $clientEmail = checkEmail($clientEmail);
   $checkPassword = checkPassword($clientPassword);

   include $_SERVER['DOCUMENT_ROOT'] .'/phpmotors/view/registration.php';
   exit;


//===============================
//======== LOG IN CASE ==========
//===============================
 case 'login-page':
  
  $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
  $clientEmail = checkEmail($clientEmail);
  $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
  $checkPassword = checkPassword($clientPassword);

  if (empty($clientEmail) || empty($checkPassword)) {
    $_SESSION['message']= '<p class="error">Please provide a valid email address and password.</p>';
    include $_SERVER['DOCUMENT_ROOT'] .'/phpmotors/view/login.php';
    exit;
  }

//when a valid password exists, proceed with login process
  $clientData = getClient($clientEmail);//query database for client email
  $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);//query database for client password

//error handling for password no match
  if (!$hashCheck){
    $_SESSION['message'] = '<p class="error">Please check your password and try again.</p>';
    include $_SERVER['DOCUMENT_ROOT'] .'/phpmotors/view/login.php';
    exit;
  }
 

  //login valid user
  $_SESSION['loggedin'] = TRUE;
  array_pop($clientData);
  $_SESSION['clientData'] = $clientData;
  setcookie('firstname', '', strtotime('-1 year'), '/');
  $clientId = $_SESSION['clientData']['clientId'];
 
  $reviews = getClientReviews($clientId);
  

  if (count($reviews) > 0) {
   $reviewList = buildReviewList($reviews);
  } else {
    $message = '<p class="error">You have not written any reviews.</p>';
  }

  include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
  exit;
  break;
 

 
//===============================
//======== LOG OUT CASE =========
//===============================
 case 'logout':
  session_destroy();
  header('Location: /phpmotors/');
  setcookie('firstname', '', strtotime('-1 year'), '/');
  exit;
  break;

//=================================
//======== LOGGED IN CASE =========
//=================================
  case 'loggedin':
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
    exit;
    break;

//=================================
//========= UPDATE CASE ===========
//=================================
  
      case 'update':
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
        exit;
        break;

//=================================
//====== UPDATE CLIENT INFO =======
//=================================

    case 'updateClientInfo':
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientEmail = checkEmail($clientEmail);
    
        // Check for an existing email in the database
        $existingEmail = checkExistingEmail($clientEmail);
    
        // Check for an existing email
          if ($existingEmail) {
            $message = '<p class="error">Looks like that email is already in use.</p>';
            include '../view/client-update.php';
            exit;
          }
      
    
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
          $message ='<p class="error">All fields are required.</p>';
          include '../view/client-update.php';
          exit;
        }
    
        //send the data to the model
        $updateResult = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);

        //check and report the result
        if ($updateResult === 1){
          $message = "<p class='error'>Your account has been updated!</p>";
          $_SESSION['message'] = $message;
          $_SESSION['clientData'] = getClient($clientEmail);
          header('location: /phpmotors/view/admin.php');
          exit;
        } else {
          $message = "<p class='error'> Please try again.</p>";
          header('location: /phpmotors/accounts/');
          exit;
        }
      
        break;

//=================================
//========= UPDATE PASSWORD =======
//=================================

case 'updateClientPassword':
  $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
  $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
  $checkPassword = checkPassword($clientPassword);

  if (empty($checkPassword)){
    $passwordMessage = "<p class='error'>Oops, it looks like you did not enter valid password.</p>";
    include $_SERVER['DOCUMENT_ROOT'] .'/phpmotors/view/client-update.php';
    exit;
  }

  // Hash the checked password
  $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

  // Send the data to the model
  $newPasswordOutcome = updatePassword($hashedPassword, $clientId);


  // checks the results of the update
  if($newPasswordOutcome === 1){ //should it be if($rowsChanged) === 1 ?
    $passwordMessage = "<p class='error'>Password updated!</p>";
    $_SESSION['message'] = $passwordMessage;
    header('location: /phpmotors/view/admin.php');
    exit;
  } else {
    $passwordMessage = "<p class='error'>Oops, something didn't work quite right. Please try again.</p>";
    $_SESSION['message'] = $passwordMessage;
    header('location: /phpmotors/accounts/');
    exit;
  }
  break;
 
//=================================
//======== DEFAULT VIEW =======
//=================================


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
