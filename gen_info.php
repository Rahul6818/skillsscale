<p><?php 
	echo $_SESSION['gen_info']; 
	if($_SESSION['UserType']=='admin'){ ?>
		<form class="form-horizontal" method="post">
			<button type='button'  id='edit' class='btn btn-primary btn-xs edit' name='edit'> &nbsp Edit &nbsp </button>
			<div class='ta' >
				<textarea  name='general' placeholder='Course Syllabus'><?php echo $gen_info ?></textarea><br>
				<button type='submit'  id='save' class='btn btn-primary btn-xs save' name='save'> &nbsp Save &nbsp </button>
		</form>
			<button class='btn btn-default btn-xs close1' style="margin-left:1%"> &nbsp Close &nbsp </button>
			</div>
		<?php if(isset($_POST['save']) && ($_POST['general']!=$gen_info)){
			$gen_info = str_replace("'",';apos',$_POST['general']);
			//echo "Changed: <br>".$gen_info;
			try{
				$statement = $db->prepare("UPDATE course_detail SET gen_info = (?) WHERE course_id='$course_id'");
				$statement->execute(array($gen_info));
				$_SESSION['gen_info'] = $gen_info;
				//printf("Affected rows (UPDATE): %d\n", $statement->rowCount());
				echo "<script>location.reload();</script>";
			}
			catch(Exception $err){
				echo "error: ". $err->getMessage();
			}
		}
	} ?>
</p>