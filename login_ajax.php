<?php
session_start();
try{
	$db = new PDO("mysql:host=localhost;dbname=test","rahul","12345");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);					
}
catch(Exception $error){
	die("Connection Faild : ".$error -> getMessage());
}
				
try{
	if(isset($_POST['namel'])){
		$username = $_POST['namel'];
		$password = $_POST['passl'];
		$query = $db->prepare("SELECT user_id FROM user_auth WHERE user_id='$username' and password='$password' ");
		$query->execute();
		$row = $query->fetch();
		if($row[0]){
			$_SESSION['username'] = $username;
			$_SESSION['UserType'] = 'learner';
			//header("Location: welcome.php");
			echo "L";
		}
		else{echo "0";}
	}
	else if(isset($_POST['namei'])){
		$username = $_POST['namei'];
		$password = $_POST['passi'];
		$query = $db->prepare("SELECT user_id FROM inst_auth WHERE user_id='$username' and password='$password' ");
		$query->execute();
		$row = $query->fetch();
		if($row[0]){
			$_SESSION['username'] = $username;
			if($username=='admin'){$_SESSION['UserType'] = 'admin';echo "2";}
			else{$_SESSION['UserType'] = 'inst';echo "1";}
			//header("Location: welcome.php");
		}
		else{echo "0";}
	}
}
catch(Exception $error){
	echo "User not found". $error -> getMessage();
}

if(isset($_POST['Nuname'])){
	try{
		try{
			$userAuth = $db->prepare("insert into user_auth(user_id,password) values(?,?)");
			$userAuth->execute(array($_POST['Nuname'],$_POST['Nupass']));
		}
		catch(Exception $err){
			echo -1;
		}
					
		// insertion into user_details
		$userDetails = $db->prepare("insert into user_details(user_id) values(?)");
		$userDetails->execute(array($_POST['Nuname']));
		
		// insertion into user_course
		$userCourse = $db->prepare("insert into user_course(user_id,course_id,inst_id) values(?,?,?)");
		$userCourse->execute(array($_POST['Nuname'],$_SESSION['course_id'],$_SESSION['username'])); 
		echo 1;
	}
	catch(Exception $err){
			echo -2;
	}

}

if(isset($_POST['NS'])){
	try{
		// insertion into user_course
		$userCourse = $db->prepare("insert into user_course(user_id,course_id,inst_id) values(?,?,?)");
		$userCourse->execute(array($_POST['NS'],$_SESSION['course_id'],$_SESSION['username'])); 
		echo 1;	
	}
	catch(Exception $err){
			echo -2;
	}
}
if(isset($_POST['Cname'])){
	try{
		$query = "insert into inst_detail (inst_id,name,email,phone_no,address) values('".$_SESSION['username']."','".$_POST['Cname']."','".$_POST['Cid']."' ,'".$_POST['Cno']."' ,'".$_POST['Cadd']."') ON DUPLICATE KEY UPDATE  name='".$_POST['Cname']."', email='".$_POST['Cid']."' ,phone_no='".$_POST['Cno']."' ,address='".$_POST['Cadd']."' ;";
		$updtDtl = $db->prepare($query);
		//echo $query."\n";
		$updtDtl->execute();
		echo 1;
	}
	catch(Exception $err){
		die("Connection Faild : ".$err -> getMessage());
		echo -2;
	}
}


if(isset($_POST['oldPass'])){
	try{
		$changePass = $db->prepare("select inst_auth.* from inst_auth where password='".$_POST['oldPass']."' and user_id='".$_SESSION['username']."'");
		$changePass-> execute();
		if(count($changePass->fetchAll())==0){echo -1;}
		else{
			$newPQ = $db->prepare("update inst_auth set password='".$_POST['newPass']."' where user_id='".$_SESSION['username']."'");
			$newPQ->execute();
			echo 1;
		}
	}
	catch(Exception $err){
		echo -2;
	}
}

if(isset($_POST['LCname'])){
	try{
		$updtDtl = $db->prepare("insert into user_details (user_id,name,email,phone_no,address) values('".$_SESSION['username']."','".$_POST['LCname']."','".$_POST['LCid']."' ,'".$_POST['LCno']."' ,'".$_POST['LCadd']."') ON DUPLICATE KEY UPDATE 
		name='".$_POST['LCname']."', email='".$_POST['LCid']."' ,phone_no='".$_POST['LCno']."' ,address='".$_POST['LCadd']."' ;");
		$updtDtl->execute();
		echo 1;
	}
	catch(Exception $err){
		echo -2;
	}
}

if(isset($_POST['LoldPass'])){
	try{
		$changePass = $db->prepare("select user_auth.* from user_auth where password='".$_POST['LoldPass']."' and user_id='".$_SESSION['username']."'");
		$changePass-> execute();
		if(count($changePass->fetchAll())==0){echo -1;}
		else{
			$newPQ = $db->prepare("update user_auth set password='".$_POST['LnewPass']."' where user_id='".$_SESSION['username']."'");
			$newPQ->execute();
			echo 1;
		}
	}
	catch(Exception $err){
		echo -2;
	}
}
?>