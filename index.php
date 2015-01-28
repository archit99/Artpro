<?php //123
ob_start();
session_start();
$err_msg=0;
require_once('./config/databases.php');

if (@$_SESSION['uname'] !='') {
header("Location:dashbord.php");
}


if (array_key_exists("submit",$_REQUEST)) {

    $username 		= htmlentities($_POST['uname']); // Get the username
	$password 		= htmlentities($_POST['passwd']); // Get the password and decrypt it
	$quee = 'SELECT * FROM logins WHERE name = "'.$username.'" AND passwd = "'.$password.'" ';
    $rs=$DBH->query($quee); // Check the table with posted credentials

    $rows_returned = $rs->num_rows;

if($rows_returned <= 0){ // If no users exist with posted credentials print 0 like below.
	
$err_msg = 1;
}

else
{
	$rs->data_seek(0);
	while($row = $rs->fetch_assoc()){
if($row['active'] == 0){ // Check if active or banned.

	//echo "Account is Inactive";
}
else{
//	echo "here";
	$_SESSION['login_id']=$row['login_id'];
	$_SESSION['bus_id_fk']=$row['bus_id_fk'];
	$_SESSION['email']=$row['email'];
	$_SESSION['uname']=$row['name'];
	$_SESSION['fname']=$row['fname'];
	$_SESSION['lvl'] = $row['userlvl'];
	$_SESSION['curr'] = $row['curr'];

$quee2 = 'SELECT `Name` FROM business where bus_id ="' . $_SESSION['bus_id_fk'].'"' ;
	$rs2=$DBH->query($quee2); // Check the table with posted credentials
	$rows_returned = $rs2->num_rows;
	while($row = $rs2->fetch_assoc()){

		$_SESSION['bus_name']=$row['Name'];

	}



      header("Location:dashbord.php");
 
  }
}
		
}


}

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
	<title>ArtPro</title>

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
	<link href="css/styles.css" rel="stylesheet" type="text/css">
	<link href="css/icons.css" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

	<script type="text/javascript" src="js/plugins/charts/sparkline.min.js"></script>

	<script type="text/javascript" src="js/plugins/forms/uniform.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/select2.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/inputmask.js"></script>
	<script type="text/javascript" src="js/plugins/forms/autosize.js"></script>
	<script type="text/javascript" src="js/plugins/forms/inputlimit.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/listbox.js"></script>
	<script type="text/javascript" src="js/plugins/forms/multiselect.js"></script>
	<script type="text/javascript" src="js/plugins/forms/validate.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/tags.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/switch.min.js"></script>

	<script type="text/javascript" src="js/plugins/forms/uploader/plupload.full.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/uploader/plupload.queue.min.js"></script>

	<script type="text/javascript" src="js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/wysihtml5/toolbar.js"></script>

	<script type="text/javascript" src="js/plugins/interface/daterangepicker.js"></script>
	<script type="text/javascript" src="js/plugins/interface/fancybox.min.js"></script>
	<script type="text/javascript" src="js/plugins/interface/moment.js"></script>
	<script type="text/javascript" src="js/plugins/interface/jgrowl.min.js"></script>
	<script type="text/javascript" src="js/plugins/interface/datatables.min.js"></script>
	<script type="text/javascript" src="js/plugins/interface/colorpicker.js"></script>
	<script type="text/javascript" src="js/plugins/interface/fullcalendar.min.js"></script>
	<script type="text/javascript" src="js/plugins/interface/timepicker.min.js"></script>

	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/application.js"></script>

</head>

<body class="full-width page-condensed">

	<!-- Navbar -->
	<div class="navbar navbar-inverse" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-right">
				<span class="sr-only">Toggle navbar</span>
				<i class="icon-grid3"></i>
			</button>
			<a class="navbar-brand" href="#"><img src="images/logo.png" alt="Londinium"></a>
		</div>


	</div>
	<!-- /navbar -->


	<!-- Login wrapper -->
	<p class="text-danger"> <?php //echo $err_msg;
	//echo '<script language="javascript">';
   //echo 'alert("message successfully sent")';
   //echo '</script>';

	?></p>

	<div class="login-wrapper">
		<form action="<?php echo $_SERVER["PHP_SELF"];?>"  role="form" method="post" class="validate" >
			<div class="popup-header">
				<a href="#" class="pull-left"></a>
				<span class="text-semibold">User Login</span>
				
			</div>
			<div class="well">
				<div class="form-group has-feedback">
					<label>Username</label>
					<input type="text" name="uname" class="required form-control" placeholder="Username" >
					<i class="icon-users form-control-feedback"></i>
				</div>

				<div class="form-group has-feedback">
					<label>Password</label>
					<input type="password" name = "passwd" class="required form-control" placeholder="Password">
					<i class="icon-lock form-control-feedback"></i>
				</div>

				<div class="row form-actions">
					<div class="col-xs-6">
					
							<label>
								<a data-toggle="modal" role="button" href="#form_modal"> Forgot password?</a>
							
							</label>
						</div>
				
					<div class="col-xs-6">
						<button type="submit" name="submit" class="btn btn-bg-primary pull-right"><i class="icon-menu2"></i> Sign in</button>
					</div>
					
				</div>
			</div>
		</form>

	</div>  
	<!-- /login wrapper -->


	<!-- Footer -->
	<?php include("config/footer.php");?>
	<!-- /footer -->

	<!-- Modal with remote path -->
	<div id="remote_modal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="icon-accessibility"></i> Loading remote path</h4>
				</div>

				<div class="modal-body with-padding">
					<p>One fine body&hellip;</p>
				</div>

				<div class="modal-footer">
					<button class="btn btn-warning" data-dismiss="modal">Close</button>
					<button class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /modal with remote path -->


				<div id="form_modal" class="modal fade" tabindex="-1" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="icon-paragraph-justify2"></i> Reset Password</h4>
						</div>

						<!-- Form inside modal -->
						<form action="#" role="form">

							<div class="modal-body with-padding">
								<div class="block-inner text-danger">
									<h6 class="heading-hr">Enter Email Address <small class="display-block">Please enter your Valid Email address</small></h6>
								</div>


								<div class="form-group">
									<div class="row">
										<div class="col-sm-6">
											<label>Email</label>
											<input type="text" placeholder="eugene@kopyov.com" class="form-control">
											<span class="help-block">name@domain.com</span>
										</div>
									<div class="row">
										<div class="col-sm-2">
										<label></label>
											<button type="submit" class="btn btn-primary">Submit</button>
										</div>

									</div>
									
								</div>
							</div>

							

						</form>
					</div>
				</div>
			</div>
</body>
</html>