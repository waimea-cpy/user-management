<?php include_once 'common-top.php'; ?>

<h1>Sign-Up</h1>

<form action="add-new-user.php" method="POST">

    <label for="username">Username</label>
    <input name="username" type="text" required>

    <label for="forename">Forename</label>
    <input name="forename" type="text" required>

    <label for="surname">Surname</label>
    <input name="surname" type="text" required>

    <label for="email">EMail</label>
    <input name="email" type="email">

    <label for="password">Password</label>
    <input name="password" type="password" required>

    <input type="submit" value="Create new account">

</form>