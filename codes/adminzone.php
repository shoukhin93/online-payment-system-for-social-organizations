<?php 

include("database.php");

session_start();

/*if(!isset($_SESSION[IS_ADMIN]) || $_SESSION[IS_ADMIN] == 0 || !isset($_SESSION[COMPANY_NAME]))
{
  header("location: ../loginpage.php?error=please login first");
  exit();
}*/

function currentbalance()
{
	global $database;

	$balance = $database ->mainBalance($_SESSION[COMPANY_NAME]);

	return $balance[BALANCE];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Admin Area</title>

	<!-- Bootstrap Core CSS -->
	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="../css/simple-sidebar.css" rel="stylesheet">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->

  </head>

  <body>

  	<div id="wrapper">

  		<!-- Sidebar -->
  		<div id="sidebar-wrapper">
  			<ul class="sidebar-nav">
  				<li class="sidebar-brand">
  					<a href="../index.html">
  						Home
  					</a>
  				</li>
  				<li>
  					<a href="#changeammount">Change Ammount</a>
  				</li>
  				<li>
  					<a href="#pendinglist">Pending List</a>
  				</li>
  				<li>
  					<a href="#transecthistory">Transection History</a>
  				</li>
  				<li>
  					<a href="#messeges">View Messeges</a>
  				</li>
  				<li>
  					<a href="#sendmessege">Send Messege</a>
  				</li>
  				<li>
  					<a href="changedata.php">Change Password</a>
  				</li>
  				<li>
  					<a href="logout.php">Logout</a>
  				</li>


  			</ul>
  		</div>
  		<!-- /#sidebar-wrapper -->


  		<!-- Transect Ammount -->
  		<div id="page-content-wrapper">
  			<div class="container-fluid">
  				<div class="row">
  					<div class="col-lg-12">
  						<h1 align="center">Welcome Admin Of <?php echo $_SESSION[USER_ID]; ?>,</h1>
  						<h3>Current Balance Of This Organization : <?php echo currentbalance() ; ?></h3>
  						<form class="form-inline" method="post" action="admincontrol.php">
  							<h4 id = "transect">Change Ammount Of Money :</h4>
  							<div class="form-group">
  								<input type="text" class="form-control" name="ammount" placeholder="Change Ammount">
  							</div>

  							<button type="submit" class="btn btn-default" name="increase">Increase</button>
  							<button type="submit" class="btn btn-default" name="decrease">Decrease</button>
  						</form>
  					</div>
  				</div>
  			</div>
  		</div>

  		<!-- Pending List -->
  		<div id="page-content-wrapper">
  			<div class="container-fluid">
  				<div class="row">
  					<div class="col-lg-12">

  						
  						<h3 id = "pendinglist">Pending List :</h3>
  						<div class="container">

  							<table class="table table-hover">
  								<thead>
  									<tr>
  										<th>User ID</th>
  										<th>Ammount</th>
  										<th>Date</th>
  										<th>Approve</th>
  										<th>Reject</th>
  									</tr>
  								</thead>
  								<tbody>                      

  									<?php 
                        //showing user's transection history
  									global $database;
  									$pendingRequests = $database -> pendingRequests($_SESSION[COMPANY_NAME]);

  									while($row=$pendingRequests->fetch_assoc())
  									{                                                 
  										echo "<tr> <td> ".$row[USER_ID]."</td>"."<td>" .$row[AMMOUNT]."<td>" .$row[DATE]." </td> <td>";
  										?>
  										<form method="post" action="admincontrol.php">
  											<input type="hidden" name="pendingID" value=  <?php echo $row[ID]; ?> />

  											<input type="submit" name="approve" value="Approve">
  											<?php echo "</td> <td>"; ?>
  											<input type="submit" name="reject" value="Reject">
  											<?php echo "</td>"; ?>
  										</form>
  										<?php echo "</tr>";
  									}
  									?>
  								</div>
  							</tbody>
  						</table>
  					</div>
  				</div>
  			</div>
  		</div>

  		<!-- Transect History -->
  		<div id="page-content-wrapper">
  			<div class="container-fluid">
  				<div class="row">
  					<div class="col-lg-12">
  						<h3 id = "transecthistory">Transection History :</h3>
  						<div class="container">

  							<table class="table table-hover">
  								<thead>
  									<tr>
  										<th>User ID</th>
  										<th>Ammount</th>
  										<th>Date</th>
  									</tr>
  								</thead>
  								<tbody>                      

  									<?php 
                        //showing user's transection history
  									global  $database;
  									$result = $database ->transectedHistory($_SESSION[USER_ID], $_SESSION[COMPANY_NAME], $_SESSION[IS_ADMIN]);

  									while($row=$result->fetch_assoc())
  									{                                                 
  										echo "<tr> <td> ".$row[USER_ID]."</td>"."<td>" .$row[AMMOUNT]."<td>" .$row[DATE]." </td> </tr>";
  									}
  									?>
  								</div>
  							</tbody>
  						</table>
  					</div>
  				</div>
  			</div>
  		</div>

  		<!--View Messeges -->
  		<div id="page-content-wrapper">
  			<div class="container-fluid">
  				<div class="row">
  					<div class="col-lg-12">
  						<h3 id = "messeges">Messeges</h3>
  						<div class="container">

  							<table class="table table-hover">
  								<thead>
  									<tr>
  										<th>From</th>
  										<th>Messege</th>
  									</tr>
  								</thead>
  								<tbody>                      

  									<?php 
                        						//showing user's Messeges
  									global  $database;
  									$messeges = $database ->showMesseges($_SESSION[USER_ID], $_SESSION[COMPANY_NAME]);

  									while($row=$messeges->fetch_assoc())
  									{                                                 
  										echo "<tr> <td> ".$row[MESSEGE_FROM]."</td>"."<td>" .$row[MESSEGES]." </td> </tr>";
  									}
  									?>

  								</div>
  							</tbody>
  						</table>
  					</div>
  				</div>
  			</div>
  		</div>

  		<!-- Send Messege -->
  		<div id="page-content-wrapper">
  			<div class="container-fluid">
  				<div class="row">
  					<div class="col-lg-12">
  						<form  method="post" action="admincontrol.php">
  							<h4 id = "sendmessege">Send Messege to: </h4>
  							<div class="form-group">
  								<select class="form-control" name="messegeto">
  									<?php 
  									global $database;
  									$database->registeredMembers($_SESSION[COMPANY_NAME]);
  									?>
  								</select>
  							</div>
  							<h4>Messege: </h4>
  							<div class="form-group">'
  								<textarea class="form-control" rows="5" name = "messege"></textarea>

  							</div>
  							<button type="submit" class="btn btn-default" name="sendmessege">Send</button>
  						</form>


  					</div>
  				</div>
  			</div>
  		</div>
  		<!-- /#page-content-wrapper -->

  	</div>
  	<!-- /#wrapper -->

  	<!-- jQuery -->
  	<script src="../vendor/bootstrap/js/jquery.js"></script>

  	<!-- Bootstrap Core JavaScript -->
  	<script src="../js/bootstrap.min.js"></script>

  	<!-- Menu Toggle Script -->
 <!-- <script>
  $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
  });
</script>-->

</body>

</html>
