<?php
	ob_start();
	//session_start();
	include('index.php');
	include('serverConnect.php');
	$course_id = $_SERVER['QUERY_STRING'];
	$query = $db->prepare("select * from course_detail where course_id='$course_id'");
	$query->execute();
	$course_d = $query->fetchAll();
	$_SESSION['name'] = $course_d[0][1];
	$_SESSION['gen_info'] = $course_d[0][3];
	$_SESSION['course_id'] = $course_d[0][0];
	$_SESSION['announcement'] = $course_d[0][5];
	$_SESSION['username'] = $_SESSION['username'];
	include('editor.php');
	include('ids.php');
?>

	<div class="jumbotron"  align="center">
        <?php 
		echo "<h2>".$_SESSION['name']."</h2>";
		if($_SESSION['UserType']=='inst'){
			$registered = in_array($course_id,$_SESSION['regCrs']);
			if(!($registered) && !isset($_POST['reg'])){?>
			<form method="post" action="">
				<button type='submit' class='btn btn-primary' name='reg'> &nbsp Register &nbsp </button>
			</form>
			<?php 
			}
			if(isset($_POST['reg'])){
				echo "Your course will be activated within 24 hours.";
				$regQ = $db->prepare("insert into inst_course values(?,?)");
				$regQ ->execute(array($username,$course_id));
			}
		}
		?>
    </div>
    <div class="col-md">
		<div class="col-md-2">
			<div class="list-group">
			  	<a href="#gen_info" class="list-group-item active">General Information</a>
			  	<a href="#syllabus" class="list-group-item">Syllabus</a>
			  	<a href="#" class="list-group-item">Assessment</a>
			  	<a href="#" class="list-group-item">Anncouncement</a>
			  	<a href="#" class="list-group-item">Others</a>
			</div>
		</div>
		<div class="col-md-10">
			<div id="gen_info"><?php include('gen_info.php');?></div>
		</div>
	</div>


    
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