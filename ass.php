<?php 
	if($_SESSION['UserType']=='learner'){?>
	<table class="table table-striped" >
		<tr class="info">
			<td>S.No.</td>
			<td>Topic</td>
			<td>Weightage(%)</td>
			<td>Due Date</td>
			<td>Attempt</td>
			<td>Marks</td>
		</tr>
		<?php
		$query = $db->prepare("select quiz.* from course_quiz,quiz where course_quiz.quiz_id = quiz.quiz_id and course_quiz.course_id='$course_id'");
		$query->execute();
		$quiz=$query->fetchAll();
		
		$n = count($quiz);
		for($i=0;$i<$n;$i++){
				$id = $quiz[$i][0];
				$query=$db->prepare("select marks,attempted from user_quiz where user_id='".$_SESSION['username']."' and quiz_id='$id'");
				$query->execute();
				$marks = $query->fetch();
				$open = ($quiz[$i][4]) && ($marks[1]==0);
				
			?>
			<tr>
				<?php echo "<td>".($i+1)."</td>";
				echo "<td>".$quiz[$i][1]."</td>";
				echo "<td>".$quiz[$i][3]."</td>";
				echo "<td>".$quiz[$i][2]."</td>";?>
				<form method="post">	
					<td><button type="submit"  class="btn btn-success btn-xs" <?php echo (!$quiz[$i][4]?"disabled":"");?> name=<?php echo 'attempt'.$i?>><?php echo ($marks[1]?"View Submission":"Attempt");?></button></td>
				</form>
				<td>
					<?php echo ($marks[0])?$marks[0]:0; ?>
				</td>
				<?php
				try{
					if(isset($_POST['attempt'.$i])){
						$_SESSION['quiz_id'] = $quiz[$i][0];
						$_SESSION['quiz_title'] = $quiz[$i][1];
						$_SESSION['weightage'] = $quiz[$i][3];
						$_SESSION['due_date'] = $quiz[$i][2];
						$_SESSION['OC'] = $quiz[$i][4];
						$_SESSION['type'] = $quiz[$i][5];
						$_SESSION['attempted'] = $marks[1];
						//if($quiz[$i][5]=='t'){header("location:tquiz.php");}
						//else{header("location:finalquiz.php");}
						header("location:quiz.php");
					}
				}
				catch(Exception $err){
					echo "Eroor occure: ".$err->getMessage();
				}
				?>
			</tr>
		<?php }?>
	</table>
<?php } 
	// User is Instructor//
	else if($_SESSION['UserType']=='inst'){
		if($registered){
			?>
			<table class="table table-striped" >
			<tr class="info">
				<td>S.No.</td>
				<td>Topic</td>
				<td>Weightage(%)</td>
				<td>Due Date</td>
				<td>Status</td>
				<td>Open</td>
				<td>Close</td>
				<td>Upload/Edit</td>
			</tr>
			<?php
			$query = $db->prepare("select quiz.* from course_quiz,quiz where course_quiz.quiz_id = quiz.quiz_id and course_quiz.course_id='$course_id'");
			$query->execute();
			$quiz=$query->fetchAll();
			$n = count($quiz);
			//print_r($course);
			for($i=0;$i<$n;$i++){?>
				<tr>
					<?php 
					echo "<td>".($i+1)."</td>";
					echo "<td>".$quiz[$i][1]."</td>";
					echo "<td>".$quiz[$i][3]."</td>";
					echo "<td>".$quiz[$i][2]."</td>";
					echo "<td>".($quiz[$i][4]?"Opened":"Closed")."</td>";?>
					<form method="post" action="">
						<td><button type="submit"  class="btn btn-success btn-xs" <?php echo ($quiz[$i][4]?"disabled":"");?> name=<?php echo 'open'.$i?>>Open</button></td>
						<td><button type="submit"  class="btn btn-danger btn-xs"  <?php echo (!$quiz[$i][4]?"disabled":"");?> name=<?php echo 'close'.$i?>>Close</button></td>	
						<td><button type="submit"  class="btn btn-success btn-xs" name=<?php echo 'edit'.$i?>>View/Edit</button></td>
					</form>
					<?php
					try{
						if(isset($_POST['edit'.$i])){
							//echo "edited";
							$_SESSION['quiz_id'] = $quiz[$i][0];
							$_SESSION['quiz_title'] = $quiz[$i][1];
							$_SESSION['weightage'] = $quiz[$i][3];
							$_SESSION['due_date'] = $quiz[$i][2];
							$_SESSION['OC'] = $quiz[$i][4];
							$_SESSION['type'] = $quiz[$i][5];
							//if($quiz[$i][5]=='t'){header("location:tquiz.php");}
							//else{header("location:finalquiz.php");}
							header("location:quiz.php");
						}
						if(isset($_POST['open'.$i])){
							$qid = $quiz[$i][0];
							$query1=$db->prepare("UPDATE quiz SET status =1 WHERE quiz_id='$qid'");
							$query1->execute();
							header("Location:course.php?".$course_id);
							//echo "Wanna open.".$quiz[$i][0];
						}
						else if(isset($_POST['close'.$i])){
							$qid = $quiz[$i][0];
							$query2=$db->prepare("UPDATE quiz SET status = 0 WHERE quiz_id='$qid'");
							$query2->execute();
							header("Location:course.php?".$course_id);
							//echo "<script>location.reload();</script>";
							//echo "wanna close".$quiz[$i][0];
						}
					}
					catch(Exception $err){
						echo "Eroor occure: ".$err->getMessage();
					}
				echo "</tr>";
			}echo  "</table>";
		}
		else { echo "Please register first";}
	}
	
									////////////////////////////////// add new quiz ////////////////////////////////////////////
		if($_SESSION['UserType']=='admin'){?>			
			<table class="table table-striped" >
			<tr class="info">
				<td>S.No.</td>
				<td>Topic</td>
				<td>Weightage(%)</td>
				<td>Due Date</td>
				<td>Status</td>
				<td>Open</td>
				<td>Close</td>
				<td>Upload/Edit</td>
			</tr>
			<?php
			$query = $db->prepare("select quiz.* from course_quiz,quiz where course_quiz.quiz_id = quiz.quiz_id and course_quiz.course_id='$course_id'");
			$query->execute();
			$quiz=$query->fetchAll();
			$n = count($quiz);
			//print_r($course);
			for($i=0;$i<$n;$i++){?>
				<tr>
					<?php 
					echo "<td>".($i+1)."</td>";
					echo "<td>".$quiz[$i][1]."</td>";
					echo "<td>".$quiz[$i][3]."</td>";
					echo "<td>".$quiz[$i][2]."</td>";
					echo "<td>".($quiz[$i][4]?"Opened":"Closed")."</td>";?>
					<form method="post" action="">
						<td><button type="submit"  class="btn btn-success btn-xs" <?php echo ($quiz[$i][4]?"disabled":"");?> name=<?php echo 'open'.$i?>>Open</button></td>
						<td><button type="submit"  class="btn btn-danger btn-xs"  <?php echo (!$quiz[$i][4]?"disabled":"");?> name=<?php echo 'close'.$i?>>Close</button></td>	
						<td><button type="submit"  class="btn btn-success btn-xs" name=<?php echo 'edit'.$i?>>View/Edit</button></td>
					</form>
					<?php
					try{
						if(isset($_POST['edit'.$i])){
							//echo "edited";
							$_SESSION['quiz_id'] = $quiz[$i][0];
							$_SESSION['quiz_title'] = $quiz[$i][1];
							$_SESSION['weightage'] = $quiz[$i][3];
							$_SESSION['due_date'] = $quiz[$i][2];
							$_SESSION['OC'] = $quiz[$i][4];
							$_SESSION['type'] = $quiz[$i][5];
							//if($quiz[$i][5]=='t'){header("location:tquiz.php");}
							//else{header("location:finalquiz.php");}
							header("location:quiz.php");
						}
						if(isset($_POST['open'.$i])){
							$qid = $quiz[$i][0];
							$query1=$db->prepare("UPDATE quiz SET status =1 WHERE quiz_id='$qid'");
							$query1->execute();
							//echo "<script>location.reload();</script>";
							//echo "Wanna open.".$quiz[$i][0];
						}
						else if(isset($_POST['close'.$i])){
							$qid = $quiz[$i][0];
							$query2=$db->prepare("UPDATE quiz SET status = 0 WHERE quiz_id='$qid'");
							$query2->execute();
							//echo "<script>location.reload();</script>";
							//echo "wanna close".$quiz[$i][0];
						}
					}
					catch(Exception $err){
						echo "Eroor occure: ".$err->getMessage();
					}
				echo "</tr>";
			}echo  "</table>";
			?>
			<form class="form-horizontal" method="post" action="#">
				<button type='button' class='btn btn-primary btn-xs edit' style="margin-left:45%">  Add a New Quiz </button>
				<div class='ta' style="margin-left:10%;margin-right:10%">
					Quiz Topic/Title
					<input type="text"  name="new_quiz" class="form-control" placeholder="Quiz Topic/Title"></input><br>
					Weightage of Quiz
					<input type="int"  name="new_wt" class="form-control" placeholder="Weightage of Quiz"></input><br>
					<div class="col-sm-6">Deadline
						<input type="date" class="form-control" name="new_dd"></input>
					</div><br>
					<div class="col-sm-6"><b>Quiz Status </b>
						<input type="radio" name="new_status" value="1" > Open &nbsp
						<input type="radio" name="new_status" value="0" > Close &nbsp <br> <b>Type of Quiz</b>
						<input type="radio" name="new_type" value="t" > Topic Specific &nbsp
						<input type="radio" name="new_type" value="f" > OverAll &nbsp 
					</div><br><br>
					<button type='submit' class='btn btn-primary btn-xs save' name="add_quiz" style="margin-left:25%"> &nbsp Save Question &nbsp </button>
			</form>
			<button class='btn btn-default btn-xs close1' style="margin-left:15%"> &nbsp Close &nbsp </button>
				</div>
			<?php if(isset($_POST['add_quiz'])){
				$quiz_title = $_POST['new_quiz'];
				$n_wt = $_POST['new_wt'];
				$n_dd = $_POST['new_dd'];
				$n_sts = $_POST['new_status'];
				$n_type = $_POST['new_type'];
				$quiz_id = quizID($_POST['new_quiz'],$name);
				$query=$db->prepare("insert into quiz (quiz_id,quiz_title, due_date, weightage,status,type) values('$quiz_id','$quiz_title','$n_dd','$n_wt','$n_sts','$n_type')");
				$query->execute();
				
				$query2=$db->prepare("insert into course_quiz (course_id,quiz_id) values('$course_id','$quiz_id')");
				$query2->execute();
				
				/* try{
					$query4=$db->prepare("select user_id from user_course where course_id='$course_id'");
					$query4->execute(); $reg_user = $query4->fetchAll();
					foreach($reg_user as $user){
						$query3=$db->prepare("insert into user_quiz(user_id,quiz_id) values('$user','$quiz_id')");
						$query3->execute();
					}
				}catch(Exception $err){echo "Error in User_Quiz: ".$err->getMessage();} */
				header("refresh:0");
			}
	
	} ?>