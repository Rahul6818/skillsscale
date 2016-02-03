<?php
	ob_start();
	//session_start();
	include("header.php");
	if($_SESSION['UserType']!='admin'){header("Location:welcome.php");}
	$username = $_SESSION['username'];
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
		}
		#home{
			display:none;
		}
		#syllabus{
			display:none;
		}
		.ta,.dtl{display:none;}
	</style>
	</head>
  <body>
	<div class="jumbotron"  align="center">
        <h2><?php echo "Welcome Mr. ".$username?></h2>
    </div>
	<div id="content">
		<svg class="hidden">
			<defs>
				<path id="tabshape" d="M80,60C34,53.5,64.417,0,0,0v60H80z"/>
			</defs>
		</svg>
		
			<section>
				<div class="tabs tabs-style-linetriangle">
					<nav>
						<ul>
							<li><a href="#section-linetriangle-1"><span>Course Dashboard</span></a></li>
							<li><a href="#section-linetriangle-2"><span>Registered Trainers</span></a></li>
							<li><a href="#section-linetriangle-3"><span>Profile</span></a></li>
						</ul>
					</nav>
					<div class="content-wrap">
						<section id="section-linetriangle-1">
							<span  class='label label-danger'>Not Activated</span> 
							<span  class='label label-success'>Activated</span> 
							<span  class='label label-primary'>Total ( Activated + Not Acticated )</span> <br><br>
							<table class="table table-striped">
								<tr class="info">
									<td>S.No.</td>
									<td>Course ID</td>
									<td>Course Name</td>
									<td>Registered Trainers</td>
									<td></td>
								</tr>
								<?php
								try{
									$query = $db->prepare("select course_id,course_name from course_detail");
										$query->execute();
										$course=$query->fetchAll();
										$n = count($course);
										//print_r($course);
										for($i=0;$i<$n;$i++){
											$NRQuery=$db->prepare("select count(user_id),activated from inst_course where course_id='".$course[$i][0]."' group by activated");
											$NRQuery->execute();$newR = $NRQuery->fetchAll();
											echo "<tr><td>".($i+1)."</td>";
											echo "<td>".$course[$i][0]."</td>";
											//if($course[$i][6]=='0000-00-00'){echo "<td>Not Decided</td>";}else{echo "<td>".$course[$i][6]."</td>";}
											//if($course[$i][7]=='0000-00-00'){echo "<td>Not Decided</td>";}else{echo "<td>".$course[$i][7]."</td>";}
											echo "<td>".$course[$i][1]."</td><td>";
													$total = 0; $a=0; $na=0;
												foreach($newR as $reg){
													$reg[1]?($a=$a+$reg[0]):($na=$na+$reg[0]);
													$total = $total+$reg[0];
												}
												echo "<span  class='label label-danger'>".$na."</span> ";
												echo "<span  class='label label-success'>".$a."</span> ";
												echo "<span  class='label label-primary'>".$total."</span> ";

											echo "</td><td><a href='course.php?".$course[$i][0]."'><button class='btn btn-success btn-xs'>Join Class</button></td>";
											?>
											</tr>
								<?php 	}
								}
								catch(Exception $error){
									die("Connection Faild : ".$error -> getMessage());
								}
								?>
							</table>
							
							<!-- add new course -->
							<form class="form-horizontal" method="post" action="#">
								<button type='button' class='btn btn-primary btn-xs edit' style="margin-left:45%">  Add a New Course </button>
								<div class='ta' style="margin-left:10%;margin-right:10%">
									Course Title
									<input type="text"  name="new_course" class="form-control" placeholder="Course Title"></input><br>
									Course Instructor
									<input type="text"  name="new_inst" class="form-control" placeholder="Course Instructor"></input><br>
									<div class="col-sm-6">
										Starts On
										<input type="date" class="form-control" name="sd" placeholder="Starting Date of Course"></input>
									</div>
									<div class="col-sm-6">
										Ends On
										<input type="date" class="form-control" name="ed" placeholder="Ending Date of Course"></input>
									</div>
									<button type='submit' class='btn btn-primary btn-xs save' name="add_course" style="margin-left:25%;margin-top:5%"> &nbsp Save &nbsp </button>
							</form>
							<button class='btn btn-default btn-xs close1' style="margin-left:1%;margin-top:5%"> &nbsp Close &nbsp </button>
							</div>
							<?php
								if(isset($_POST['add_course'])){
									$n_ct = $_POST['new_course']; // new course title
									$n_inst  = $_POST['new_inst']; // instructor of new course
									$n_sd =  $_POST['sd']; // starting date of new course
									$n_ed = $_POST['ed'];// ending date of new course
									include('ids.php');
									$n_course_id = courseID($n_ct);
									$n_user_id = $_SESSION['username'];
									echo "New Course : ". $n_ct."<br>";
									echo "Instructor : ". $n_inst."<br>";
									echo "Starts on : ". $n_sd."<br>";
									echo "Ends on: ". $n_ed."<br>";
									
									$query=$db->prepare("insert into course_detail(course_id,course_name,instructor,start,end) values('$n_course_id','$n_ct','$n_inst','$n_sd','$n_ed')");
									$query->execute();
									$query2=$db->prepare("insert into inst_course values('$n_user_id','$n_course_id')");
									$query2->execute();
									header("refresh:0");
								}
							?>
						</section>

											<!-- Registered Trainers -->
						<section id="section-linetriangle-2">
							<p>
							<?php
								$TQ = $db->prepare("select inst_detail.* from inst_detail");
								$TQ->execute();
								$Trainers = $TQ->fetchAll();
								//print_r($Trainers);
								echo "<table class='table table-bordered table-striped'>";
									echo "<tr class='info'>";
										echo "<td>S.No.</td>";
										echo "<td>Trainer Id</td>";
										echo "<td>Name</td>";
										echo "<td>Payment Done</td>";
										echo "<td>Payment Due</td>";
										echo "<td>Total</td>";
										/* echo "<td>Full Score Board</td>"; */
									echo "</tr>";
									$sn = 1;
									foreach($Trainers as $trnr){
										echo "<tr class='brf' style='cursor:pointer'>";
											echo "<td>".$sn."</td>";
											echo "<td>".$trnr[0]."</td>";
											echo "<td>".$trnr[1]."</td>";
											echo "<td class='success'>".$trnr[5]."</td>";
											echo "<td class='danger'>".$trnr[6]."</td>";
											echo "<td>".$trnr[4]."</td>";
											/* echo "<td><img src='images/magnify.arrow.down.PNG' ></td>"; */
										echo "</tr>";
										echo "<tr class='dtl'>
												<td colspan='6'>
													<div class='panel panel-default'>
														<div class='panel-heading success text-center'><b>Phone Number</b> : ".$trnr[3]."&nbsp &nbsp &nbsp &nbsp<b>  Email ID</b> : ".$trnr[2]."</div>
														<table class='table table-striped'>
															<tr class='success'>
																<td>S.No.</td>
																<td>Courses ID</td>
																<td>Courses Name</td>
																<td>Number of Learners in the course</td>
															</tr>";
															
															try{
																$instID = $trnr[0];
																$nctq = $db->prepare("select user_course.course_id,course_name,count(user_id) from user_course,course_detail where inst_id='$instID' and course_detail.course_id=user_course.course_id group by course_id,inst_id");//number of trainee in a course under this trainer
																$nctq->execute();
																$nct = $nctq->fetchAll();
																$nlq = $db->prepare("select user_id from user_course where inst_id='$instID' group by user_id");//number of total trainee
																$nlq->execute();
																$nl = $nlq->fetchAll();
																//$nct = $nct[0];
																//print_r($nct[0]);
																$j=1;
																foreach($nct as $trn){
																	echo "<tr>
																			<td>".$j."</td>
																			<td>".$trn[0]."</td>
																			<td>".$trn[1]."</td>
																			<td>".$trn[2]."</td>
																		</tr>";
																	$j++;
																}
															}
															catch(Exception $err){echo "Error in fetching No. of trainee. ".$err->getMessage();}
																echo "<tr class='info'>
																		<td colspan='3'>Total</td>
																		<td>".count($nl)."<small> &nbsp &nbsp (One student may has registered multiple courses.)</small></td>
																	</tr>";
														echo "</table>
													</div>
												</td>
											</tr>";
										$sn++;
									}
								echo "</table>";
							?>
							</p>
						</section>
						<section id="section-linetriangle-3">
							<?php include('inst_profile.php'); ?>
						</section>
					</div><!-- /content -->
				</div><!-- /tabs -->
			</section>
			
		
		<script src="js/cbpFWTabs.js"></script>
		<script>
			(function() {

				[].slice.call( document.querySelectorAll( '.tabs' ) ).forEach( function( el ) {
					new CBPFWTabs( el );
				});

			})();
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="../../dist/js/bootstrap.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
			<script src="../../assets/js/ie-emulation-modes-warning.js"></script>
		<script src="js/modernizr.custom.js"></script>
		<script src="js/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.edit').click(function(){
					$(this).next(".ta").show();
				});
				$('.save').click(function(){
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
					$(this).prev('.dtl').hide();
				});
			});
		</script>
	</div>

	
      <hr>

      
    </div> <!-- /container -->
	<footer align="center">
        <p>&copy; Unifiers Social Venture Pvt. Ltd. 2014</p>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
	</body>
</html>
