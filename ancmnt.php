<p>
	<?php
	if($_SESSION['UserType']=='inst'){
		if($registered){echo $_SESSION['announcement'];}
		else { echo "Please register first";}
	}
	else if($_SESSION['UserType']=='learner'){echo $_SESSION['announcement'];}
	else if($_SESSION['UserType']=='admin'){
		echo $announcement;?>
		<form class="form-horizontal" method="post"><br>
			<button type='button' class='btn btn-primary btn-xs edit' name='edit'> &nbsp Edit &nbsp </button>
			<div class='ta' >
				<textarea  name='announcement' placeholder='Course announcement'><?php echo $announcement ?></textarea><br>
				<button type='submit' class='btn btn-primary btn-xs save' name='save2'> &nbsp Save &nbsp </button>
		</form>
		<button class='btn btn-default btn-xs close1' style="margin-left:1%"> &nbsp Close &nbsp </button>
			</div>
		<?php 
		if(isset($_POST['save2']) && ($_POST['announcement']!=$announcement)){
			//$temp = $announcement;
			$announcement =  str_replace("'",';apos',$_POST['announcement']);//+$temp;
			echo "Changed: <br>".$announcement;
			try{
				$statement = $db->prepare("UPDATE course_detail SET announcement = (?) WHERE course_id='$course_id'");
				$statement->execute(array($announcement));
				$_SESSION['announcement'] = $announcement;
				echo "<script>location.reload();</script>";
			}
			catch(Exception $err){
				echo "Chutiya error: ". $err->getMessage();
			}
		}
	}
	?>
</p>
						