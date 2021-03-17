<?php

include_once 'common-top.php';

echo '<h1>Updating User Account...</h1>';

// Validate user data ----------------------------------------------------
if( !isset( $_POST['username'] ) || empty( $_POST['username'] ) ) exit( 'No username provided' );
if( !isset( $_POST['forename'] ) || empty( $_POST['forename'] ) ) exit( 'No forename provided' );
if( !isset( $_POST['surname'] )  || empty( $_POST['surname'] ) )  exit( 'No surname provided' );
if( !isset( $_POST['email'] ) )                                   exit( 'No email provided' );

// Don't allow access here if not an admin
if( $_POST['username'] != $_SESSION['username'] && !isAdmin() ) {
    header( 'location: index.php' );
}

// Are we updating the password (not if blank)
$updatePassword = false;
if( isset( $_POST['password'] ) && !empty( $_POST['password'] ) ) {
    $updatePassword = true;
    $hash = password_hash( $_POST['password'], PASSWORD_DEFAULT );
}

// Connect to DB server --------------------------------------------------
$link = connectToDB();
if( $link->connect_error ) exit( '<p class="error">Error connecting to the database: '.$link->connect_error.'</p>' );

// Setup the DB query and prepare to run it on the server
if( $updatePassword ) {
    $sql = 'UPDATE users 
            SET forename=?, surname=?, email=?, admin=?, hash=?
            WHERE username = ?';
}
else {
    $sql = 'UPDATE users 
            SET forename=?, surname=?, email=?, admin=?
            WHERE username = ?';
}

$query = $link->prepare( $sql );
if( !$query ) exit( '<p class="error">Error with the database query: '.$link->error.'</p>' );

// Add in our data values to the query
if( $updatePassword ) {
    $query->bind_param( 'sssiss', $_POST['forename'], 
                                  $_POST['surname'], 
                                  $_POST['email'], 
                                  $_POST['admin'], 
                                  $hash,
                                  $_POST['username'] );
}
else {
    $query->bind_param( 'sssis', $_POST['forename'], 
                                 $_POST['surname'], 
                                 $_POST['email'],
                                 $_POST['admin'], 
                                 $_POST['username'] );
} 
// Run the DB query on the server
$query->execute();
if( $query->error ) exit( '<p class="error">Error running the database query: '.$query->error.'</p>' );

// Tidy up afterwards
$query->close();
$link->close();

// Are we updating our account?
if( $_POST['username'] == $_SESSION['username'] ) {
    $_SESSION['forename'] = $_POST['forename'];
    $_SESSION['surname']  = $_POST['surname'];
    $_SESSION['email']    = $_POST['email'];
    $_SESSION['admin']    = $_POST['admin'];
}

// Back to the home page
header( 'location: index.php' );


?>