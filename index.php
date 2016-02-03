<?php
	include("header.php");
	include('serverConnect.php');
?>
<div class="jumbotron"  align="center">
<img src="images/slogan.gif">
</div>
<div class="container">
	<form action="">
	<div class="row">
		<div class="col-lg-6">
	    <div class="input-group">
	      <input type="text" class="form-control" placeholder="Search for Courses" name="search_Course">
	      <span class="input-group-btn">
	        	<button class="btn btn-default" type="submit"><img src="images/appbar.magnify.PNG" height="18px" width="18px"></button>
	      </span>
	    </div><!-- /input-group -->
  	</div><!-- /.col-lg-6 -->
	</div>
	</form>
	<?php
		
	?>
	<br>
	<?php
		if(isset($_POST['search'])){echo $_POST['search'];}
	?>
	
	<div class="list-group col-sm-4">
		<?php
			if(isset($_GET['search_Course'])){
				// $query=$db->prepare("select course_detail.course_id,course_name,count(user_course.course_id) from course_detail,user_course 
				// 					where (course_detail.course_name like '%".$_GET['search_Course']."%') and (course_detail.course_id=user_course.course_id) 
				// 					group by user_course.course_id");
				$query=$db->prepare("select course_id,course_name from course_detail 
									where (course_detail.course_name like '%".$_GET['search_Course']."%')");
			}
			else { 
				// $query = $db->prepare("select course_detail.course_id,course_name,count(user_course.course_id) from course_detail,user_course 
				// 						where course_detail.course_id=user_course.course_id 
				// 						group by user_course.course_id");
				$query=$db->prepare("select course_id,course_name from course_detail");
			}
			$query->execute();
			$course=$query->fetchAll();
			$n = count($course);
			if($n==0){echo "Sorry!! No we couldn't find your course."; }
			for($i=0;$i<$n;$i++){
				if(isset($_SESSION['username'])){
				//	echo "<a href='course.php?".$course[$i][0]."' type='submit' class='list-group-item'>".$course[$i][1]."<span class='badge'>".$course[$i][2]."</span></a>";
						echo "<a href='course.php?".$course[$i][0]."' type='submit' class='list-group-item'>".$course[$i][1]."</a>";
				}
				else {
				//	echo "<a href='#loginModal' data-toggle='modal' data-target='#loginModal' class='list-group-item'>".$course[$i][1]."<span class='badge'>".$course[$i][2]."</span></a>";
					echo "<a href='#loginModal' data-toggle='modal' data-target='#loginModal' class='list-group-item'>".$course[$i][1]."</a>";
				}
			}

		?>
	</div>
</div>