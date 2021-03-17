<?php include_once 'common-top.php'; ?>

<h1>Login</h1>

<form action="login-user.php" method="POST">

    <label for="username">Username</label>
    <input name="username" type="text" required>

    <label for="password">Password</label>
    <input name="password" type="password" required>

    <input type="submit" value="Login">

</form>