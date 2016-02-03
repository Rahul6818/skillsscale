<?php
	//session_start();
	include("header.php");
	if($_SESSION['UserType']!='inst'){header("Location:index.php");}
	$username = $_SESSION['username'];
?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.edit').click(function(){
				$(this).next(".ta").show();
			});
			$('.save').click(function(){
				$(this).parent().hide();
			});
		});
	</script>
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
		.ta{display:none;}
	</style>
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
							<li><a href="#section-linetriangle-2"><span>Payment History</span></a></li>
							<li><a href="#section-linetriangle-3"><span>Profile</span></a></li>
						</ul>
					</nav>
					<div class="content-wrap">
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
									$username = $_SESSION['username'];
									/* $query = $db->prepare("select course_detail.course_id,course_name,gen_info,instructor,syllabus,announcement from user_course,course_detail where course_detail.course_id = user_course.course_id and user_course.user_id='$username'"); */
									$query = $db->prepare("select course_detail.course_id,course_name,gen_info,instructor,announcement,start,end from inst_course,course_detail where course_detail.course_id = inst_course.course_id and inst_course.user_id='$username'");
									$query->execute();
									$course=$query->fetchAll();
									$n = count($course);
									$courseIds = array();
									
									//print_r($course);
									for($i=0;$i<$n;$i++){
										$courseIds[$i] = $course[$i][0];
										echo "<tr>
											<td>". $course[$i][1]."</td>
											<td>".$course[$i][5]."</td>
											<td>".$course[$i][6]."</td>";
											echo "<td><a href='course.php?".$course[$i][0]."'><button class='btn btn-success btn-xs'>Join Class</button></td>";
										echo "</tr>";
									}
									$_SESSION['regCrs'] = $courseIds;
								}
								catch(Exception $error){
									die("Connection Faild : ".$error -> getMessage());
								}
								?>
							</table>
							
						</section>
						<section id="section-linetriangle-2">
							<p>
								Payment History
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
