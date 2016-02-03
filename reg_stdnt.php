<style>
	.dtl{
		display:none;
	}
</style>
<?php if($_SESSION['UserType']=='inst'){
	echo "<section id='section-linetriangle-3'>";
	if($registered){
		$query =$db->prepare("select user_course.* from user_course where course_id='$course_id' and inst_id='$username'");
		$query->execute();
		$reg_stdnt =$query->fetchAll();
		
		echo "<table class='table table-bordered table-striped'>";
			echo "<tr class='info'>";
				echo "<td>S.No.</td>";
				echo "<td>User Id</td>";
				echo "<td>Name</td>";
				echo "<td>Theory</td>";
				echo "<td>Practical</td>";
				echo "<td>Total</td>";
				/* echo "<td>Full Score Board</td>"; */
			echo "</tr>";
			$sn = 1;
			foreach($reg_stdnt as $stdnt){
				echo "<tr class='brf' style='cursor:pointer'>";
					echo "<td>".$sn."</td>";
					echo "<td>".$stdnt[0]."</td>";
					echo "<td>Name</td>";
					echo "<td>".$stdnt[2]."</td>";
					echo "<td>".$stdnt[3]."</td>";
					echo "<td>".$stdnt[4]."</td>";
					/* echo "<td><img src='images/magnify.arrow.down.PNG' ></td>"; */
				echo "</tr>";
				echo "<tr class='dtl'>
						<td colspan='6'>
							<div class='panel panel-default'>
								<div class='panel-heading success text-center'>Full Score Board</div>
								<table class='table table-striped'>
									<tr class='success'>
										<td>Topic</td>
										<td>Max. Marks</td>
										<td>Exam Score</td>
									</tr>";
									foreach($t_d as $tpc){
										echo "<tr>
											<td>".$tpc[1]."</td>
											<td>".$tpc[2]."</td>
											<td>";
												try{
													$scr_qury = $db->prepare("select user_que.marks from user_que,questions where questions.topic_id='$tpc[0]' and(user_que.user_id='$stdnt[0]' and user_que.que_id=questions.que_id)");
													$scr_qury -> execute();$score=$scr_qury->fetchAll();
													//print_r(array_column($score,0));
													echo array_sum(array_column($score,0)).
													"</td>
											</tr>";
												}
												catch(Exception $err){echo "pta ni kya hua ".$err->getMessage();}
									}
										echo "
								</table>
							</div>
						</td>
					</tr>";
				$sn++;
			}
		echo "</table>";
		
		//-- -------------------------addition of the new student ---------------------- -
			echo "<div class='row'>";
			echo "<div class='col-sm-3'>";
				$ESQuery=$db->prepare("select distinct user_course.user_id,name from user_course,user_details where inst_id='$username' and user_course.user_id=user_details.user_id");
				$ESQuery->execute();
				$EStdnt = $ESQuery->fetchAll();
				//print_r($EStdnt);
				echo "<select align='center' id='NS'><option value='0'>Select Learner</option>";
				foreach($EStdnt as $stdnt){
					echo "<option value='".$stdnt[0]."'>".$stdnt[1].", ".$stdnt[0]."</option> ";
				}
				echo "</select> ";
		?>
			</div>
			<div class="col-sm-1">
				<button type='button' class='btn btn-primary btn-xs' style="margin-left:5%" id='enroll'> Enroll </button>
			</div>
			</div>
		
		<form class="form-horizontal" id="addS">
			<button type='button' class='btn btn-primary btn-xs edit' style="margin-left:45%">  Add a New Student </button>
			<div class='ta' style="margin-left:10%;margin-right:10%">

				Student ID
				<input type="text"  name="ns" id="newS" class="form-control" placeholder="Please enter Student ID"></input><br>
				Password
				<input type="password"  id="p" name="np" class="form-control" placeholder="Please enter a strong password"></input><br>
				Re-Enter Password
				<input type="password"  id="rp" name="nrp" class="form-control" placeholder="Please re-enter a strong password"></input><br>
				<p id="warning"></p>
				<input type='button' onclick="addSFun()" id="add" class='btn btn-primary btn-xs save' name="add_stdnt" style="margin-left:25%" value="Submit">
		</form>

		<button class='btn btn-default btn-xs close1' style="margin-left:15%"> &nbsp Close &nbsp </button>
	
<?php 	
	// if(isset($_POST['add_stdnt'])){
	// 	if($_POST['np']==$_POST['nrp']){
	// 			$ns = $_POST['ns'];
	// 			$np = $_POST['nrp'];
	// 			try{ //insertion into use_auth
	// 				$userAuth = $db->prepare("insert into user_auth(user_id,password) values(?,?)");
	// 				$userAuth->execute(array($ns,$np));
					
	// 					// insertion into user_details
	// 					$userDetails = $db->prepare("insert into user_details(user_id) values(?)");
	// 					$userDetails->execute(array($ns));
					
	// 					// insertion into user_course
	// 					$userCourse = $db->prepare("insert into user_course(user_id,course_id,inst_id) values(?,?,?)");
	// 					$userCourse->execute(array($ns,$course_id,$username));
	// 			}
	// 			catch(Exception $error){
	// 				die("Connection Error in sudent addition : ".$error -> getMessage());
	// 			}
				
	// 		 }
	// 	}
	}
	else{echo "Register for enrolling students";}
	echo "</section>";
}
else if($_SESSION['UserType']=='learner'){
echo "<section id='section-linetriangle-3'>";
	$grd = $db->prepare("select topic_name,sum(user_que.marks) from user_que,questions,topics where (user_que.que_id = questions.que_id and questions.topic_id = topics.topic_id) and user_id='".$_SESSION['username']."' group by topics.topic_id");
	$grd->execute();
	$grdbk=$grd->fetchAll();
	//print_r(array_column($grdbk,0));
	echo "<table class='table table-bordered table-striped'>
			<tr class='info'>
				<td>S.No.</td>
				<td>Topic Name</td>
				<td>Marks</td>
			</tr>";
			$sn=1;
			foreach($grdbk as $tm){
				echo "<tr>
					<td>".$sn."</td>
					<td>".$tm[0]."</td>
					<td>".$tm[1]."</td>
				</tr>";
			}
	echo "</table>";
	echo "</section>";
}
else if($_SESSION['UserType']=='admin'){
	echo "<section id='section-linetriangle-3'>";
		
		//echo "Registered Instructors for '$course_id' :";

		$RIquery=$db->prepare("select user_id,name,activated from inst_course,inst_detail where course_id='$course_id' and user_id=inst_id");
		$RIquery->execute();
		$regInst = $RIquery->fetchAll();
		echo "<table class='table table-bordered table-striped'>
			<tr class='info'>
				<td>S.No.</td>
				<td>Instructor Id</td>
				<td>Instructor Name</td>
				<td>Activate / Deactivate</td>
			</tr>";
			$sn=count($regInst);
			for($i=0;$i<$sn;$i++){	
			//print_r(regInst[$i]);
			echo "<tr>
					<td>".($i+1)."</td>
					<td>".$regInst[$i][0]."</td>
					<td>".$regInst[$i][1]."</td>
					<td><form method='POST' action='' >";//if(regInst[$i][2]==0){echo "No</td>";}else{echo "Yes</td>";}
						if($regInst[$i][2]==0){echo "<button type='submit'  class='btn btn-danger btn-xs' name='act".$i."' value='1'>Activate</button></td>";}	
						else{echo "<button type='submit'  class='btn btn-danger btn-xs' name='act".$i."' value='0'>Deactivate</button></td>";}
					echo "</from>";
			echo "</tr>";
			if(isset($_POST['act'.$i])){
				$udtQuery = $db->prepare("update inst_course set activated='".$_POST['act'.$i]."' where user_id='".$regInst[$i][0]."' and course_id='$course_id'");
				$udtQuery->execute();
				header("Location: course.php?".$course_id);
			}
		}
		echo "</table>";
		//print_r($regInst);

	echo "</section>";
}
?>
<script type="text/javascript">
	$("#add").click(function(){
		var uname = document.getElementById("newS").value;
		var upass = document.getElementById("p").value;
		var urpass = document.getElementById("rp").value;
		if((uname=="" || upass=="") || urpass==""){alert("Please fill all fields.");}
		else{
			if(upass!=urpass){alert("Passwords did not match. Try again.");}
			else if(uname.length<6){alert("Legth of Username must be greater than 5");}
			else if(upass.length<6){alert("Legth of password must be greater than 5");}
			else{
				var dataString = 'Nuname=' + uname + '&Nupass='+urpass;
				$.ajax({
					type: 		"POST",
					url:  		"login_ajax.php",
					data: 		dataString,
					cache:		false,
					success:	function(result){
						if(result==1){
							alert(uname+" is successfully added. Refresh page to see changes");
							window.location.assign(window.location.href);
						}
						else{alert("Username already exist. Please try a new one.");}
					}
				});
			}
		}
	});
	$("#enroll").click(function(){
		var NewStudent = document.getElementById("NS").value;
		if(NewStudent==0){alert("First select a student from the list.");}
		else{
			var dataString = 'NS='+NewStudent;
			$.ajax({
				type: 		"POST",
				url: 		"login_ajax.php",
				data: 		dataString,
				cache: 		false,
				success:    function(result){
					if(result==1){alert(NewStudent+" is successfully added. Refresh page to see changes");}
					else{alert("User already registered in the course");}
				}
			});
		}
	});
</script>
