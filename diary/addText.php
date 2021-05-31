<?php

require_once "config/config.php";

if (isset($_POST["text"])) {
    $textUpdateQ = "UPDATE users SET text='".mysqli_real_escape_string($db,$_POST["text"])."' WHERE id='".mysqli_real_escape_string($db,$_SESSION["id"])."'";
    echo $textUpdateQ;
    $resultText = $db->query($textUpdateQ);
}

?>