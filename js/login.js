	<script src="js/bootsratp.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script>
		var wrong = "Incorrect Username or Incoorect Password";
		var shortUser = " <div class='alert alert-warning'>Username is too short. Length of username must be greater than or equal to 5.</div>";
		var unknown = " <div class='alert alert-warning'>You are not registered. Please register/sign up first.</div>";
		var userexist = " <div class='alert alert-warning'>Sorry, username already exist, please choose another username.</div>";
		
		//function logForm(){
			$('#l_signin').click(function(){
				//alert("inst wanna login");
				var uname = document.getElementById("l_user").value;
				var upass = document.getElementById("l_pass").value;
				var dataString = 'namel=' + uname + '&passl=' + upass;
				if(uname=='' || upass==''){
					alert("Please fill all fields");
				}
				else{
					$.ajax({
						type: 		"POST",
						url:  		"login_ajax.php",
						data: 		dataString,
						cache:		false,
						success:	function(result){
							if(result==0){$("#d1").html(wrong);}
							else{window.location.assign("welcome.php")}
						}
					});
				}
				return false;
			});
			$('#i_signin').click(function(){
				//alert("inst wanna login");
				var uname = document.getElementById("i_user").value;
				var upass = document.getElementById("i_pass").value;
				var dataString = 'namei=' + uname + '&passi=' + upass;
				if(uname=='' || upass==''){
					alert("Please fill all fields");
				}
				else{
					$.ajax({
						type: 		"POST",
						url:  		"login_ajax.php",
						data: 		dataString,
						cache:		false,
						success:	function(result){
							if(result==0){$("#d2").html(wrong);}
							else if(result=="I"){window.location.assign("inst.php")}
							else if(result=="A"){window.location.assign("admin.php")}
						}
					});
				}
				return false;
			});

		//}
	</script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/docs.min.js"></script>