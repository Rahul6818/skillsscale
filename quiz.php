<?php 
	//session_start();
	include("header.php");
	if(!isset($_SESSION['username'])){header("Location:index.php");}
	$quiz_id = $_SESSION['quiz_id'];
	$quiz_title = $_SESSION['quiz_title'] ;
	$weightage = $_SESSION['weightage'];
	$due_date = $_SESSION['due_date'];
	$course_id = $_SESSION['course_id'];
	$OC =$_SESSION['OC'];
	$type = $_SESSION['type'];
	$username = $_SESSION['username'];
	include('editor.php');
	include('ids.php');
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
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>
	<script src="js/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.edit').click(function(){
				$(this).next(".ta").show();
			});
			$('.save').click(function(e){
				$(this).parent().hide();
			});
			$('.close1').click(function(e){
				e.preventDefault();
				$(this).parent().hide();
				
			});
		});
		// function ruSure() {
		// 	var txt;
		// 	var r = confirm("Press a button!");
		// 	if (r == true) {
				
		// 	} else {
		// 		txt = "You pressed Cancel!";
		// 	}
		// }
		function myTimer() {
    		setTimeout(function(){ document.getElementById("submitQuiz").click(); }, 10000);
		}
	</script>
	<style>
		#content{
			left:15%;
			width:70%;
			z-index:1;
			position:relative;
			background-color:#E8E8E8;
			box-shadow: 5px 5px 5px #888888;
			padding:15px;
			margin-top:50px;
			margin-bottom:50px;
			
		}
		#home{
			display:none;
		}
		#syllabus{
			display:none;
		}
		.ta{
			display:none;
		}
	</style>
	
</head>

<body>
	<div class="jumbotron"  align="center">
        <?php echo "<h2>".$quiz_title."</h2><a href='course.php?".$course_id."'><h4>Back</h4></a>"; ?>
		<div id="clk"></div>
    </div>
	<div id="content">
		<div class="col-sm-3"><b>Deadline </b> : <?php echo $due_date;?> (IST) </div>
		<div class="col-sm-3" id="clk"></div>
		<div class="col-sm-3"id="clk"></div>
		<div class="col-sm-3"><b>Total Weightage</b> : <?php echo $weightage;?> </div><br>
		<?php
		if($type=='t'){include('tquiz.php');}
			else{include('fquiz.php');}
		?>
	</div>
	<footer align="center">
        <p>&copy; Unifiers Social Venture Pvt. Ltd. 2014</p>
    </footer>

</body>
</html>