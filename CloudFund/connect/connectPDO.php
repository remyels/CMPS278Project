<?php
// create PDO object that connects to my database
$db = new PDO("mysql:host=localhost;dbname=cloudfund", "root", "");
// set exception and error mode
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>