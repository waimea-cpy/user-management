<?php

include_once 'common-top.php';

echo '<h1>All Users</h1>';

// Connect to DB server --------------------------------------------------
$link = connectToDB();
if( $link->connect_error ) exit( '<p class="error">Error connecting to the database: '.$link->connect_error.'</p>' );

// Setup the DB query and prepare to run it on the server
$sql = 'SELECT username, forename, surname, email, admin
        FROM users 
        ORDER BY admin DESC, surname ASC, forename ASC';

$query = $link->prepare( $sql );
if( !$query ) exit( '<p class="error">Error with the database query: '.$link->error.'</p>' );

// Run the DB query on the server
$query->execute();
if( $query->error ) exit( '<p class="error">Error running the database query: '.$query->error.'</p>' );

// Obtain details of the query result
$result = $query->get_result();

// Did we get any user records?
if( $result->num_rows == 0 ) exit( '<p class="error">No user accounts on system!</p>' );

echo '<table>
        <tr>
            <th>Username</th>
            <th>Forename</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Admin</th>
            <th class="blank"></th>
        </tr>';

while( $record = $result->fetch_assoc() ) {
    echo '<tr>';
    echo   '<td>'.$record['username'].'</td>';
    echo   '<td>'.$record['forename'].'</td>';
    echo   '<td>'.$record['surname'].'</td>';
    echo   '<td>'.$record['email'].'</td>';
    echo   '<td>'.($record['admin'] ? 'Yes' : '').'</td>';
    echo   '<td class="actions">
                <a href="form-edit-user.php?username='.$record['username'].'">&#x270E</a> 
                <a href="form-delete-user.php?username='.$record['username'].'" class="warning">&#8861;</a>
            </td>';
    echo '</tr>';
}

echo '</table>';

// Tidy up afterwards
$result->close();
$query->close();
$link->close();

?>