<?php

function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function logi(){
	global $connection;
	$errors = array();
	if(isset($_SESSION["user"])){
		header("Location: ?page=loomad");
	}else{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if(empty($_POST["user"]) || empty($_POST["pass"])){
				if(empty($_POST["user"])) {
					array_push($errors, "Empty username field.");
				}
				if(empty($_POST["pass"])) {
					array_push($errors, "Empty password field.");
				}
			}else{
				$sql = "SELECT id FROM alikhach_users WHERE username='".mysqli_real_escape_string($connection, $_POST["user"])."' AND passw=SHA1('". mysqli_real_escape_string($connection, $_POST["pass"])."')";
				$result = mysqli_num_rows(mysqli_query($connection, $sql));
				if($result){
					$_SESSION["user"] = $_POST["user"];
					header("Location: ?page=loomad");
				}else{
					array_push($errors, "Wrong username / password");
				}
			}
		}
	}
}

function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
}

function createdailylog(){

	if(isset($_SESSION["user"])) {
		global $connection;
		$errors = array();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_SESSION["user"])) {
				if(empty($_POST["day"]) || empty($_POST["month"]) || empty($_POST["year"])){
					array_push($errors, "Some empty fields");
					header("Location: ?");
				}else {
					$date = $_POST["day"] . '/' . $_POST["month"] . '/' . $_POST["year"];
					$select_dates = "SELECT * FROM alikhach_users_" . $_SESSION["user"] . " WHERE day='$date'";
					$result = mysqli_query($connection, $select_dates);
					$tamount = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(weight) AS tamount  FROM alikhach_users_" . mysqli_real_escape_string($connection, $_SESSION["user"]) . " where day='$date'"))["tamount"];
					$tcarbs = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(carbs) AS tcarbs  FROM alikhach_users_" . mysqli_real_escape_string($connection, $_SESSION["user"]) . " where day='$date'"))["tcarbs"];
					$tfats = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(fats) AS tfats  FROM alikhach_users_" . mysqli_real_escape_string($connection, $_SESSION["user"]) . " where day='$date'"))["tfats"];
					$tprots = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(prots) AS tprots  FROM alikhach_users_" . mysqli_real_escape_string($connection, $_SESSION["user"]) . " where day='$date'"))["tprots"];
					$talcohol = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(alcohol) AS talcohol  FROM alikhach_users_" . mysqli_real_escape_string($connection, $_SESSION["user"]) . " where day='$date'"))["talcohol"];
					$twater = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(water) AS twater  FROM alikhach_users_" . mysqli_real_escape_string($connection, $_SESSION["user"]) . " where day='$date'"))["twater"];
					$tfiber = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(fiber) AS tfiber  FROM alikhach_users_" . mysqli_real_escape_string($connection, $_SESSION["user"]) . " where day='$date'"))["tfiber"];
					$tenergy = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(energy) AS tenergy  FROM alikhach_users_" . mysqli_real_escape_string($connection, $_SESSION["user"]) . " where day='$date'"))["tenergy"];
				}
		}
		}
	} else {
	header("Location: ?");
}
	include_once('views/dailylog.html');
}

function kuva_puurid(){
	global $connection;

	if(isset($_SESSION["user"])) {

		$select_dates = "SELECT * FROM alikhach_users_".mysqli_real_escape_string($connection,$_SESSION["user"]);
		$result = mysqli_query($connection, $select_dates);

		$tamount = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(weight) AS tamount  FROM alikhach_users_".mysqli_real_escape_string($connection,$_SESSION["user"])))["tamount"];
		$tcarbs = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(carbs) AS tcarbs  FROM alikhach_users_".mysqli_real_escape_string($connection,$_SESSION["user"])))["tcarbs"];
		$tfats = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(fats) AS tfats  FROM alikhach_users_".mysqli_real_escape_string($connection,$_SESSION["user"])))["tfats"];
		$tprots = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(prots) AS tprots  FROM alikhach_users_".mysqli_real_escape_string($connection,$_SESSION["user"])))["tprots"];
		$talcohol = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(alcohol) AS talcohol  FROM alikhach_users_".mysqli_real_escape_string($connection,$_SESSION["user"])))["talcohol"];
		$twater = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(water) AS twater  FROM alikhach_users_".mysqli_real_escape_string($connection,$_SESSION["user"])))["twater"];
		$tfiber = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(fiber) AS tfiber  FROM alikhach_users_".mysqli_real_escape_string($connection,$_SESSION["user"])))["tfiber"];
		$tenergy = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(energy) AS tenergy  FROM alikhach_users_".mysqli_real_escape_string($connection,$_SESSION["user"])))["tenergy"];

	} else {
		header("Location: ?");
	}
	include_once('views/dailylog.html');
}


