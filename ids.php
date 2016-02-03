<?php

function first($string){
	$x = strtok($string," ");
	$first="";
	while($x!==false){
		$first = $first.chr(ord($x));
		$x = strtok(" ");
	}
	return $first;
}
function mySum($string){
	$x = strtok($string," ");
	$sum=0;
	while($x!==false){
		$sum = $sum+(ord($x));
		$x = strtok(" ");
	}
	return $sum;
}
function courseID($course_title){
	$n = strlen($course_title);
	$x = strtok($course_title," ");
	$sm=mySum($course_title);
	$strg = first($course_title);
	return $strg.($n*$sm);
}

function quizID($quiz_title,$course_title){
	$n = strlen($quiz_title);
	$id = first($course_title).first($quiz_title).($n*mySum($quiz_title));
	return "qz".$id;
}
function queID($quiz_id,$n){
	if($n==null){return "qe".$quiz_id.(1);}
	else {return "qe".$quiz_id.($n+1);}
}

function isPre($q,$n,$quiz){
		$yes = false;
		for($i=0;$i<$n;$i++){
			if($q == $quiz[$i]){$yes = true;break;}
		}
		return $yes;
}
function rand_ques($n,$qset,$marks){
	$sum=0;
	$quiz = array();
	$j=0;
	$q=-1;
	while($sum!=$marks){
		$q = rand()%$n;
		//echo "Random Question Numeber: ".$q."<br>";
		if((!isPre($q,$j,$quiz)) && (($sum+$qset[$q])<=$marks)){
			//echo "here: ".$q;
			$sum = $sum+$qset[$q];
			$quiz[$j] = $q;
			$j++;
		}
	}
	return $quiz;
}
?>