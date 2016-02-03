<?php 
	ob_start();
	include('header.php');
	include('serverConnect.php');
	$course_id = $_SERVER['QUERY_STRING'];
	//echo $course_id;
	$query = $db->prepare("select * from course_detail where course_id='$course_id'");
	$query->execute();
	$course_d = $query->fetchAll();
	//echo count($query);
	//print_r($course_d);
	$_SESSION['name'] = $course_d[0][1];
	$_SESSION['gen_info'] = $course_d[0][3];
	$_SESSION['course_id'] = $course_d[0][0];
	$_SESSION['announcement'] = $course_d[0][5];
	//$_SESSION['username'] = $_SESSION['username'];
	if(isset($_SESSION['course_id'])){
		$name = $_SESSION['name'];
		$gen_info = $_SESSION['gen_info'] ;
		$course_id = $_SESSION['course_id'];
		$announcement =$_SESSION['announcement'];
		$username = $_SESSION['username'];
		include('editor.php');
		include('ids.php');
	}
?>
	<style>
		#content{
			left:15%;
			width:70%;
			z-index:1;
			position:relative;
			background-color:#E8E8E8;
			box-shadow: 5px 5px 5px #888888;
			padding:10px;
			text-align:right;
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
        <?php 
		echo "<a href='course.php?".$course_id."'><h2>".$name."</h2></a>";
	//	echo "<h3>".$inst."</h3>";
		//print_r($_SESSION['regCrs']);
		if($_SESSION['UserType']=='inst'){
			$RCquery = $db->prepare("select activated from inst_course where user_id='$username' and course_id='$course_id' ");
			$RCquery->execute();$regCrs = $RCquery->fetchAll();
			//$registered = in_array($course_id,$regCrs);
			$nC = count($regCrs);
			//print_r($regCrs[0]);
			if(($nC==0) && !isset($_POST['reg'])){
				$registered=false;?>
				<form method="post" action="">
					<button type='submit' class='btn btn-primary' name='reg'> &nbsp Register &nbsp </button>
				</form>
				<?php 
			}
			else{
				if($regCrs[0][0]==0){
					$registered=false;
					echo "Your course will be activated within 24 hours.";
				}
				else{$registered=true;}
			}
				if(isset($_POST['reg'])){
					//echo "Your course will be activated within 24 hours.";
					$regQ = $db->prepare("insert into inst_course values(?,?,0)");
					$regQ ->execute(array($username,$course_id));
					header("Location:course.php?".$course_id);
				}
		}
		?>
    </div>
	<div id="content">
		<svg class="hidden">
			<defs>
				<path id="tabshape" d="M80,60C34,53.5,64.417,0,0,0v60H80z"/>
			</defs>
		</svg>
		
			<section > 
				<div class="tabs tabs-style-linetriangle">
					<nav>
						<ul>
							<li><a href="#section-linetriangle-1"><span>General Info</span></a></li>
							<li><a href="#section-linetriangle-2"><span>Syllabus</span></a></li>
							<?php 
								if($_SESSION['UserType']=='inst'){
									echo "<li><a href='#section-linetriangle-3'><span>Registered Students</span></a></li>";} 
								else if($_SESSION['UserType']=='learner'){
									echo "<li><a href='#section-linetriangle-3'><span>Gradebook</span></a></li>";} 
								else{
									echo "<li><a href='#section-linetriangle-3'><span>Registered Instructors</span></a></li>";} 
							?>
							<li><a href="#section-linetriangle-4"><span>Assessment</span></a></li>
							<li><a href="#section-linetriangle-5"><span>Announcements</span></a></li>
						</ul>
					</nav>
					<div class="content-wrap" >
						<!-- General Information -->
					<?php 
					try{?>
						<section id="section-linetriangle-1" > 
							<?php include('gen_info.php');?>
						</section>
						
						<!-- Syllabus -->
						<section id="section-linetriangle-2" style="text-align:left"><p>
							<?php include('syllabus.php');?>
						</section>
						
						<!-- List of registered student-->
						<?php 
							include('reg_stdnt.php');							
						?>
						
						<!-- Assessment Schedule-->
						<section id="section-linetriangle-4">
							<?php 
								include('ass.php');
							?>
						</section>
						
						<!-- Announcements -->
						<section id="section-linetriangle-5">
							<?php
								include('ancmnt.php');
								
							?>
						</section>	
			<?php   }
						catch(Exception $err){
							echo "Please following steps-";
							echo "<ol><li>Login first. :)</li>";
							echo "<li>What you will see next in Course Dashboard. Click on the 'Join Class'.</li>";
							echo "<li>You will be redirected to corresponding course page.</li></ol>";
						}?>
					</div><!-- /content -->
				</div><!-- /tabs -->
			</section>
		<script src="js/cbpFWTabs.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script>
			(function() {

				[].slice.call( document.querySelectorAll( '.tabs' ) ).forEach( function( el ) {
					new CBPFWTabs( el );
				});

			})();
		</script>
	</div>
			<script src="js/modernizr.custom.js"></script>
		<script src="../../assets/js/ie-emulation-modes-warning.js"></script>
		<script src="js/jquery.min.js"></script>
		
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('.edit').click(function(){
					$(this).next(".ta").show();
				});
				$('.save').click(function(e){
					e.preventDefault();
					$(this).parent().hide();
				});
				$('.close1').click(function(e){
					e.preventDefault();
					$(this).parent().hide();
				});
			});
			
			$(document).ready(function(){
				$('.brf').click(function(){
					$(this).next('.dtl').toggle();
				});
			});

			$(document).ready(function(){
				$('.OC').click(function(){
					$(this).css({"disabled":"true"});
				});
			});
		</script>
		<hr>
	<footer align="center">
        <p>&copy; Unifiers Social Venture Pvt. Ltd. 2014</p>
    </footer>
	
	
</body>
</html>