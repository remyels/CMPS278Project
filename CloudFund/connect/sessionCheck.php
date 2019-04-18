<?php
session_start();

if(!isset($_SESSION["LoggedInUserID"])) {
    header("Location:index.php");
}

?>