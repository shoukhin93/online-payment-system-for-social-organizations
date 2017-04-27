
<?php 

include("database.php");

$errorMessege = "";

if(isset($_POST["register"]) )
{
	if($_POST["companyname"] == "" || $_POST["password"]=="" || $_POST["location"] =="" || $_POST["contactnum"] =="" )
		{
			$ErrorMessege = "Input Data Correctly!";
		}
		else
		{
			global $database;
			$messege = $database -> registerCompany($_POST["companyname"], $_POST["password"], $_POST["location"], $_POST["contactnum"]);
			if( $messege)
				header("location: ?".$messege);
			else{

				$database -> checkLogin($_POST["companyname"], $_POST["password"], $_POST["companyname"]);
				header("location: memberarea.php");
				exit();


			}
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
	<title>Registrarion Form</title>




	<link rel="stylesheet" href="../css/logindesign.css">




</head>

<body>

	<form name="login-form" class="login-form" action="" method="post">

		<div class="header">
			<h1>Register as organization</h1>
			<span><?php echo $errorMessege; ?></span>
		</div>

		<div class="content">
			<input name="companyname" type="text" class="input username" placeholder="Company name" />
			<div class="user-icon"></div>
		</div>
		<div class="content">
			<input name="password" type="password" class="input password" placeholder="Password" />
			<div class="pass-icon"></div>
		</div>
		<div class="content">
			<input name="location" type="text" class="input username" placeholder="Company Location" />
		</div>
		<div class="content">
			<input name="contactnum" type="text" class="input username" placeholder="Contact Number" />
		</div>

		

		<div class="footer">
			<input type="submit" class="button" name="register" value="Register" />
		</div>

	</form>





</body>
</html>
