<!doctype html>
<html lang="en-us">
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php';
 require_once $_SERVER['DOCUMENT_ROOT']."/phpmotors/snippets/nav.php"; 
 $pageTitle = 'PHPMotors - Home';
?>
<div id="container" class='padding'>
    <section class="banner-box">
     
       <div class="action">
       <h1>Welcome to PHP Motors</h1>
       <h2> DMC Delorean</h2>
       
           <p>3 Cup Holders</p>
           <p>Superman Doors</p>
           <p>Fuzzy Dice</p>
      
         
        <button class="bannerButton">Own Today</button>
    </div> 
  
    </section>


    <section class="twoColumns">
    <div class="column1">
        <h2>Delorean Upgrades</h2>
        <div class="grid">
        <div class="items"> <img src="/phpmotors/images/upgrades/flux-cap.png" alt="Flux Capacitor"><br><a href="">Flux Capacitor</a></div>
        <div class="items"><img src="/phpmotors/images/upgrades/flame.jpg" alt="Flame Decals"><br><span> <a href="">Flame Decals</a></span></div>
        <div class="items"><img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="Bumper Stickers"><br><a href="">Bumper Stickers</a></div>
        <div class="items"><img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="Hub Caps"><br><a href="">Hub Caps</a></div>
    

</div>

        <div class="column2">
        <h2>DMC Delorean Reviews</h2>
        <ul class="reviews">
            <li>"So fast its almost like traveling in time." [4/5</li>
            <li>"Coolest ride on the road." [4/5]</li>
            <li>"I'm feeling Marty McFly!' [5/5]</li>
            <li>"The most futuristic ride of our day"[4.5/5]</li>
            <li>"80's livin and I love it!" [5/5]</li>
        </ul>
        </div>
         
    
      
    </section>

    </div>  
<?php require_once '../snippets/footer.php'; ?>
   
    
    
   

  
</body>
</html>