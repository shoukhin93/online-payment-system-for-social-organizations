<?php
include("constants.php");

session_start();

   if(session_destroy()) {
      header("location: ../index.html");
      exit();
   }
   else
   	header("location: ../index.html");

   session_write_close();


?>