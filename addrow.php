<?php
global $connection;
$host="localhost";
$user="test";
$pass="t3st3r123";
$db="test";
$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));

$delete = "INSERT INTO alikhach_users_test (food_id) VALUES ($food_id)";
$result = mysqli_query($connection, $delete);
if ($result) {
    //header('Location: http://enos.itcollege.ee/~alikhach/Vorgurakendused1/Project/project.php?page=loomad');
}

?>