<?php
try{
	$db = new PDO("mysql:host=localhost;dbname=test","rahul","12345");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);					
}
catch(Exception $error){
	die("Connection Faild : ".$error -> getMessage());
}
?>