<?php ob_start();
	if(!isset($_SESSION)){session_start();}
	$username = $_SESSION['username'];
	if($username==""){header("Location:index.php");
	exit();}
?>
    
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">ScaleSkills</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href=<?php if($_SESSION['UserType']=='inst'){echo "inst.php";} else{echo "welcome.php";}?>>Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
		<?php if(isset($_SESSION['username'])){?>
				<form class="navbar-form navbar-right" role="form" method="post" action="index.php">
					<?php if($_SESSION['UserType']=='learner'){echo "<a href='welcome.php'>";}elseif($_SESSION['UserType']=='inst') {echo "<a href='inst.php'>";}else{echo "<a href='admin.php'>";} echo $_SESSION['username']."</a>&nbsp &nbsp &nbsp"; ?>
					<button type="submit" class="btn btn-default" name="logout">Log Out</button>
				</form>
		<?php }
			else { header("Location: index.php");}
				try{
					$db = new PDO("mysql:host=localhost;dbname=test","rahul","12345");
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
				}
				catch(Exception $error){
					die("Connection Faild : ".$error -> getMessage());
				}
				?>
		  
		</div><!--/.nav-collapse -->
      </div>
    </nav>
    </nav>