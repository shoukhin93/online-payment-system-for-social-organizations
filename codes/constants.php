<?php  

//Databases and tables

//Main database
define("MAIN_DATABASE", "maindatabase");
define("REGISTERED_COMPANIES", "registeredcompanies");
define("COMPANY_NAME", "name");
define("PASSSWORD", "password");
define("DATE", "date");
define("LOCATION", "location");
define("CONTACT", "contact");

//company Tables
define("PENDING_TABLE", "pending");
define("USERS_TABLE", "users");
define("MAIN_ACCOUNT_TABLE", "mainaccount");
define("TRANSECTION_TABLE", "transections");
define("MESSEGES_TABLE", "messeges");

//company table data 
define("ID", "id");
define("USER_ID", "uid");
define("AMMOUNT", "ammount");
define("IS_ADMIN", "isadmin");
define("BALANCE", "balance");
define("MESSEGES", "messeges");
define("MESSEGE_FROM", "messegefrom");
define("MESSEGE_TO", "messegeto");


//connections
define("SERVER", "localhost");
define("USER", "root");
define("PASS", "shoukhin");

//initial queries
define("INITIALIZE_DATABASE", "CREATE DATABASE if not exists ". MAIN_DATABASE);
define("INITIALIZE_DATABASE_TABLE", "CREATE TABLE if not exists ".REGISTERED_COMPANIES. " (".COMPANY_NAME." varchar(30) NOT NULL 
	PRIMARY KEY, " . PASSSWORD . " varchar(20) NOT NULL, ". DATE. " datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, " .LOCATION." varchar(30), 
	" . CONTACT . " varchar(15) )");

//company database and table
define("COMPANY_DATABASE", "CREATE DATABASE if not exists ");
define("PENDING_TABLE_CREATE", "CREATE TABLE if not exists " . PENDING_TABLE . " ( ". ID . " INT NOT NULL AUTO_INCREMENT, " . USER_ID . " varchar(30), 
	    " . AMMOUNT . " decimal (19,2) , " . DATE. " datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(". ID.", " . USER_ID .") )");

define("USERS_TABLE_CREATE", "CREATE TABLE if not exists " . USERS_TABLE . " (  " . USER_ID . " varchar(30) PRIMARY KEY, " . PASSSWORD . " 
		varchar(30) , " . IS_ADMIN . " BOOL )" );

define("MAIN_ACCOUNT_TABLE_CREATE", "CREATE TABLE if not exists " . MAIN_ACCOUNT_TABLE . " (  " .BALANCE. " decimal(20,2) NOT NULL)" );

define("TRANSECTION_TABLE_CREATE", "CREATE TABLE if not exists " . TRANSECTION_TABLE . " ( ". ID . " INT NOT NULL AUTO_INCREMENT, " . USER_ID . " varchar(30), 
	    " . AMMOUNT . " decimal (19,2) , " . DATE. " datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(". ID.", " . USER_ID .") )");

define("MESSEGES_TABLE_CREATE", "CREATE TABLE if not exists " . MESSEGES_TABLE . " (  ". ID . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " . MESSEGE_FROM . " varchar(30), "
		 . MESSEGE_TO . " varchar(30), " .MESSEGES . " varchar(100) NOT NULL )"  );

//page locations
define("HOMEPAGE", "index.html");
define("LOGIN_PAGE", "location: loginpage.php");
define("MEMBER_AREA", "location: codes/memberArea.php");

?>