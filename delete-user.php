<?php

include_once 'common-top.php';

echo '<h1>Deleting User Account...</h1>';

// Validate user data ----------------------------------------------------
if( !isset( $_POST['username'] ) || empty( $_POST['username'] ) ) exit( 'No username provided' );

// Don't allow access here if not an admin
if( $_POST['username'] != $_SESSION['username'] && !isAdmin() ) {
    header( 'location: index.php' );
}

// Connect to DB server --------------------------------------------------
$link = connectToDB();
if( $link->connect_error ) exit( '<p class="error">Error connecting to the database: '.$link->connect_error.'</p>' );

// Setup the DB query and prepare to run it on the server
$sql = 'DELETE FROM users 
        WHERE username = ?';

$query = $link->prepare( $sql );
if( !$query ) exit( '<p class="error">Error with the database query: '.$link->error.'</p>' );

// Add in our data values to the query
$query->bind_param( 's', $_POST['username'] );

// Run the DB query on the server
$query->execute();
if( $query->error ) exit( '<p class="error">Error running the database query: '.$query->error.'</p>' );

// Tidy up afterwards
$query->close();
$link->close();

// Are we deleting our account?
if( $_POST['username'] == $_SESSION['username'] ) {
    session_destroy();
}

// Back to the home page
header( 'location: index.php' );


?>