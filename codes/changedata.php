
<?php 

include("database.php");

$errorMessege = "";

session_start();

if(!isset($_SESSION[USER_ID])|| !isset($_SESSION[COMPANY_NAME]) || !isset($_SESSION[IS_ADMIN]))
	{
		header("location: ../loginpage.php");
		exit();
	}

if(isset($_POST["change"]))
	{
		if( $_POST["password1"] != "" && $_POST["password2"] != "" && $_POST["password3"] != "" && $_POST["password2"] == $_POST["password3"] )
		{
			global $database;
			$database ->changeData($_SESSION[USER_ID],$_POST["password1"], $_POST["password2"], $_SESSION[COMPANY_NAME]);
			session_destroy();
			header("location: ../loginpage.php?error=successfully Changed Password, please log in again");
			exit();
			//echo "Successfull";
		}

		else{
			//echo $_POST["password1"];
			header("location: changedata.php?error=Input error or password not matched");
		}
	}

	if(isset($_GET["error"]))
	{
		$errorMessege = $_GET["error"];
	}


?>

<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Password changed</title>




	<link rel="stylesheet" href="../css/logindesign.css">




</head>

<body>

	<form name="login-form" class="login-form" action="" method="post">

		<div class="header">
			<h1>Change Password</h1>
			<span><?php echo $errorMessege; ?></span>
		</div>

		<div class="content">
			<input name="password1" type="password" class="input password" placeholder="Old Password" />
			<div class="pass-icon"></div>
			<input name="password2" type="password" class="input password" placeholder="New Password" />
			<input name="password3" type="password" class="input password" placeholder="Retype Password" />


		</div>

		<div class="footer">
			<input type="submit" class="button" name="change" value="Update" />
		</div>

	</form>





</body>
</html>
