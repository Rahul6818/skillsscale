<?php
	/* try{
		$db = new PDO("mysql:host=localhost;dbname=test","rahul","12345");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	}
	catch(Exception $error){
		die("Connection Faild : ".$error -> getMessage());
	}
	function isPre($q,$n,$quiz){
		$yes = false;
		for($i=0;$i<$n;$i++){
			if($q == $quiz[$i]){$yes = true;break;}
		}
		return $yes;
	}
	
	$ar = array(1,2,3,4,5,6,7,8,9);
	$n = count($ar);
	$sum=0;
	$marks=6;
	$quiz = array();
	$j=0;
	$q=-1;
	while($sum!=$marks){
		$q = rand()%$n;
		if((!isPre($q,$j,$quiz)) && (($sum+$ar[$q])<=$marks)){
			$sum = $sum+$ar[$q];
			$quiz[$j] = $q;
			$j++;
		}
	}
	for($i=0;$i<$j;$i++){
			echo $quiz[$i]."<br>";
		} */
		session_start();
		include('login.php');
		echo $_SESSION['error'];
		$query = $db->prepare("insert into user_course values('asdas','dfgd',1,1,2)");
		$query->execute();
		
		$userCourse = $db->prepare("insert into user_course(user_id,course_id) values(?,?)");
		$userCourse->execute(array('rsdsk','dfh'));
		
?>