<?php
	//session_start();
	ob_start();
	include("header.php");
	if($_SESSION['UserType']!='learner'){header("Location:index.php");}
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
	</style>
	<div class="jumbotron"  align="center">
        <h2><?php echo "Welcome Mr. ".$username ?></h2>
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
							<li><a href="#section-linetriangle-2"><span>Grade Book</span></a></li>
							<li><a href="#section-linetriangle-3"><span>Profile</span></a></li>
						</ul>
					</nav>
					<div class="content-wrap">
						<!-- list of the courses regitered -->
						<section id="section-linetriangle-1">
							<table class="table table-striped">
								<tr class="info">
									<td>Course Name</td>
									<td>Start On</td>
									<td>End On</td>
									<td></td>
								</tr>
								<?php
								try{
									$db = new PDO("mysql:host=localhost;dbname=test","rahul","12345");
									$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$username = $_SESSION['username'];
									
									$query = $db->prepare("select course_detail.course_id,course_name,gen_info,instructor,syllabus,announcement from user_course,course_detail where course_detail.course_id = user_course.course_id and user_course.user_id='$username'");
									$query->execute();
									$course=$query->fetchAll();
									$n = count($course);
									//print_r($course);
									for($i=0;$i<$n;$i++){
										echo "<tr>
											<td>".$course[$i][1]."</td>
											<td>1 Jan,2015</td>
											<td>31 March,2015</td>";
											//<a href='course.php?".$course[$i][0]."' type='submit' class='list-group-item'>".$course[$i][1]."<span class='badge'>".$course[$i][2]."</span></a>
											echo "<td><a href='course.php?".$course[$i][0]."'><button class='btn btn-success btn-xs'>Join Class</button></td>";
											?>
										</tr>
									<?php }
									
								}
								catch(Exception $error){
									die("Connection Faild : ".$error -> getMessage());
								}
								?>
							</table>
						</section>
						<!-- Gradebook of the course-->
						<section id="section-linetriangle-2"><p>
							<table class="table table-striped" id="grades">
								<tr class="info">
									<td>S.No.</td>
									<td>Course</td>
									<td>Theory</td>
									<td>Practical</td>
									<td>Total</td>
								</tr>
								<?php
									for($i=0;$i<$n;$i++){
										echo "<tr>";
											echo "<td>".($i+1)."</td>";
											echo "<td>".$course[$i][1]."</td>";
											$course_id = $course[$i][0];
												$query=$db->prepare("select theory,practical,total from user_course where user_id = '$username' and course_id='$course_id'");
												$query->execute();
												$grade = $query->fetchAll();
											
											echo "<td>".$grade[0][0]."</td>";
											echo "<td>".$grade[0][1]."</td>";
											echo "<td>".$grade[0][2]."</td>";			
											echo "</tr>";
								}?>
							</table>
							<a href="#" onclick="$('#grades').tableExport({type:'excel',escape:'false'});">Export</a>
							</p>
						</section>
						
						<!-- Profile of user-->
						<section id="section-linetriangle-3">
							<?php include("learner_profile.php"); ?>
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
	</div>

	
      <hr>

      
    </div> <!-- /container -->
	<footer align="center">
        <p>&copy; Unifiers Social Venture Pvt. Ltd. 2014</p>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
