<?php
	$query=$db->prepare("select topics.* from course_topic,topics where course_id='$course_id' and course_topic.topic_id = topics.topic_id");
	$query->execute();
	$t_d = $query->fetchAll(); // Topic Ids related to this course_id
	//print_r($t_d);
	$tn = count($t_d); ?>
	<table class="table table-striped" >
		<tr class="info">
			<td>Topic</td>
			<td>Weightage out of 100</td>
			<td></td>
		</tr>
		<?php 
		echo "<form method='post'>";
			for($k=0;$k<$tn;$k++){
				$t_id = $t_d[$k][0]; // topic id
				$t_nm = $t_d[$k][1]; // topic name
				$t_marks = $t_d[$k][2]; // topic marks
				//if($_SESSION['UserType']!='inst'){
					echo "<tr><td>".$t_nm."</td><td>".$t_marks."</td>";
				//}
				/* else{
					echo "<td><input type='text'  name='ot_$k' class='form-control' placeholder='Name of Topic' value='$t_nm'></input></td>";
					echo "<td><input type='text'  name='otw_$k' class='form-control' placeholder='Name of Topic' value='$t_marks'></input></td>";
				} */
				echo "</tr>";
			} 
			//echo "<button type='submit' class='btn btn-primary btn-xs save' name='save1'> &nbsp Save &nbsp </button>";
		echo "</form>";
	echo "</table>";
	
	//echo $syllabus;
	if($_SESSION['UserType']=='admin'){ ?>
		<!--<form class="form-horizontal" method="post"><br>
			<button type='button' class='btn btn-primary btn-xs edit' name='edit'> &nbsp Edit &nbsp </button>
			<div class='ta' >
				<textarea  name='syllabus' placeholder='Course Syllabus'><?php echo $syllabus ?></textarea><br>
				<button type='submit' class='btn btn-primary btn-xs save' name='save1'> &nbsp Save &nbsp </button>
		</form>
		<button class='btn btn-default btn-xs close1' style="margin-left:1%"> &nbsp Close &nbsp </button>
			</div>-->
			
		
		<form class="form-horizontal" method="post" action="#">
			<button type='button' class='btn btn-primary btn-xs edit' style="margin-left:45%">  Add a New Topic </button>
			<div class='ta' style="margin-left:10%;margin-right:10%">
				New Topic
				<input type="text"  name="nt" class="form-control" placeholder="Name of Topic"></input><br>
				Weightage of Topic (<100)
				<input type="int"  name="n_wt" class="form-control" placeholder="Weightage of Topic"></input><br>
				<button type='submit' class='btn btn-primary btn-xs save' name="add_topic" style="margin-left:25%"> &nbsp Save Topic&nbsp </button>
		</form>
		<button class='btn btn-default btn-xs close1' style="margin-left:15%"> &nbsp Close &nbsp </button>
									
		<?php 
		
			/*...........................................updating syllabus.........................................*/
			
			//if(isset($_POST['save1']) /* && ($_POST['syllabus']!=$syllabus) */){
				//	$syllabus = $_POST['syllabus'];
				//try{
					/* $statement = $db->prepare("UPDATE course_detail SET syllabus = (?) WHERE course_id='$course_id'");
					$statement->execute(array($syllabus));
					$_SESSION['syllabus'] = $syllabus; */
											
			
					/* 	for($j=0;$j<$tn;$j++){
						$otw = $_POST["otw_$j"];
						$ot = $_POST["ot_$j"];
						$query1=$db->prepare("updare topics set topics ='$otw', topic_name='$ot' where course_id='$course_id' and course_topic.topic_id = topics.topic_id");
						$query1->execute();
					} */
			
												
					/* echo "<script>location.reload();</script>";
				}
				catch(Exception $err){
					echo "error: ". $err->getMessage();
				}
			} */
			
			/*................................................ adding a new topic to syllabus...............................*/
			if(isset($_POST['add_topic'])){
				$t_id = courseID($_POST['nt']);
				$ntnm = $_POST['nt'];
				$ntm = $_POST['n_wt'];
				$addt=$db->prepare("insert into topics(topic_id,topic_name,marks) values(?,?,?)");
				$addt->execute(array($t_id,$ntnm,$ntm));
				
				$addtc=$db->prepare("insert into course_topic values(?,?)");
				$addtc->execute(array($course_id,$t_id));
				
				echo "<script>location.reload();</script>";
				//header("Location:rand.php");
			}
	}
										
	?>
	