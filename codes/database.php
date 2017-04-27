<?php

include("constants.php");

class MYDB
{
	var $connection;
	//var $a = "test";



	function __construct()
	{
		$this->connection = new mysqli(SERVER, USER, PASS) ;
		$this -> initializeDatabases();
		//echo $this -> a;


	}

	public function swithchDatabase($databaseName)
	{
		mysqli_select_db($this-> connection, $databaseName);
	}

	public function initializeDatabases()
	{
		$this->connection -> query(INITIALIZE_DATABASE);
		$this->swithchDatabase(MAIN_DATABASE);
		$this->connection -> query(INITIALIZE_DATABASE_TABLE);		
		 	//echo "OK";
		
	}

	public function initializeCompanyDatabase($databaseName)
	{
		//at first creating Database
		$query = "CREATE DATABASE if not exists " . $databaseName;
		$this->connection -> query($query);
		$this->swithchDatabase($databaseName);

		//creating initial tables
		$this->connection -> query(PENDING_TABLE_CREATE);
		$this->connection -> query(USERS_TABLE_CREATE);
		$this->connection -> query(MAIN_ACCOUNT_TABLE_CREATE);
		$this->connection -> query(TRANSECTION_TABLE_CREATE);
		$this->connection -> query(MESSEGES_TABLE_CREATE);

		//making main balance 0
		$query = "insert into  " . MAIN_ACCOUNT_TABLE . " values (0)";
		$this->connection -> query($query);
	}

	function check_input($data)
	{
		$data = trim($data);
  		$data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
	}

	public function checkLogin($userName, $password, $companyName)
		{
			$userName = $this->check_input($userName);
			$password = $this->check_input($password);

			$this->swithchDatabase($companyName);
			$query = "select * from " . USERS_TABLE . " where " . USER_ID . " = '" . $userName ."' and " . PASSSWORD . " = '" .$password. "'";
			
		  	$result = $this ->connection -> query($query);
		  	//echo $query ;
		  	//echo " a" .$result;
		  	//$row=$result->fetch_assoc();
		  	

		  	if( $result &&  mysqli_num_rows($result) == 1) //login successfull
		  	{
		  		session_start();
		  		$row=$result->fetch_assoc();
		  		$_SESSION[USER_ID] = $userName;
		  		$_SESSION[IS_ADMIN] = $row[IS_ADMIN];
		  		$_SESSION[COMPANY_NAME] = $companyName;
		  		session_write_close ();
		  		//echo "Logged in";
		  		
		  		return TRUE;

		  	}
		  	else
		  		return FALSE;
			
		}

	public function registeredCompanies()
	{
		$this -> swithchDatabase(MAIN_DATABASE);

		$query = "select " . COMPANY_NAME . " from ". REGISTERED_COMPANIES ;
		$result = $this->connection -> query($query);

		while($row=$result->fetch_assoc())
		{                                                 
			echo "<option value='".$row[COMPANY_NAME]."'>".$row[COMPANY_NAME]."</option>";
		}

	}

	public function transectedHistory($id, $company,$isadmin)
	{
		$this -> swithchDatabase($company);

		if($isadmin == 1)		//Admin	
			$query = "select * from " . TRANSECTION_TABLE;
		else
			$query = "select * from " . TRANSECTION_TABLE . " where ". USER_ID. " = '". $id. "' order by " . DATE ;

		$result = $this->connection -> query($query);

		return $result;

	}

	public function transectIntoPending($from, $ammount, $company)
	{
		$this -> swithchDatabase($company);
		$query = "insert into ". PENDING_TABLE. " ( " . USER_ID . " , " . AMMOUNT ." ) values ('".$from . "','".$ammount."')";
		$this->connection -> query($query);
	}

	public function pendingRequests($company)
	{
		$this -> swithchDatabase($company);

		$query = "select * from " . PENDING_TABLE;
		$result = $this->connection -> query($query);

		return $result;
	}

	public function pendingApprove($id, $company)
	{
		$this -> swithchDatabase($company);
		$query1 = "select * from ". PENDING_TABLE . " where " . ID . " = '" . $id . "'";
		$result = $this->connection -> query($query1);
		$result = $result ->fetch_assoc();

		$query2 = "insert into " . TRANSECTION_TABLE . " ( " . USER_ID. ", " . AMMOUNT. ", " . DATE . ") values ( '" . $result[USER_ID] . "', '". $result[AMMOUNT]. "', '". $result[DATE] . "' )";
		$this->connection -> query($query2);

		//increasing main account balance
		$this-> changeMainAccount($company,$result[AMMOUNT], TRUE);

		//deleting from pending list
		$this->pendingReject($id,$company);
	}

