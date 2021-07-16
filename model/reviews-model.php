<?php

//============================
// Add a new review
//============================
function newReview($reviewText, $invId, $clientId) {
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO reviews (reviewText, invId, clientId) 
            VALUES (:reviewText, :invId, :clientId)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
  
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
  
    return $rowsChanged;
  }

//============================
// get reviews by invId
//============================
  function getItemReviews($invId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT reviews.*, clients.* FROM reviews 
            INNER JOIN clients 
            ON reviews.clientId = clients.clientId 
            WHERE invId = :invId 
            ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $itemReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

  return $itemReviews;
  }
  

//============================
// get specific review
//============================
function getReview($reviewId) {
    $db = phpmotorsConnect();
    $sql = ' SELECT * FROM reviews JOIN clients 
              WHERE reviewId = :reviewId 
              AND reviews.clientId = clients.clientId'; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
  
    $reviewInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
  
    return $reviewInfo;
  }

//============================
// update review
//============================
function updateReview($reviewText, $reviewId) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE reviews 
  SET reviewText = :reviewText 
  WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
  
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
  
    return $rowsChanged;
  }


//============================
// delete review
//============================
function deleteReview($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews 
            WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
  }
  
//============================
// Client review
//============================
function getClientReviews($clientId) {
  $db = phpmotorsConnect(); 
  $sql = 'SELECT * FROM reviews WHERE clientId = :clientId ORDER BY reviewDate DESC';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
  $stmt->execute();

  $clientReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();

  return $clientReviews; 
}


  ?>