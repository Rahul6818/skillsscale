<?php session_start();
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
			$('.save').click(function(){
				$(this).parent().hide();
			});
		});
		function ru_sure(){
			confirm("Are you sure you want to submit the quiz?");
			/* if (r == false) {
				$("input").attr('disabled','');
			} */
		}
		function myFunction() {
			var txt;
			var r = confirm("Press a button!");
			if (r == true) {
				$("input").attr('disabled',true);
			} else {
				txt = "You pressed Cancel!";
			}
			//document.getElementById("b").innerHTML = txt;
		}
		$(document).ready(function(){
			$("#save_q").click(function(){
				//document.getElementById("save_qt").innerHTML = "Congrts" ;
				$("input").attr('disabled',true);
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
	<?php include("login.php");?>
	<div class="jumbotron"  align="center">
        <h2><?php echo $quiz_title."</h2><h3>Quiz </h3>"?>
    </div>
	<div id="content">
		<div class="col-sm-3"><b>Deadline </b> : <?php echo $due_date;?> (IST) </div>
		<div class="col-sm-3"></div>
		<div class="col-sm-3"></div>
		<div class="col-sm-3"><b>Total Weightage</b> : <?php echo $weightage;?> </div><br>
		<form method="post">
			<?php // getting questions from server
			if($_SESSION['type']=='t'){
					$query=$db->prepare("select questions.* from questions, quiz_que where quiz_id='$quiz_id' and quiz_que.que_id = questions.que_id");
					$query->execute();
					$questions = $query->fetchAll();
					$n = count($questions);
							
					/////////////////////////////////////looping over each questions/////////////////////////////////////////////
					
				for($i=0;$i<$n;$i++){
					echo "<div class='panel panel-default'>";
						echo "<div class='panel-heading'>";
							echo "<div class='col-sm-9'><h3> Question ".($i+1)."</h3></div><br><div class='col-sm-3'>";
							if($questions[$i][1]=='h'){echo "<span class='label label-danger label'><abbr title='Difficulty level of this question'>Hard</abbr></span>";}
							elseif($questions[$i][1]=='m'){echo "<span class='label label-warning'><abbr title='Difficulty level of this question'>Medium</abbr></span>";}
							elseif($questions[$i][1]=='e'){echo "<span class='label label-success'><abbr title='Difficulty level of this question'>Easy</abbr></span>";}
							echo "&nbsp&nbsp<span class='label label-primary label'><abbr title='Max. Marks for this question'>".$questions[$i][8]."</abbr></span>";
		
							echo "</div><br><br><div>".$questions[$i][2]."</div>";
							
							?>
								
						</div>
						<div class="panel-body">
							<input type="radio" class="ans" name=<?php echo 'ans'.$i;?> value="1"> <?php echo str_replace("<p>","",$questions[$i][3]);?>
							<input type="radio" class="ans" name=<?php echo 'ans'.$i;?> value="2"> <?php echo str_replace("<p>","",$questions[$i][4]);?>
							<input type="radio" class="ans" name=<?php echo 'ans'.$i;?> value="3"> <?php echo str_replace("<p>","",$questions[$i][5]);?>
							<input type="radio" class="ans" name=<?php echo 'ans'.$i;?> value="4"> <?php echo str_replace("<p>","",$questions[$i][6]);?>	
						</div>
					</div>
				<?php 
				
					//////////////////////////// if user is instructor he can edit the questions/////////////////////////////////////////////////
					
					if($_SESSION['UserType']=='inst'){?>						
						<form class="form-horizontal" method="post" action="#">
							<button type='button' class='btn btn-primary btn-xs edit' name='edit'> &nbsp Edit Question &nbsp </button>
							<div class='ta'>
								<textarea  name=<?php echo "que".$i.">".$questions[$i][2] ;?></textarea><br>
								Option 1
								<textarea  name=<?php echo "o1_".$i.">".$questions[$i][3];?></textarea><br>
								Option 2
								<textarea  name=<?php echo "o2_".$i.">".$questions[$i][4];?></textarea><br>
								Option 3
								<textarea  name=<?php echo "o3_".$i.">".$questions[$i][5];?></textarea><br>
								Option 4
								<textarea  name=<?php echo "o4_".$i.">".$questions[$i][6];?></textarea><br>
								<div class="col-sm-6">
								<b>Difficulty Level: </b>
									<input type="radio" name=<?php echo "level".$i;?> value="h" <?php if($questions[$i][1]=='h'){echo "checked";}?>> Hard &nbsp
									<input type="radio" name=<?php echo "level".$i;?> value="m" <?php if($questions[$i][1]=='m'){echo "checked";}?>> Medium &nbsp
									<input type="radio" name=<?php echo "level".$i;?> value="e" <?php if($questions[$i][1]=='e'){echo "checked";}?>> Easy &nbsp
								
								<b>Currect Answer: </b>
									<input type="radio" name=<?php echo "ca".$i;?> value="1" <?php if($questions[$i][7]==1){echo "checked";}?> > 1  
									<input type="radio" name=<?php echo "ca".$i;?> value="2" <?php if($questions[$i][7]==2){echo "checked";}?> > 2
									<input type="radio" name=<?php echo "ca".$i;?> value="3" <?php if($questions[$i][7]==3){echo "checked";}?> > 3
									<input type="radio" name=<?php echo "ca".$i;?> value="4" <?php if($questions[$i][7]==4){echo "checked";}?>> 4
								</div>
								<div class="col-sm-6">
								<b>Marks</b>
								<input  name=<?php echo "marks".$i;?> type="text" <?php echo "value=".$questions[$i][8];?>><br>
								<?php
									$query=$db->prepare("select topics.* from course_topic,topics where course_id='$course_id' and course_topic.topic_id = topics.topic_id");
									$query->execute();
									$t_d = $query->fetchAll(); // Topic Ids related to this course_id
									//print_r($t_d);
									$tn = count($t_d);
									echo "<b>Related Topics</b>";
									echo "<select name='topic_$i'><option>Selected the Related Topic</option>";
									//echo echo "<option value='$t_id'>".$t_d[]."</option>";
									for($k=0;$k<$tn;$k++){
										$t_id = $t_d[$k][0]; // topic id
										$t_nm = $t_d[$k][1]; // topic name
										echo "<option value='$t_id'>".$t_nm."</option>";
									}
									echo "</select>";
								?>
								</div>
								<button type='submit' class='btn btn-primary btn-xs save' name=<?php echo "save".$i?>> &nbsp Save Changes &nbsp </button>
						</form>
						<button class='btn btn-default btn-xs save' style="margin-left:1%"> &nbsp Close &nbsp </button>
						</div>
						
						<?php if(isset($_POST['save'.$i])){
							
							$question = $_POST['que'.$i];
							$o1 = $_POST['o1_'.$i];
							$o2 = $_POST['o2_'.$i];
							$o3 = $_POST['o3_'.$i];
							$o4 = $_POST['o4_'.$i];
							$level = $_POST['level'.$i];
							$ca = $_POST['ca'.$i];
							$marks = $_POST['marks'.$i];
							$tpc = $_POST['topic_'.$i];
							try{ $que_id = $questions[$i][0];
								$query=$db->prepare("UPDATE questions SET level='$level',content='$question',o1='$o1',o2='$o2',o3='$o3',o4='$o4',ans='$ca',marks='$marks',topic_id='$tpc' WHERE que_id='$que_id' ");
								$query->execute();
								header("refresh:0");
								//printf("Affected rows (UPDATE): %d\n", $query->rowCount());
							}
							catch(Exception $err){echo "Error happens : ".$err->getMessage();}
						}
					}
				}
			}
			
			// If quiz type is overall quiz
			if($_SESSION['type']=='f' ){
				//echo "already submitted: ".(!isset($_POST['submit']))."<br>";
				$query0=$db->prepare("select topics.* from course_topic,topics where course_id='$course_id' and course_topic.topic_id = topics.topic_id");
				$query0->execute();
				$t_d = $query0->fetchAll(); // Topic Ids related to this course_id
				$t = count($t_d);
				
				$n = 0; // number of qestions in the quiz
				$ans = array(); //  correct answers of all questions in the quiz
				$all_marks = array(); //  marks alloted to each question in the quiz
				$questions = array(); // all questions in the quiz
				$q = 0; // variable for iteration on the question in the quiz
					
				for($i=0;$i<$t;$i++){    // iterating  over each topic
					$t_id = $t_d[$i][0]; // topic id
					$marks = $t_d[$i][2]; // tipic marks
					$t_nm = $t_d[$i][1]; // topic name
					
					$query2=$db->prepare("select questions.* from questions where topic_id='$t_id' ");
					$query2->execute();
					$q_dset = $query2->fetchAll(); // set of question with all details related to ith topic
					$q_set=array();
					$qn = count($q_dset);
					//print_r($q_dset);
					
					if($qn>0){ // iterating over set of questions of ith topic
						$q_set = array_column($q_dset, 8); // marks alloted to each question
						//echo "set of questions:  =>" ;print_r($all_marks);echo "<br>";
						
						//print_r($q_set);
						echo "<br>";
						$final_ques = rand_ques($qn,$q_set,$marks);
						$n = $n+count($final_ques);
						//print_r($final_ques);
						for($i=0;$i<count($final_ques);$i++){  // printing selected questions
							//echo $final_ques[$i]."<br>";
							$q_id = $q_dset[$final_ques[$i]][0];
							$query=$db->prepare("select questions.* from questions where que_id='$q_id'");
							$query->execute();
							$question = $query->fetchAll();
							//print_r($question);
							$questions[$q] = $question;$q++;
							//$ans[$q] = $question[0][7];
							//$all_marks[$q] = $question[0][8];
							
							echo "<div class='panel panel-default'>";
								echo "<div class='panel-heading'>";
									echo "<div class='col-sm-9'><h3> Question ".($i+1)."</h3></div><br><div class='col-sm-3'>";
										if($question[0][1]=='h'){echo "<span class='label label-danger label'><abbr title='Difficulty level of this question'>Hard</abbr></span>&nbsp";}
										elseif($question[0][1]=='m'){echo "<span class='label label-warning'><abbr title='Difficulty level of this question'>Medium</abbr></span>&nbsp";}
										elseif($question[0][1]=='e'){echo "<span class='label label-success'><abbr title='Difficulty level of this question'>Easy</abbr></span>&nbsp";}
									echo "<span class='label label-success'><abbr title='Question is Related to ".$t_nm."'>".$t_nm."</abbr></span>";
									//echo "";
									echo "&nbsp&nbsp<span class='label label-primary label'><abbr title='Max. Marks for this question'>".$question[0][8]."</abbr></span>";
									/* if($_SESSION['UserType']=='inst'){echo "&nbsp&nbsp<button class='btn btn-primary btn-xs edit' >Edit</button>";} */
									echo "</div><br><br><div>".$question[0][2]."</div>";
									//echo "Marks: ".$questions[$i][8];
									?>		
								</div>
								<div class="panel-body">
									<input type="radio" class="ans" name=<?php echo 'ans'.$i;?> value="1"> <?php echo str_replace("<p>","",$question[0][3]);?>
									<input type="radio" class="ans" name=<?php echo 'ans'.$i;?> value="2"> <?php echo str_replace("<p>","",$question[0][4]);?>
									<input type="radio" class="ans" name=<?php echo 'ans'.$i;?> value="3"> <?php echo str_replace("<p>","",$question[0][5]);?>
									<input type="radio" class="ans" name=<?php echo 'ans'.$i;?> value="4"> <?php echo str_replace("<p>","",$question[0][6]);?>	
								</div>
							</div>
					<?php
						}
					}
				}
			}
			/////////////////////////////////////// addition of new question by instructor only ////////////////////////////
			
			if($_SESSION['UserType']=='inst' && $_SESSION['type']=='t'){?>
				<form class="form-horizontal" method="post" action="#">
						<button type='button' class='btn btn-primary btn-xs edit' name='edit' style="margin-left:80%">  Add Question </button>
						<div class='ta'>
							Question
							<textarea  name="new_que"></textarea><br>
							Option 1
							<textarea  name="new_o1"></textarea><br>
							Option 2
							<textarea  name="new_o2"></textarea><br>
							Option 3
							<textarea  name="new_o3"></textarea><br>
							Option 4
							<textarea  name="new_o4"></textarea><br>
							<div class="col-sm-6">
							<b>Difficulty Level: </b>
								<input type="radio" name="new_level" value="h" > Hard &nbsp
								<input type="radio" name="new_level" value="m" > Medium &nbsp
								<input type="radio" name="new_level" value="e" > Easy &nbsp
							<b>Currect Answer: </b>
								<input type="radio" name="new_ca" value="1" > 1  
								<input type="radio" name="new_ca" value="2" > 2
								<input type="radio" name="new_ca" value="3" > 3
								<input type="radio" name="new_ca" value="4" > 4
							</div>
							<div class="col-sm-6">
								<b>Marks</b>
								<input  name="new_marks" type="text"><br>
								<?php
									$query=$db->prepare("select topics.* from course_topic,topics where course_id='$course_id' and course_topic.topic_id = topics.topic_id");
									$query->execute();
									$t_d = $query->fetchAll(); // Topic Ids related to this course_id
									//print_r($t_d);
									$tn = count($t_d);
									echo "<b>Related Topics</b>";
									echo "<select name='n_topic'><option>Selected the Related Topic</option>";
									//echo echo "<option value='$t_id'>".$t_d[]."</option>";
									for($k=0;$k<$tn;$k++){
										$t_id = $t_d[$k][0]; // topic id
										$t_nm = $t_d[$k][1]; // topic name
										echo "<option value='$t_id'>".$t_nm."</option>";
									}
									echo "</select>";
								?>
							</div>
							<button type='submit' class='btn btn-primary btn-xs save' name="new_save" style="margin-left:70%;margin-top:5%"> &nbsp Save Question &nbsp </button>
					</form>
					<button class='btn btn-default btn-xs save' style="margin-left:1%;margin-top:5%"> &nbsp Close &nbsp </button>
					</div>
				<?php if(isset($_POST['new_save'])){
					$n_question = str_replace("'",';apos',$_POST['new_que']);
					$n_o1 = str_replace("'",';apos',$_POST['new_o1']);
					$n_o2 = str_replace("'",';apos',$_POST['new_o2']);
					$n_o3 = str_replace("'",';apos',$_POST['new_o3']);
					$n_o4 = str_replace("'",';apos',$_POST['new_o4']);
					$n_level = $_POST['new_level'];
					$n_ca = $_POST['new_ca'];
					$n_marks = $_POST['new_marks'];
					$n_que_id = queID($quiz_id,$n);
					$n_topic = $_POST['n_topic'];
					//echo $n." --> ".$n_que_id."<br>";
					try{
						$query=$db->prepare("insert into questions (que_id,level,content,o1,o2,o3,o4,ans,marks,topic_id) values('$n_que_id','$n_level','$n_question','$n_o1','$n_o2','$n_o3','$n_o4','$n_ca','$n_marks','$n_topic')");
						$query->execute();
						$query2 = $db->prepare("insert into quiz_que (quiz_id,que_id) values('$quiz_id','$n_que_id')");
						$query2->execute();
						//echo "<script>location.reload(true);</script>";
						header("refresh:0");
						//printf("Affected rows (UPDATE): %d\n", $query->rowCount());
					}
					catch(Exception $err){echo "Error happens : ".$err->getMessage();}
				}	
				
			 }
			
			///////////////////////////////// learner submits the answers //////////////////////////////////////////
		if(isset($_POST['submit'])){
			//$ans = array_column($questions, 7); // ans of all questions
			//$all_marks = array_column($questions, 8); // marks alloted to each question
			//$all_marks = array_column($questions, 9); // marks alloted to each question
			$n = count($questions);
			echo "<div class='alert alert-success'>Your quiz is successfuly submitted. Your answers are - </div>";
			$total=0;
			try{
				//print_r($ans);
				
				echo '<table class="table table-striped" >';
				echo "<tr class='info'><td>Question</td><td>Your Ans</td><td>Correct Ans</td><td>Marks</td></tr>";
				for($j=0;$j<$n;$j++){
						$u_ans=0;$uq_mark=0;
						if(isset($_POST["ans".$j])){
							$u_ans = $_POST["ans".$j];
							echo "<tr><td>".($j+1)."</td><td>".$u_ans."</td><td>".$questions[$j][7]."</td>";
							if($u_ans == $questions[$j][7]){echo "<td>".$questions[$j][8] ."</td></tr>";$total=$total+$questions[$j][8]; $uq_mark = $questions[$j][8];}
							else {echo "<td>". 0 ."</td></tr>";}
						}
						else{
							echo "<tr><td>".($j+1)."</td><td>Not Answered</td><td>".$questions[$j][7]."</td>";
							echo "<td>". 0 ."</td></tr>";
						}
					try{
						$u_que=$db->prepare("insert into user_que (user_id,que_id,ans,marks) values(?,?,?,?)");
						$u_que->execute(array($username,$questions[$j][0],$u_ans,$uq_mark));
					}
					catch(Exception $err){
						echo $err->getMessage()." You have submitted the quiz already";
					}
				}
				echo "</table>";
				echo "Total: ".$total;
				$query2=$db->prepare("UPDATE user_quiz SET marks='$total',attempted=1 WHERE user_id='$username' and quiz_id='$quiz_id'");
				$query2->execute();
				$query4=$db->prepare("select theory,total from user_course where user_id='$username' and course_id='$course_id'");
				$query4->execute();
				$prev = $query4->fetchAll();$overall_total = $total+$prev[0][1];$theory = $total+$prev[0][0];
				$query3=$db->prepare("UPDATE user_course SET theory='$theory', total='$overall_total' WHERE user_id='$username' and course_id='$course_id'");
				$query3->execute();
				
				echo "<script>$('input').attr('disabled',true);</script>";
			}
			catch(Exception $err){
				echo "Error Found : ". $err->getMessage();
			}
		}
		
		/////////////////////////////// Submit the quiz ////////////////////////////////////////////
		else {
			if ($_SESSION['UserType']!='inst'){
				//echo "<div id='save_qt'>hi</div>";
				echo "<button type='submit' class='btn btn-success' name='submit' onclick='ru_sure()'>Submit</button></form>";	
			}
		}
	?>
	
	</div>
	<footer align="center">
        <p>&copy; Unifiers Social Venture Pvt. Ltd. 2014</p>
    </footer>

</body>
</html>