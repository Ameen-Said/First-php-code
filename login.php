<?php

require_once('pdo.php');

$empty_username = false;
$incorrect_pass = false;
$email_check = false;
$pass = "";
$username = "";

if (isset($_POST['who']) && isset($_POST['pass'])) {
    if ($_POST['who'] == "" || $_POST['pass'] == "") {
        $empty_username = true;
    } else {
        if (strpos($_POST['who'], "@")) {
            $username = $_POST['who'];
            $pass = $_POST['pass'];
        } else {
            $email_check = true;
        }
    }
}

$stored_hash = md5("php123"); // Replace this with the actual stored hash value

if ($pass !== "") {
    $hashedpass = md5($pass);
    if ($hashedpass === $stored_hash) {
        header("Location: autos.php?name=" . urlencode($_POST['who']));
        error_log("Login success " . $_POST['who']);
        exit();
    } else {
        $incorrect_pass = true;
        error_log("Login fail " . $_POST['who'] . " $hashedpass");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<title>Ameen Mohammad Said's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
if ($empty_username) {
    echo "<span style='color: red;'>" . htmlspecialchars("User name and password are required") . "</span>";
} elseif ($incorrect_pass) {
    echo "<span style='color: red;'>" . htmlspecialchars("Incorrect password") . "</span>";
} elseif ($email_check) {
    echo "<span style='color: red;'>" . htmlspecialchars("Email must have an at-sign (@)") . "</span>";
}
?>
    
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the three character name of the 
programming language used in this class (all lower case) 
followed by 123. -->
</p>
</div>
</body>
</html>
