

<!------------ Header starts --------------------->
<?php 
include('../includes/header.php'); 
include ('../Controller/register_validation.php');
include('../Controller/register_controller.php');
?>
<!------------ Header ends ----------------------->

<!------------ Content wrapper starts -------------->
<div class="content_wrapper">
    
<script>
//  $(document).ready(function(){
  
//   $("#password_confirm2").on('keyup',function(){   
   
//    var password_confirm1 = $("#password_confirm1").val();
   
//    var password_confirm2 = $("#password_confirm2").val();
   
//    //alert(password_confirm2);
   
//    if(password_confirm1 == password_confirm2){
   
//     $("#status_for_confirm_password").html('<strong style="color:green">Password match</strong>');
   
//    }else{
//     $("#status_for_confirm_password").html('<strong style="color:red">Password do not match</strong>');
   
//    }
   
//   });
  
//  });
</script>
<!-- <script src="../js/checkuser.js"></script> -->
<script src="../js/Signup_val.js"></script>
<div class="register_box">

	<form method = "post" onsubmit="return validate()" action="" enctype="multipart/form-data">

		<table align="left" width="70%">
			<h5><?php echo $err_db; ?></h5>
			<tr align="left">	   
				<td colspan="4">
				<h2>Register.</h2><br />
				<span>
					Already have account? <a href="index.php?action=login">Login Now.</a><br /><br />
				</span>
				</td>	   
			</tr>
			
			<tr>
				<td width="15%"><b>Name:</b></td>
				<td colspan="3"><input type="text" name="name" id="name"  value="<?php echo $name;?>" placeholder="Name" /> <br>
				<span id="err_name" style="color:red;"><?php echo $err_name;?></span></td>
			</tr>
			
			<tr>
				<td width="15%"><b>Email:</b></td>
				<td colspan="3"><input type="text" name="email" id="e_email" onfocusout="checkUseremail(this)" value="<?php echo $email;?>" placeholder="Email" /> <br>
				<span id="er_email" style="color:red;"><?php echo $err_email;?></span> </td>
			</tr>
			
			<tr>
				<td width="15%"><b>Password:</b></td>
				<td colspan="3"><input type="password" id="password_confirm1" name="password" value="<?php echo $password;?>" placeholder="Password" /><br>
				<span id="err_pass" style="color:red;"><?php echo $err_pass;?></span></td>
			</tr>
			
			<tr>
				<td width="15%"><b>Confirm Password:</b></td>
				<td colspan="3"><input type="password" id="password_confirm2" name="confirm_password" value="<?php echo $confirm_password;?>"  placeholder="Confirm Password" />
				<br><span id="err_con_pass" style="color:red;"><?php echo $err_conpass;?></span> <br>
				<p id="status_for_confirm_password"></p><!-- Showing validate password here --> 
				</td>
			</tr>
			
			<tr>
				<td width="15%"><b>Image:</b></td>
				<td colspan="3"><input type="file" name="image" id="u_image" /> 
				<br><span id="err_i_image" style="color:red;"></span></td>
			</tr>
			
			<tr>
				<td width="15%"><b>Country:</b></td>
				<td colspan="3">
					<?php include('../includes/country_list.php'); ?> 	  
				</td>
			</tr>
			
			<tr>
				<td width="15%"><b>City:</b></td>
				<td colspan="3"><input type="text" name="city"id="c_city" value="<?php echo $city; ?>" placeholder="City" /><br>
				<span id="err_c_city" style="color:red;"><?php echo $err_city;?></span></td>
			</tr>
			
			<tr>
				<td width="15%"><b>Contact:</b></td>
				<td colspan="3"><input type="text" name="contact" id="c_contact" value="<?php echo $contact; ?>" placeholder="Contact" />
				<br><span id="err_c_contact" style="color:red;"><?php echo $err_contact;?></span></td>
			</tr>
			
			<tr>
				<td width="15%"><b>Address:</b></td>
				<td>: <textarea id="address" name="address"><?php echo $address;?></textarea>
					<br><span id="err_address" style="color:red;"><?php echo $err_add;?></span>
				</td>
			</tr>

			<tr align="left">
				<td></td>
				<td colspan="4">
				<input type="submit" name="register" value="Register" />
				</td>
			</tr>
			
		</table>

	</form>

</div>


	
</div><!-- /.content_wrapper-->

<!------------ Content wrapper ends -------------->
  
<?php include ('../includes/footer.php'); ?>
  
   
