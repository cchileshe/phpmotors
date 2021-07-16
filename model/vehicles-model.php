<?php

 //===========================================
   //         Check if class already exist
   //===========================================

function checkClassification($classificationName){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'SELECT * FROM carclassification WHERE classificationName = (:classificationName);';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $exist = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $exist;
}

   //===========================================
   //         register car classifications
   //===========================================

function regClass($classificationName){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO carclassification (classificationName)
        VALUES (:classificationName)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is

    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);

    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
   }



//======================================================
//===================== ADD VEHICLE ====================
//======================================================

function regVehicle($classificationId, $invMake, $invModel, $invDescription,
 $invImage,$invThumbnail, $invPrice, $invStock, $invColor){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO inventory 
    (invMake,invModel,invDescription,invImage, invThumbnail, 
    invPrice, invColor, invStock, classificationId)
    VALUES (:invMake, :invModel, :invDescription, :invImage, 
    :invThumbnail, :invPrice, :invColor, :invStock, 
    :classificationId)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
   }

//=================================================
//====== Get vehicles by classificationId =========
//=================================================

function getInventoryByClassification($classificationId){ 
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $inventory; 
   }

//=================================================
//======= Get vehicle information by invId ========
//=================================================

function getInvItemInfo($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
   }
   


//=================================================
//============== UPDATE VEHICLE  ==================
//=================================================

   // Update a vehicle
   function updateVehicle($classificationId,$invMake, $invModel, $invDescription, $invImage,  $invThumbnail, $invPrice, $invStock, $invColor,  $invId) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE inventory SET 
    invMake = :invMake, 
    invModel = :invModel, 
    invDescription = :invDescription, 
    invImage = :invImage, 
    invThumbnail = :invThumbnail,
    invPrice = :invPrice,
    invStock = :invStock, 
    invColor = :invColor, 
    classificationId = :classificationId 
    WHERE invId = :invId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
  }






//=================================================
//============== DELETE VEHICLE  ==================
//=================================================
function vehicleDelete($invId){
  $db = phpmotorsConnect();

  //this creates placeholders that the bindValue replaces with actual data
  $sql = 'DELETE FROM inventory WHERE invId = :invId';

  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);

  //this runs the statements above and inserts the data into the database
  $stmt->execute();

  //this checks to see how many rows were added as a result of the above statements
  $rowsChanged = $stmt->rowCount();

  //this closes the interaction between the function and the database server
  $stmt->closeCursor();

  //This sends the results from the rowCount above to the controller (used in showing a success message I assume)
  return $rowsChanged;
}

//=================================================
//==== gets list of vehicles by classification ====
//=================================================
function getVehiclesByClassification($classificationName){
   $db = phpmotorsConnect();
   $sql = 'SELECT * FROM inventory WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)';
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
   $stmt->execute();
   $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
   $stmt->closeCursor();
   return $vehicles;
  }

  //============================================================================
//========================= display vehicles in unordered list ===============
//============================================================================


function buildVehiclesDisplay($vehicles){
   $dv = '<ul id="vehicle-display">';
   foreach ($vehicles as $vehicle) {
    $dv .= '<li>';
    $dv .= "<a class='vehicle-link-container' href='/phpmotors/vehicles?action=vehicle-details&invId=$vehicle[invId]' title='View Vehicle'>"."\n";
    $dv .= '<div class="vehicle-image-container">'."\n";
    $dv .= "<img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
    $dv .= '</div><!-- end vehicle-image-container -->'."\n";
    $dv .= '<hr>';
    $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
   $dv .= '<span class="vehicle-details-price">' .  formatCurrencyUSD($vehicle['invPrice']) . '</span>';
    $dv .= '</a>'."\n";
    $dv .= '</li>';

   }
   $dv .= '</ul>';
   return $dv;
  }

//============================================================================
//========================= display single vehicle details ===================
//============================================================================

function buildVehicleDisplay($vehicle){


    $dv = '<div id="vehicle-details-container">'."\n";
    $dv .= '<div id="vehicle-details-content-left">'."\n";

    $dv .= "<h1>$vehicle[invMake] $vehicle[invModel]</h1>";
    $dv .= '<h2 class="vehicle-details-price">Price: ' . formatCurrencyUSD($vehicle['invPrice']) . '</h2>';
    
    $dv .= "<h2>$vehicle[invMake] $vehicle[invModel] Details</h2>";
    $dv .= "<h3>Description</h3>
    <p  class='vehicle-details-description'>$vehicle[invDescription]</p>";
    $dv .= "<h3>Colors </h3><p id='vehicle-color'>$vehicle[invColor]</p>";
    $dv .= "<h3>Stock</h3><p id='vehicle-qty-in-stock'>$vehicle[invStock]</p>";
    $dv .= '</div>'."\n";
    $dv .= "<div id='vehicle-details-content-right'>"."\n";
    $dv .= "<img class='vehicle-details-image' src='$vehicle[invImage]' alt='An image showing PHPMotors $vehicle[invMake] $vehicle[invModel]'>"."\n";
    
    $dv .= '</div>'."\n";
    $dv .= '</div>'."\n";
    return $dv;
   }


  function formatCurrencyUSD($price) {
   $formattedCurrency = number_format($price, 0, '.', ',');
   $formattedCurrency = '$' . $formattedCurrency;
   return $formattedCurrency;
}

//============================================================================
//============== Get information for all vehicles ============================
//============================================================================

function getVehicles(){
	$db = phpmotorsConnect();
	$sql = 'SELECT invId, invMake, invModel FROM inventory';
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $invInfo;
}

//==============================================================================
//=================== return all thumbnails matching a product id ==============
//==============================================================================

function getProductThumbnails($invId) {
   $db = phpmotorsConnect();
   $sql = 'SELECT * FROM images WHERE invId = :invId ORDER BY imgName';
   $stmt = $db->prepare($sql);
   $stmt->execute();
   $productThumbnails = $stmt->fetchAll(PDO::FETCH_ASSOC);
   $stmt->closeCursor();
   return $productThumbnails;
 }
 
 function getAllProductThumbnails($invId) {
     $db = phpmotorsConnect();
     $sql = 'SELECT * FROM images WHERE imgName LIKE "%-tn%" AND invId = :invId';
     $stmt = $db->prepare($sql);
     $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
     $stmt->execute();
     $productThumbnails = $stmt->fetchAll(PDO::FETCH_NAMED);
     $stmt->closeCursor();
     return $productThumbnails;
   }
   
?>