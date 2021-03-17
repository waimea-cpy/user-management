<?php
    include_once 'common-session.php';
    include_once 'common-functions.php';
?>

<!doctype html >

<html lang="en">

<head>
    <title>User Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <?php showDebugInfo() ?>
    
    <header>
        <h1>User Management</h1>

        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>

<?php
    if( isLoggedIn() ) {
        if( isAdmin() ) {
            echo '<li><a href="list-all-users.php">All Users</a></li>';
        }
        echo '<li><a href="form-edit-user.php">Edit Account</a></li>';
        echo '<li><a href="form-delete-user.php">Delete Account</a></li>';
        echo '<li><a href="logout-user.php">Logout</a></li>';
    }
    else {
        echo '<li><a href="form-new-user.php">Sign-Up</a></li>';
        echo '<li><a href="form-login.php">Login</a></li>';
    }
?>

            </ul>
        </nav>
    </header>

    <main>
    
