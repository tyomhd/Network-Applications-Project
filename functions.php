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
				$sql = "SELECT id FROM alikhach_kylastajad WHERE username='".mysqli_real_escape_string($connection, $_POST["user"])."' AND passw=SHA1('". mysqli_real_escape_string($connection, $_POST["pass"])."')";
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
	/*include_once('views/login.html');*/
}

function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
}
/*
function deleteFromTable($id){
	global $connection;
	$delete = "DELETE FROM alikhach_users_".$_SESSION["user"]." WHERE ID=".$id;
	$result = mysqli_query($connection, $delete);
	include_once('views/dailylog.html');
}
*/
function kuva_puurid(){
	global $connection;
	//$puurid = array();

	if(isset($_SESSION["user"])) {
		/*$distinct_puur = "SELECT DISTINCT day FROM alikhach_users_test";
		$result = mysqli_query($connection, $distinct_puur);
		while ($row = $result->fetch_assoc()) {

			$select_puur = "SELECT * FROM alikhach_users_test WHERE  day=" . $row['day'];
			$result2 = mysqli_query($connection, $select_puur);

			while ($row2 = $result2->fetch_assoc()) {
				$puurid[$row['day']][] = $row2;
			}
		}*/

		$select_dates = "SELECT * FROM alikhach_users_".$_SESSION["user"];
		$result = mysqli_query($connection, $select_dates);

	} else {
		header("Location: ?");
	}
	include_once('views/dailylog.html');
}

function lisa(){
	global $connection;
	$errors=array();


	if(isset($_SESSION["user"])) {
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			try{$fileLocation = upload('liik');
			}catch(Exception $e){}

			if(empty($_POST["nimi"]) || empty($_POST["puur"]) || empty($fileLocation)){
				if(empty($_POST["nimi"])) {
					array_push($errors, "Empty name field.");
				}
				if(empty($_POST["puur"])) {
					array_push($errors, "Empty cage field.");
				}
				if(empty($fileLocation)) {
					array_push($errors, "Picture is missing");
				}
			}else{
				$n = mysqli_real_escape_string ($connection, $_POST["nimi"]);
				$p = mysqli_real_escape_string ($connection, $_POST["puur"]);
				$l = mysqli_real_escape_string ($connection, "images/".$_FILES["liik"]["name"]);
				$result = mysqli_query($connection, "INSERT INTO al1213_loomaaed (nimi, puur, liik) VALUES ('$n','$p','$l')");
				$id = mysqli_insert_id($connection);
				if($id>0){
					header("Location: ?page=loomad");
				}else{
					array_push($errors, "Picture can't be loaded");
				}

			}
		}
	} else {
		header("Location: ?page=login");
	}
	include_once('views/input-form.html');

}

function upload($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$extension = end(explode(".", $_FILES[$name]["name"]));

	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000)
		&& in_array($extension, $allowedExts)) {
		// fail õiget tüüpi ja suurusega
		if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
			// vigu ei ole
			if (file_exists("images/" . $_FILES[$name]["name"])) {
				// fail olemas ära uuesti lae, tagasta failinimi
				$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "images/" .$_FILES[$name]["name"];
			} else {
				// kõik ok, aseta pilt
				move_uploaded_file($_FILES[$name]["tmp_name"], "images/" . $_FILES[$name]["name"]);
				return "images/" .$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}
function addrow(){
	global $connection;
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$amount = $_POST["amount"];
		$date = $_POST["day"].'/'.$_POST["month"].'/'.$_POST["year"];
		$id =  $_POST["foodid"];
		$name = "SELECT * FROM alikhach_nutridata WHERE ID=".$id;
		$result = mysqli_query($connection, $name);
		$rw =  mysqli_fetch_assoc($result);
		$row = $rw["Name-eng"];
		$name = substr($row,0,49);

		$add = "INSERT INTO alikhach_users_test (food_id, weight, day, foodname) VALUES ($id, $amount, '$date', '$name')";
		$result2 = mysqli_query($connection, $add);
		if ($result2) {
			header('Location: http://enos.itcollege.ee/~alikhach/Vorgurakendused1/Project/project.php?page=loomad');
		}
	}
}
function createGraph(){
	include_once('views/daylygraph.html');
}
?>