<?php
//replace user with mysql username, pass with mysql password
//rename file to config.php, it will not be uploaded to repo
$db = new PDO('mysql:host=localhost;dbname=inspireMe;charset=utf8;dbcollat=utf8_turkish_ci;', 'user', 'pass');
?>