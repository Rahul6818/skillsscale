<?php
	$Dquery=$db->prepare("select inst_detail.* from inst_detail where inst_id='$username'");
	$Dquery->execute();
	$details = $Dquery->fetchAll();
echo "<div class='row'>
		<div class='col-sm-2'>
		</div>
		<div class='col-sm-8'>";
if(count($details)>0){?>
		<div class="input-group input-group-lg">
  			<span class="input-group-addon">Username</span>
  			<?php echo "<input type='text'  class='form-control' value='".$details[0][0]."' disabled>";?>
		</div><br>
		<div class="input-group" >
  			<span class="input-group-addon" >Name</span>
  			<?php echo "<input type='text' class='form-control' id='Cname' value='".$details[0][1]."'>";?>
		</div><br>
		<div class="input-group">
  			<span class="input-group-addon">Email ID</span>
  			<?php echo "<input type='text' class='form-control' id='Cid' value='".$details[0][2]."'>";?>
		</div><br>
		<div class="input-group" >
  			<span class="input-group-addon" >Mobile Number</span>
  			<?php echo "<input type='text' class='form-control'  id='Cno' value='".$details[0][3]."'>";?>
		</div><br>
		<div class="input-group" >
  			<span class="input-group-addon" >Address</span>
  			<?php echo "<textarea class='form-control' id='Cadd'>".$details[0][7]."</textarea>";?>
		</div><br>
		
<?php } 
else {?>
		<div class="input-group input-group-lg">
  			<span class="input-group-addon">Username</span>
  			<?php echo "<input type='text'  class='form-control' value='".$_SESSION['username']."' disabled>";?>
		</div><br>
		<div class="input-group" >
  			<span class="input-group-addon" >Name</span>
  			<?php echo "<input type='text' class='form-control' id='Cname'>";?>
		</div><br>
		<div class="input-group">
  			<span class="input-group-addon">Email ID</span>
  			<?php echo "<input type='text' class='form-control' id='Cid'>";?>
		</div><br>
		<div class="input-group" >
  			<span class="input-group-addon" >Mobile Number</span>
  			<?php echo "<input type='text' class='form-control'  id='Cno'>";?>
		</div><br>
		<div class="input-group" >
  			<span class="input-group-addon" >Address</span>
  			<?php echo "<textarea class='form-control' id='Cadd'></textarea>";?>
		</div><br>
<?php }?>	
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
						<input type="password" placeholder="Old Password" id="oldPass" class="form-control" name="oldPass">
					</div>
					<div class="form-group">
						<input type="password" placeholder="New Password" id="newPass" class="form-control" name="newPass" >
					</div>					
					<div class="form-group">
						<input type="password" placeholder="Retype New Password" id="rNewPass" class="form-control" name="rNewPass" >
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
		var Name = document.getElementById('Cname').value;
		var ID = document.getElementById('Cid').value;
		var MNo = document.getElementById('Cno').value;
		var ADDRR = document.getElementById('Cadd').value;
		var dataString = 'Cname=' + Name + '&Cid=' + ID + '&Cno=' + MNo + '&Cadd=' + ADDRR;
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
		var oldPass = document.getElementById('oldPass').value;
		var newPass = document.getElementById('newPass').value;
		var rNewPass = document.getElementById('rNewPass').value;
		if((newPass=="" || rNewPass=="") || oldPass==""){$("#wrng").html("Please fill all fields");}
		else{
			if(newPass!=rNewPass){$("#wrng").html("New Passwords didn't match");}
			else if(newPass.length<6){$("#wrng").html("New Passwords must be greater than 5 in length");}
			else{
				dataString = 'oldPass=' + oldPass +'&newPass=' + rNewPass;
				$.ajax({
					type: 	'POST',
					url:	'login_ajax.php',
					data:    dataString,
					cache: 	false,
					success: function(result){
						if( result == -1){$("#wrng").html("Old password id wrong.");}
						else if(result == 1){alert("Password Successfully Changed");window.location.assign(window.location.href);}

					}
				})
			}
		}
	});
</script>