	public function pendingReject($id, $company)
	{
		$this -> swithchDatabase($company);
		$query = "delete from ". PENDING_TABLE . " where " . ID . " = '" . $id . "'";
		$this->connection -> query($query);

	}

	public function mainBalance($company)
	{
		$this -> swithchDatabase($company);

		$query = "select * from " . MAIN_ACCOUNT_TABLE;
		$result = $this->connection -> query($query);

		return  $result->fetch_assoc();
	}

	public function changeMainAccount($company, $ammount, $decrease)
	{
		$this -> swithchDatabase($company);

		//decrease command found
		if($decrease == FALSE)
		$query = "update " . MAIN_ACCOUNT_TABLE . " set " . BALANCE . " = " . BALANCE . " - " . $ammount; 
		else
			$query = "update " . MAIN_ACCOUNT_TABLE . " set " . BALANCE . " = " . BALANCE . " + " . $ammount;

		$this->connection -> query($query);
			//echo $this->connection -> error;

	}

	public function registeredMembers($company)
	{
		$this -> swithchDatabase($company);

		$query = "select * from " . USERS_TABLE;
		$result = $this->connection -> query($query);
			//echo $this->connection -> error;

		while($row=$result->fetch_assoc())
		{                                                 
			echo "<option value='".$row[USER_ID]."'>".$row[USER_ID]."</option>";
			//echo $row[USER_ID];
		}

	}

	public function showMesseges($id, $company)
	{
		$this -> swithchDatabase($company);

			$query = "select * from " . MESSEGES_TABLE. " where " . MESSEGE_TO. " = '" . $id."'";
		$result = $this->connection -> query($query);
		
		return $result;
	}

	public function sendMessege($from, $to, $company, $messege)
	{
		$this -> swithchDatabase($company);
		$query= "insert into " . MESSEGES_TABLE. " ( " . MESSEGE_FROM."," . MESSEGE_TO . "," . MESSEGES .") values ('".$from."','".$to."','"
				.$messege."')" ;
		if($this->connection -> query($query) == FALSE)
			echo $this->connection ->error;
	}

	public function registerUser($id,$password,$company)
	{
		$this -> swithchDatabase($company);
		$query= "insert into " . USERS_TABLE. " (".USER_ID.",".PASSSWORD.",".IS_ADMIN.") values ('".$id."','".$password."','0')";

		if($this->connection -> query($query) == FALSE)
			return $this->connection ->error;
		else
			return "";
	}

	public function registerCompany($name, $password, $location, $contact)
	{
		//initializing company database
		$this->initializeCompanyDatabase($name);

		//inserting data to main database
		$this->swithchDatabase(MAIN_DATABASE);
		$query = "insert into ". REGISTERED_COMPANIES." (".COMPANY_NAME.",".PASSSWORD.",".LOCATION.",".CONTACT.") values ('".$name."','"
				 .$password."','".$location."','".$contact."')";
		
		if($this->connection -> query($query) == FALSE)
			echo $this->connection ->error . "<br/>";

		//making Admin
		$this->swithchDatabase($name);

		$query = "insert into " . USERS_TABLE. "( ".USER_ID.",".PASSSWORD.",".IS_ADMIN.") values ('".$name."','".$password."','1')";
		
		if($this->connection -> query($query) == FALSE)
			return $this->connection ->error . "<br/>";
		else
			return "";

	}

	public function changeData($id,$oldPassword, $newPassword, $company)
	{
		$this -> swithchDatabase($company);

		$query = "select * from " .USERS_TABLE. " where " . USER_ID. " = '".$id."' and " .PASSSWORD. "= '".$oldPassword."'";
		$result = $this->connection -> query($query);

		if( mysqli_num_rows($result) == 1)
		{
			$row = $result -> fetch_assoc();

			$query = "update " .USERS_TABLE. " set ". PASSSWORD . " = '".$newPassword."' where " .USER_ID. " = '" .$id."'";
			$this->connection -> query($query);

			if ($row[IS_ADMIN] == 1)
			{
				$this -> swithchDatabase(MAIN_DATABASE);
				$query = "update " .REGISTERED_COMPANIES. " set ". PASSSWORD . " = '".$newPassword."' where " .COMPANY_NAME. " = '" .$id."'";
			}
		}

	}



	
}

$database = new MYDB();
//$database -> initializeDatabases();
//$database -> initializeCompanyDatabase("try");
//$database -> checkLogin("shoukhin", "a", "try");
//$database -> registeredCompanies();

?>