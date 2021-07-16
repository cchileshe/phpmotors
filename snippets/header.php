
<?php
if(isset($_SESSION['clientData'])){
    $clientFirstname = $_SESSION['clientData']['clientFirstname'];
    $clientLastname = $_SESSION['clientData']['clientLastname'];
    
    } 
?>
<head >
    <title><?php echo "$pageTitle"; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/phpmotors/css/main.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hachi+Maru+Pop&family=Raleway:wght@200&display=swap" rel="stylesheet">


  </head>
<body>

<div id="main">
   <?php
    error_reporting(-1);
    ini_set("display_errors", 1);
    ?>
    <header>
        <div id="header" class="logoheader">
            <img alt="PHP Motors Logo" src="/phpmotors/images/site/logo.png">

            <?php
             if(isset($cookieFirstname)){
                echo "<span>Welcome $cookieFirstname hey</span>";
                } ?>
            <div class="account"> 
            
            <?php
            if(!isset($_SESSION['loggedin'])) {
                echo '<a href="/phpmotors/accounts/index.php?action=login" title="Manage your account here" class="account-link">My Account</a>';
            } else {
                echo "<a href='/phpmotors/accounts' title='Go to account management options' class='account-link'>Welcome $clientFirstname!</a> | 
                <a href='/phpmotors/accounts/index.php?action=logout' title='Logout of your account and return to the home page.' class='logout-link'>Logout</a>";
                }?>
        
        </div>
        </div> <!-- end logo header-->


</header> 