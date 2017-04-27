<?php 

include("database.php");


session_start();

if(!isset($_SESSION[IS_ADMIN]) || $_SESSION[IS_ADMIN] == 1 || !isset($_SESSION[COMPANY_NAME]) )
	{
		header("location: ../loginpage.php");
		exit();
		//echo "ok";
	}

//if messege sending requested
	if(isset($_POST["sendmessege"]))
	{
		//echo "ok";

		global  $database;
		$database ->sendMessege($_SESSION[USER_ID], $_POST["messegeto"], $_SESSION[COMPANY_NAME], $_POST["messege"]);
		header("location: memberArea.php");
		exit();
	}
 ?>