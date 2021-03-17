<?php include_once 'common-top.php'; ?>

<h1>Delete Account</h1>

<?php
// Validate user data ----------------------------------------------------
if( !isset( $_GET['username'] ) || empty( $_GET['username'] ) ) {
    $username = $_SESSION['username'];
}
else {
    $username = $_GET['username'];
}

// Don't allow access here if not an admin
if( $username != $_SESSION['username'] && !isAdmin() ) {
    header( 'location: index.php' );
}

echo '<h2>Are you sure you want to delete account <strong>'.$username.'</strong>?</h2>';

// Connect to DB server --------------------------------------------------
$link = connectToDB();
if( $link->connect_error ) exit( '<p class="error">Error connecting to the database: '.$link->connect_error.'</p>' );

// Setup the DB query and prepare to run it on the server
$sql = 'SELECT forename
          FROM users
         WHERE username = ?';

$query = $link->prepare( $sql );
if( !$query ) exit( '<p class="error">Error with the database query: '.$link->error.'</p>' );

// Add in our data values to the query
$query->bind_param( 's', $username );

// Run the DB query on the server
$query->execute();
if( $query->error ) exit( '<p class="error">Error running the database query: '.$query->error.'</p>' );

// Obtain details of the query result
$result = $query->get_result();

// Did we get a record for the given username?
if( $result->num_rows != 1 ) {
    // No, so unknown user
    echo '<p>No account with the username <strong>'.$username.'</strong> exists';
}
else {
    // Retrieve the record from the server
    $record = $result->fetch_assoc();
?>

    <form action="delete-user.php" method="POST">
        <input name="username" type="hidden" value="<?= $username ?>">
        <input class="warning" type="submit" value="Yes, DELETE account">
    </form>

    <form action="index.php" method="POST">
        <input type="submit" value="No, keep account">
    </form>

<?php

}

// Tidy up afterwards
$result->close();
$query->close();
$link->close();

?>

