<?php

require_once "config/config.php";

if (isset($_SESSION['id'])) { // Check if session is set , redirect to second page if it is
    header("Location: secondPage.php");
} else {

    if ($_POST) {
        if (@$_POST["login"]) { // Check if login is pressed
            if ($_POST["email"] && $_POST["pass"]) { //Check if both email and password are filled
                $checkQ = "SELECT email FROM users WHERE email='" . mysqli_real_escape_string($db, $_POST["email"]) . "'";
                $checkRes = $db->query($checkQ);
                if (!mysqli_num_rows($checkRes)) { //Check if email exists in database
                    $alert = '<div class="alert alert-danger my-2">User with this email is not registered!</div>';
                } else { // Log in
                    $checkS = "SELECT id,password FROM users WHERE email='" . mysqli_real_escape_string($db, $_POST["email"]) . "'";
                    $checkSRes = $db->query($checkS)->fetch_array();

                    if ($checkSRes["password"] == md5(md5($checkSRes["id"] - 1) . $_POST["pass"])) {

                        $_SESSION['id'] = $checkSRes['id'];
                        if (isset($_POST["stayLogged"])) { // Stay logged in check
                            setcookie("id", $checkSRes["id"], time() + 60 * 60 * 24);
                            header("Location: secondPage.php");
                        } else {
                            header("Location: secondPage.php");
                        }
                    } else { // Pass not correct
                        $alert = '<div class="alert alert-danger my-2">Your password is not correct!</div>';
                    }
                }
            } else {
                $alert = '<div class="alert alert-danger my-2">Please enter email/pass!</div>';
            }
        } else if (@$_POST["register"]) { // Check if register is pressed
            if ($_POST["email"] && $_POST["pass"]) { //Check if both email and password are filled
                $checkQ = "SELECT email FROM users WHERE email='" . mysqli_real_escape_string($db, $_POST["email"]) . "'";
                $checkRes = $db->query($checkQ);
                if (mysqli_num_rows($checkRes)) { // Check if email does not exist in database
                    $alert = '<div class="alert alert-danger my-2">User with this email is already registered!</div>';
                } else { // Add to database
                    $ss = 'SELECT MAX(id) FROM users';
                    $ssid = $db->query($ss)->fetch_array();
                    $insertQ = "INSERT INTO users (email,password) VALUES ('" . mysqli_real_escape_string($db, $_POST["email"]) . "','" . mysqli_real_escape_string($db, md5(md5($ssid[0]) . $_POST["pass"])) . "')";
                    $db->query($insertQ);
                    $alert = '<div class="alert alert-success my-2">You can login now!</div>';
                }
            } else {
                $alert = '<div class="alert alert-danger my-2">Please enter email/pass!</div>';
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.css" rel="stylesheet" />
    <title>Dairy</title>
</head>

<body>
    <main class="container">
        <h1 class="display-2 my-3">
            My diary
        </h1>
        <div class="login-block">
            <form method="post">
                <input type="email" class="form-control my-2" name="email" id="email" placeholder="Enter email">
                <input type="password" class="form-control my-2" name="pass" id="pass" placeholder="Enter password">
                <div class="row">

                    <button type="submit" class='btn btn-light my-1 mx-1 col col-lg-3' name='login' value="Submit">Login</button>
                    <button type="submit" class='btn btn-primary my-1 mx-1 col col-lg-3' name='register' value="Submit">Register</button>
                </div>
                <label for="stayLogged" class='form-check-label my-1'>Stay logged: </label>
                <input type="checkbox" class='form-check-input my-2' name="stayLogged" id="stayLogged">
                <?php echo @$alert; ?>

            </form>
        </div>

    </main>


</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>

</html>