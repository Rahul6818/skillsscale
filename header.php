<?php session_start();
	if(isset($_POST['logout'])){session_destroy();session_start();}
	include("serverConnect.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>SkillsScale</title>

   <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/contact.css" rel="stylesheet">
	<link href="css/tabs.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/tabstyles.css" />
  </head>

  <body>
    <nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand active" href="index.php">ScaleSkills</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Courses</a></li>
					<li><a href="#about">About</a></li>
					<li><a href="#contact">Contact</a></li>
						  
				<?php if(isset($_SESSION['username'])){?>
				<form class="navbar-form navbar-right" role="form" method="post" action="index.php">
					<?php if($_SESSION['UserType']=='learner'){echo "<a href='welcome.php'>";}elseif($_SESSION['UserType']=='inst') {echo "<a href='inst.php'>";}else{echo "<a href='admin.php'>";} echo $_SESSION['username']."</a>&nbsp &nbsp &nbsp"; ?>
					<button type="submit" class="btn btn-default" name="logout" >Log Out</button>
				</form>	
				<?php }
					else{?>
						<li><a href="#loginModal" data-toggle="modal" data-target="#loginModal">Sign In</a></li>
						<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">User Log In</h4>
									</div>
									<div class="modal-body">
										<div class="row" style="margin:5px">

											<form class="form-horizontal col-md-8" id="loginform" name="l_login">
												<div class="form-group">
													<input type="text" placeholder="Username" id="l_user" class="form-control" name="username">
												</div>
												<div class="form-group">
													<input type="password" placeholder="Password" id="l_pass" class="form-control" name="password" >
												</div>
											
											</form>
											
											<div class="col-md-4">
												<img src="images/people.arrow.left.PNG" height="45px" width="45px"><label>Trainee</label>
												<input class="btn btn-success" onclick="logForm()" type="button" name="learner_signin" id="l_signin" value="Sign In">
											</div>
										</div>
										<p id="d1" style="color:red;"></p>
										<hr>
										<div class="row" style="margin:5px">
											<div class="col-md-4">
												<img src="images/people.arrow.right.PNG" height="45px" width="45px"><label>Trainer</label>
												<input class="btn btn-success" onclick="logForm()" type="button" name="inst_signin" id="i_signin" value="Sign In">
											</div>
											<form class="form-horizontal col-md-8" id="loginform" name="i_login">
												<div class="form-group">
													<input type="text" placeholder="Username" id="i_user" class="form-control" name="username">
												</div>
												<div class="form-group">
													<input type="password" placeholder="Password" id="i_pass" class="form-control" name="password" >
												</div>
											
											</form>
										</div>
										<p id="d2" style="color:red;"></p>
										
									</div>
								</div>
							</div>
						</div>
					<?php }
				?>
			</ul></div><!--/.nav-collapse -->
      </div>
    </nav>
 <script type="text/javascript" src="js/login.js"></script>
 		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    	<script src="js/bootstrap.js"></script>
	<script src="js/jquery.min.js"></script>
	<script>
		var wrong = "Incorrect Username or Incorrect Password";
		var shortUser = " <div class='alert alert-warning'>Username is too short. Length of username must be greater than or equal to 5.</div>";
		var unknown = " <div class='alert alert-warning'>You are not registered. Please register/sign up first.</div>";
		var userexist = " <div class='alert alert-warning'>Sorry, username already exist, please choose another username.</div>";
		
		//function logForm(){
			$('#l_signin').click(function(){
				//alert("inst wanna login");
				var uname = document.getElementById("l_user").value;
				var upass = document.getElementById("l_pass").value;
				var dataString = 'namel=' + uname + '&passl=' + upass;
				if(uname=='' || upass==''){
					alert("Please fill all fields");
				}
				else{
					$.ajax({
						type: 		"POST",
						url:  		"login_ajax.php",
						data: 		dataString,
						cache:		false,
						success:	function(result){
							if(result==0){$("#d1").html(wrong);}
							else{window.location.assign(window.location.href)}
						}
					});
				}
				return false;
			});
			$('#i_signin').click(function(){
				//alert("inst wanna login");
				var uname = document.getElementById("i_user").value;
				var upass = document.getElementById("i_pass").value;
				var dataString = 'namei=' + uname + '&passi=' + upass;
				if(uname=='' || upass==''){
					alert("Please fill all fields");
				}
				else{
					$.ajax({
						type: 		"POST",
						url:  		"login_ajax.php",
						data: 		dataString,
						cache:		false,
						success:	function(result){
							if(result==0){$("#d2").html(wrong);}
							else if(result==1){window.location.assign(window.location.href)}
							else if(result==2){window.location.assign(window.location.href)}
						}
					});
				}
				return false;
			});

		//}
	</script>
    
	