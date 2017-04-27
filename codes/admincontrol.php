<?php 
include ("database.php");

	session_start();

	if(!isset($_SESSION[IS_ADMIN]) || $_SESSION[IS_ADMIN] == 0 || !isset($_SESSION[COMPANY_NAME]) )
	{
		header("location: loginpage.php");
		exit;
	}

	//if main balance deacrese command found
	if(isset($_POST["decrease"]) && isset($_POST["ammount"]))
	{
		
		global $database;
		$database -> changeMainAccount($_SESSION[COMPANY_NAME], $_POST["ammount"], FALSE);

		header("location: adminzone.php");
		exit;
	}

	//if main balance increase command found
	if(isset($_POST["increase"]) && isset($_POST["ammount"]))
	{
		//echo $_POST["decreaseAmmount"];
		global $database;
		$database -> changeMainAccount($_SESSION[COMPANY_NAME], $_POST["ammount"], TRUE);

		header("location: adminzone.php");
		exit;
	}

	//if pending request rejects
	if(isset($_POST["reject"]))
	{
		//echo $_POST["pendingID"];
		global $database;
		$database ->pendingReject($_POST["pendingID"], $_SESSION[COMPANY_NAME]);

		header("location: adminzone.php");
		exit;
	}

	//pending request approves
	if(isset($_POST["approve"]))
	{
		//echo $_POST["pendingID"];
		global $database;
		$database ->pendingApprove($_POST["pendingID"], $_SESSION[COMPANY_NAME]);

		header("location: adminzone.php");
		exit();
	}

	//if messege sending requested
	if(isset($_POST["sendmessege"]))
	{
		//echo "ok";

		global  $database;
		$database ->sendMessege($_SESSION[USER_ID], $_POST["messegeto"], $_SESSION[COMPANY_NAME], $_POST["messege"]);
		header("location: adminzone.php");
		exit();
	}

 ?>