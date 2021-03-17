<?php

include_once 'common-top.php';

echo '<h1>Creating User Account...</h1>';

// Validate user data ----------------------------------------------------
if( !isset( $_POST['username'] ) || empty( $_POST['username'] ) ) exit( 'No username provided' );
if( !isset( $_POST['forename'] ) || empty( $_POST['forename'] ) ) exit( 'No forename provided' );
if( !isset( $_POST['surname'] )  || empty( $_POST['surname'] ) )  exit( 'No surname provided' );
if( !isset( $_POST['email'] ) )                                   exit( 'No email provided' );
if( !isset( $_POST['password'] ) || empty( $_POST['password'] ) ) exit( 'No password provided' );

// Prepare data ----------------------------------------------------------
$hash = password_hash( $_POST['password'], PASSWORD_DEFAULT );

// Connect to DB server --------------------------------------------------
$link = connectToDB();
if( $link->connect_error ) exit( '<p class="error">Error connecting to the database: '.$link->connect_error.'</p>' );

// Setup the DB query and prepare to run it on the server
$sql = 'INSERT INTO users (username, forename, surname, email, hash) 
                    VALUES (      ?,        ?,       ?,     ?,    ?)';

$query = $link->prepare( $sql );
if( !$query ) exit( '<p class="error">Error with the database query: '.$link->error.'</p>' );

// Add in our data values to the query
$query->bind_param( 'sssss', $_POST['username'], 
                             $_POST['forename'], 
                             $_POST['surname'], 
                             $_POST['email'], 
                             $hash );

// Run the DB query on the server
$query->execute();
if( $query->error ) {
    // Check if duplicate primary key - i.e. user exists
    if( $query->errno == 1062 ) {
        echo '<p class="error">An account already exists for <strong>'.$_POST['username'].'</strong>. Try logging in instead.</p>';
    }
    else {
        exit( '<p class="error">Error running the database query: '.$query->error.'</p>' );
    }
}
else {
    // All good, so login and head back home
    $_SESSION['loggedIn'] = true;
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['forename'] = $_POST['forename'];
    $_SESSION['surname']  = $_POST['surname'];
    $_SESSION['email']    = $_POST['email'];
    $_SESSION['admin']    = false;


    // Back to the home page
    header( 'location: index.php' );
}

// Tidy up afterwards
$query->close();
$link->close();


?>