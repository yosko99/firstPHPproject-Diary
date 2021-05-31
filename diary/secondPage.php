<?php
require_once "config/config.php";

if (!isset($_SESSION["id"])) { // Checks if session is active 
    header("Location: index.php");
} else {
    $query = "SELECT text FROM users WHERE id='" . mysqli_real_escape_string($db, $_SESSION["id"]) . "'";
    $res = $db->query($query)->fetch_array();

    $text =  $res["text"]; // Prints text from database

    if ($_GET) { // Unsets session and deletes cookie
        unset($_SESSION['id']);
        setcookie("id", "", time() - 60);
        header("Location: index.php");
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

    <title>Private diary</title>
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <h5 class='mx-2 display-6'>My diary</h5>
        <form class="form-inline" method="GET">
            <a href="index.php">
                <button class="btn btn-outline-success mx-2" name='logout' type="submit">Sign out</button>
            </a>
        </form>
    </nav>
    <textarea name="textarea" spellcheck="false" class='form-control my-4 textArea' cols="30" rows="10"><?php echo $text; ?></textarea>

</body>

<script src="js/main.js"></script>

</html>