<?php 

include_once 'common-top.php'; 
include_once 'common-functions.php'; 

echo '<section id="welcome">';

if( isLoggedIn() ) {
    echo '<h1>Welcome, '.$_SESSION['forename'].'!</h1>';
    // echo '<img src="/avatar/'.$_SESSION['username'].'" alt="icon">';
}
else {
    echo '<h1>Welcome!</h1>';
}

echo '</section>';

?>