function addrow(){
	global $connection;
	$errors = array();
	if(isset($_SESSION["user"])) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(empty($_POST["day"]) || empty($_POST["month"]) || empty($_POST["year"]) || empty($_POST["amount"]) || empty($_POST["foodid"]) ) {
				array_push($errors, "Some empty fields");
				header("Location: ?");
			}
			else if($_POST["amount"]<=0){
					array_push($errors, "Amount can't be less or equal to zero");
			}else {
			$amount = mysqli_real_escape_string($connection, $_POST["amount"]);
			$date = mysqli_real_escape_string($connection, $_POST["day"] . '/' . $_POST["month"] . '/' . $_POST["year"]);
			$id = mysqli_real_escape_string($connection, $_POST["foodid"]);
			$name = "SELECT * FROM alikhach_nutridata WHERE ID=" . $id;
			$result = mysqli_query($connection, $name);
			$row = mysqli_fetch_assoc($result);
			$name = mysqli_real_escape_string($connection, substr($row["Name-eng"], 0, 49));
			$carbs = mysqli_real_escape_string($connection, (double)$amount / 100 * (double)$row["Carbs-absorbable-g"]);
			$fats = mysqli_real_escape_string($connection, (double)$amount / 100 * (double)$row["Fats-g"]);
			$prots = mysqli_real_escape_string($connection, (double)$amount / 100 * (double)$row["Proteins-g"]);
			$alcohol = mysqli_real_escape_string($connection, (double)$amount / 100 * (double)$row["Alcohol-g"]);
			$water = mysqli_real_escape_string($connection, (double)$amount / 100 * (double)$row["Water-g"]);
			$fiber = mysqli_real_escape_string($connection, (double)$amount / 100 * (double)$row["Fiber-g"]);
			$energy = mysqli_real_escape_string($connection, (double)$amount / 100 * (double)$row["Energy-kcal"]);

			$add = "INSERT INTO alikhach_users_" . mysqli_real_escape_string($connection, $_SESSION["user"]) . " (food_id, weight, day, foodname, carbs, fats, prots, alcohol, water, fiber, energy) VALUES ($id, $amount, '$date', '$name', $carbs, $fats, $prots, $alcohol, $water, $fiber, $energy)";
			$result2 = mysqli_query($connection, $add);
			if ($result2) {
				header('Location: http://enos.itcollege.ee/~alikhach/Vorgurakendused1/Project/project.php?page=loomad');
			}
		}
		}
	}else{
		header("Location: ?");
	}
}
function deleterow()
{
	global $connection;
	$errors = array();
	if (isset($_SESSION["user"])) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(empty($_POST["id"]) ){
				array_push($errors, "Some empty fields");
				header("Location: ?");
			}else {
			$id = mysqli_real_escape_string($connection, $_POST["id"]);

			$delete = "DELETE FROM alikhach_users_" . mysqli_real_escape_string($connection, $_SESSION["user"]) . " WHERE ID=" . $id;
			$result = mysqli_query($connection, $delete);
			if ($result) {
				header('Location: http://enos.itcollege.ee/~alikhach/Vorgurakendused1/Project/project.php?page=loomad');
			}
			}
		}
	}else{
		header("Location: ?");
	}
}
?>