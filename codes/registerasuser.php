
<?php 

include("database.php");

$errorMessege = "";

if(isset($_POST["register"]) && $_POST["username"] != "" && $_POST["password"] != "" && $_POST["company"] != "")
{

	$username = $_POST["username"];
	$password = $_POST["password"];
	$company = $_POST["company"];

	global $database;
	$registrationResult = $database -> registerUser($username, $password, $company);

	if($registrationResult != "")
	{
		header("location: ?error=".$registrationResult);
		exit();
	}
	else
	{
		global $database;
		$loginResult = $database -> checkLogin($username, $password, $company);

		if($loginResult == TRUE)
		{
			header("location: memberArea.php");
			exit();
		}
	}
	

}
/*else if(!isset($_POST["register"]) && $_POST["username"] == "" && $_POST["password"] == "" && $_POST["company"] == "")
{
	header("location: ?error=Fill All Fields");
	exit();
}*/

if(isset($_GET["error"]))
{

	$errorMessege = $_GET["error"];
}


?>

<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Login Form</title>




	<link rel="stylesheet" href="../css/logindesign.css">




</head>

<body>

	<form name="login-form" class="login-form" action="" method="post">

		<div class="header">
			<h1>Welcome to our site</h1>
			<span><?php echo $errorMessege; ?></span>
		</div>

		<div class="content">
			<input name="username" type="text" class="input username" placeholder="Username" />
			<div class="user-icon"></div>
			<input name="password" type="password" class="input password" placeholder="Password" />
			<div class="pass-icon"></div>

			<select name = "company" id="soflow">
				<option selected disabled>-Select Organization--</option>
				<?php 
				
				global $database;

				//showing the lists of already registered companies
				$database -> registeredCompanies();
				?>
			</select>

		</div>

		<div class="footer">
			<input type="submit" class="button" name="register" value="Register" />
		</div>

	</form>





</body>
</html>
