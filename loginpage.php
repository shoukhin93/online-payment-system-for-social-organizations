
<?php 

include("codes/database.php");

$errorMessege = "";

if(isset($_GET["error"]))
{

	$errorMessege = $_GET["error"];
	//echo $errorMessege;
}

session_start();

//Already Logged In
if(isset($_SESSION[USER_ID]) && isset($_SESSION[IS_ADMIN]) && isset($_SESSION[COMPANY_NAME]) && !isset($_GET["error"]))
{

	header(MEMBER_AREA);
	exit();
}

session_write_close();

if(isset($_POST["login"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["company"]))
{

	$username = $_POST["username"];
	$password = $_POST["password"];
	$company = $_POST["company"];

	global $database;
	$loginResult = $database -> checkLogin($username, $password, $company);

	if($loginResult == TRUE)
	{
		header(MEMBER_AREA);
		exit();
	}
	else
	{
		header("location: loginpage.php?error=Invalid Username or Password");
		exit();
	}


}

else
	$errorMessege = "Fill all data";





?>

<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Login Form</title>




	<link rel="stylesheet" href="css/logindesign.css">




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
			<input type="submit" class="button" name="login" value="Login" />
		</div>

	</form>





</body>
</html>
