<?php 
	
	include("database.php");
	session_start();

	if(!isset($_SESSION[IS_ADMIN]) || $_SESSION[IS_ADMIN] == 0 || !isset($_SESSION[COMPANY_NAME]))
	{
		header("location: loginpage.php");
		exit;
	}

	if(isset($_POST["sendmessege"]) && isset($_POST["messege"]))
	{
		global $database;
		$database -> sendMessege($_SESSION[USER_ID], $_POST["registeredUsers"], $_SESSION[COMPANY_NAME], $_POST["messege"]);
		//echo $_SESSION[USER_ID]." ". $_POST["registeredUsers"]." ". $_SESSION[COMPANY_NAME]." ". $_POST["messege"];
	}

echo "select Person : <br/>";


 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Admin Messeges</title>
 </head>
 <body>
 	
 	<form method="POST" action="">
 		<select name = "registeredUsers">
 			<?php 
 				global $database;
 				$database -> registeredMembers($_SESSION[COMPANY_NAME]);
 			 ?>
 		</select>
 		<input type = "text" name = "messege"/> <br/>
 		<input type="submit" name = "sendmessege" value="Send">
 	</form>

 	<?php 

 		echo "Your Messeges : <br/>";

 		global $database;
 		$messeges = $database-> showMesseges($_SESSION[USER_ID], $_SESSION[COMPANY_NAME]);

 		while($row=$messeges->fetch_assoc())
		{                                                 
			echo "From ".$row[MESSEGE_FROM] ."   " .$row[MESSEGES]."<br/>";
			//echo $row[USER_ID];
		}

 	 ?>

 </body>
 </html>