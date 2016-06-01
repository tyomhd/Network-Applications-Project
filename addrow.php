<?php
echo '<div id="backbg">';
echo '<form action="http://enos.itcollege.ee/~alikhach/Vorgurakendused1/Project/project.php?page=add" method="POST" >';
echo '<p>Weight (g) : <input type="number" name="weight"/></p>';
$food_id = $_GET["id"];
//echo '<h5>'.$food_id.'</h5>';
echo '<p>Food id: <input type="number" name="id" value="'.$food_id.'"/></p>';
echo '<h5>You have chosen:</h5>';
echo '<p>Date (yyyy-mm-dd) : <input type="text" name="datepicker" value="2016-06-01"/></p>';
echo '<input type="submit">';
echo '</form>';
echo '</div>';
/*
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
*/
?>