<?php 

session_start();

//=============================================
//================relevant files===============
//=============================================

// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';
// Get the database connection file
require_once 'library/functions.php';


// Dynamic page title
$pageTitle = 'PHPMotors - Home';
// Get the array of classifications
$classifications = getClassifications();


//======================================================
//============= This is the main controller ============
//======================================================

$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }

 //======================================================
 
 //this looks for a cookie and if found says hello to the visitor by name
if(isset($_COOKIE['firstname'])){
  $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

//========================================================
 switch ($action){
 case 'template':
  include 'view/template.php';
  
  break;
 
 default:
  include 'view/home.php';
}


?>