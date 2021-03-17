<?php

include_once 'common-top.php';

echo '<h1>Logging In...</h1>';

// Validate user data ----------------------------------------------------
if( !isset( $_POST['username'] ) || empty( $_POST['username'] ) ) exit( 'No username provided' );
if( !isset( $_POST['password'] ) || empty( $_POST['password'] ) ) exit( 'No password provided' );

// Connect to DB server --------------------------------------------------
$link = connectToDB();
if( $link->connect_error ) exit( '<p class="error">Error connecting to the database: '.$link->connect_error.'</p>' );

// Setup the DB query and prepare to run it on the server
$sql = 'SELECT forename, surname, email, hash, admin
          FROM users
         WHERE username = ?';

$query = $link->prepare( $sql );
if( !$query ) exit( '<p class="error">Error with the database query: '.$link->error.'</p>' );

// Add in our data values to the query
$query->bind_param( 's', $_POST['username'] );

// Run the DB query on the server
$query->execute();
if( $query->error ) exit( '<p class="error">Error running the database query: '.$query->error.'</p>' );

// Obtain details of the query result
$result = $query->get_result();

// Did we get a record for the given username?
if( $result->num_rows != 1 ) {
    // No, so unknown user
    echo '<p>No account with the username <strong>'.$_POST['username'].'</strong> exists';
    session_destroy();
}
else {
    // Retrieve the record from the server
    $record = $result->fetch_assoc();

    // Password correct
    if( password_verify( $_POST['password'], $record['hash'] ) ) {
        // Save to the session
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['forename'] = $record['forename'];
        $_SESSION['surname']  = $record['surname'];
        $_SESSION['email']    = $record['email'];
        $_SESSION['admin']    = $record['admin'];

        // Back to the home page
        header( 'location: index.php' );
    }
    else {
        echo '<p>Password incorrect for user <strong>'.$_POST['username'].'</strong>';
        session_destroy();
    }
}

// Tidy up afterwards
$result->close();
$query->close();
$link->close();

?>