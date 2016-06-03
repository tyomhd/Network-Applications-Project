<?php
require_once('functions.php');
session_start();
connect_db();

$page="pealeht";
if (isset($_GET['page']) && $_GET['page']!=""){
	$page=htmlspecialchars($_GET['page']);
}

include_once('views/head.html');

switch($page){
	/*case "login":
		logi();
		break;*/
	case "author":
		include_once('views/author.html');
		break;
	case "about":
		include_once('views/about.html');
		break;
	case "main":
		createtable();
		break;
	case "logout":
		logout();
		break;
	case "add":
		addrow();
		break;
	case "delete":
		deleterow();
		break;
	case "dailylog":
		createdailylog();
		break;
	default:
		logi();
		include_once('views/welcome-view.html');
		break;
}

include_once('views/foot.html');
?>