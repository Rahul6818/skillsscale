<?php
	include('index.php');
	include('serverConnect.php');
?>
<div class="container">
	<div class="list-group col-sm-4">
		<?php
			$query = $db->prepare("select course_detail.course_id,course_name,count(user_course.course_id) from course_detail,user_course where course_detail.course_id=user_course.course_id group by user_course.course_id");
			$query->execute();
			$course=$query->fetchAll();
			$n = count($course);
			//print_r($course);
			// $query2 = $db->prepare("select course_id,count(user_id) from user_course group by user_id");
			// $query2->execute();
			// $course_strength = $query2->fetchAll();
			for($i=0;$i<$n;$i++){
				if(isset($_SESSION['username'])){echo "<a href='ncourse.php?".$course[$i][0]."' type='submit' class='list-group-item'>".$course[$i][1]."<span class='badge'>".$course[$i][2]."</span></a>";}
				else {echo "<a href='#loginModal' data-toggle='modal' data-target='#loginModal' class='list-group-item'>".$course[$i][1]."<span class='badge'>".$course[$i][2]."</span></a>";}
				//echo "<a type='submit'  class='btn btn-success btn-xs' name="."'join'".$i.">Go to Class</button>";
				if(isset($_POST['join'.$i])){
					$_SESSION['course_id'] = $course[$i][0];
					$_SESSION['name'] = $course[$i][1];
					$_SESSION['gen_info'] = $course[$i][3];
					$_SESSION['inst'] = $course[$i][2];
					$_SESSION['syllabus'] = $course[$i][4];
					$_SESSION['announcement'] = $course[$i][5];
					header("location:course.php");
				}
			}

		?>
	</div>
</div>