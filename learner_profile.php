<?php
	$Dquery=$db->prepare("select user_details.* from user_details where user_id='$username'");
	$Dquery->execute();
	$details = $Dquery->fetchAll();
?>

<div class='row'>
	<div class="col-sm-2">
	</div>
	<div class="col-sm-8">
		<div class="input-group input-group-lg">
  			<span class="input-group-addon">Username</span>
  			<?php echo "<input type='text'  class='form-control' value='".$details[0][0]."' disabled>";?>
		</div><br>
		<div class="input-group" >
  			<span class="input-group-addon" >Name</span>
  			<?php echo "<input type='text' class='form-control' id='LCname' value='".$details[0][4]."'>";?>
		</div><br>
		<div class="input-group">
  			<span class="input-group-addon">Email ID</span>
  			<?php echo "<input type='text' class='form-control' id='LCid' value='".$details[0][1]."'>";?>
		</div><br>
		<div class="input-group" >
  			<span class="input-group-addon" >Mobile Number</span>
  			<?php echo "<input type='text' class='form-control'  id='LCno' value='".$details[0][2]."'>";?>
		</div><br>
		<div class="input-group" >
  			<span class="input-group-addon" >Address</span>
  			<?php echo "<textarea class='form-control' id='LCadd'>".$details[0][7]."</textarea>";?>
		</div><br>
		<div class='row'>
			<div class="col-sm-6"><button class="btn btn-success" id='editP'>Save Changes</button></div>
			<div class="col-sm-6"><button class="btn btn-primary" id='changeP' data-toggle="modal" data-target="#changePass" > Change Password</button></div>
		</div>
	</div>
</div>

<div class="modal fade bs-example-modal-sm" id="changePass" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Change Password</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" style="margin:15px">
					<div class="form-group">
						<input type="password" placeholder="Old Password" id="LoldPass" class="form-control" name="oldPass">
					</div>
					<div class="form-group">
						<input type="password" placeholder="New Password" id="LnewPass" class="form-control" name="newPass" >
					</div>					
					<div class="form-group">
						<input type="password" placeholder="Retype New Password" id="LrNewPass" class="form-control" name="rNewPass" >
					</div>					
				</form>
				<p style="color:red" id="wrng"></p>
				<button class="btn btn-success" id='editPass'>Save Changes</button>
			</div>
		</div>
	</div>
</div>							

<script type="text/javascript">
	$("#editP").click(function(){
		var Name = document.getElementById('LCname').value;
		var ID = document.getElementById('LCid').value;
		var MNo = document.getElementById('LCno').value;
		var ADDRR = document.getElementById('LCadd').value;
		var dataString = 'LCname=' + Name + '&LCid=' + ID + '&LCno=' + MNo + '&LCadd=' + ADDRR;
		//alert(dataString);
		$.ajax({
				type:	'POST',
				url:	'login_ajax.php',
				data:	dataString,
				cache:	false,
				success:function(result){
					if(result==1){alert("updated Successfully");window.location.assign(window.location.href);}
					else{alert(result);}
				}
		});
	});

	$("#editPass").click(function(){
		var oldPass = document.getElementById('LoldPass').value;
		var newPass = document.getElementById('LnewPass').value;
		var rNewPass = document.getElementById('LrNewPass').value;
		if((newPass=="" || rNewPass=="") || oldPass==""){$("#wrng").html("Please fill all fields");}
		else{
			if(newPass!=rNewPass){$("#wrng").html("New Passwords didn't match");}
			else if(newPass.length<6){$("#wrng").html("New Passwords must be greater than 5 in length");}
			else{
				dataString = 'LoldPass=' + oldPass +'&LnewPass=' + rNewPass;
				$.ajax({
					type: 	'POST',
					url:	'login_ajax.php',
					data:    dataString,
					cache: 	false,
					success: function(result){
						if( result == -1){$("#wrng").html("Old password id wrong.");}
						else if(result == 1){alert("Password Successfully Changed");window.location.assign(window.location.href);}
						else{alert("Error");}

					}
				})
			}
		}
	});
</script>