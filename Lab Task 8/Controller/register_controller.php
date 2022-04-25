<?php 

if(isset($_POST['register']))
{  
	if(!$hasError)
	{
		if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['name'])){
		$ip = get_ip();
	$name = $_POST['name'];
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$hash_password = $password;
	$confirm_password = trim($_POST['confirm_password']);
	
	$image = $_FILES['image']['name'];
	$image_tmp = $_FILES['image']['tmp_name'];
	$country = $_POST['country'];
	$city = $_POST['city'];
	$contact = $_POST['contact'];
	$address = $_POST['address'];
	
	$check_exist = mysqli_query($con,"select * from ecustomer where email = '$email'");
	
	$email_count = mysqli_num_rows($check_exist);
	
	$row_register = mysqli_fetch_array($check_exist);
	
	if($email_count > 0){
	echo "<script>alert('Sorry, your email $email address already exist in our database !')</script>";
	
	}elseif($row_register['email'] !=$email && $password == $confirm_password )
	{
	
		move_uploaded_file($image_tmp,"upload-files/$image");
		
		$run_insert = mysqli_query($con,"insert into ecustomer (ip_address,name,email,password,country,city,contact,user_address,image) values ('$ip','$name','$email','$hash_password','$country','$city','$contact','$address','$image') ");
		
		if($run_insert)
		{
			$sel_user = mysqli_query($con,"select * from ecustomer where email='$email' ");
			$row_user = mysqli_fetch_array($sel_user);
			
			$_SESSION['user_id'] = $row_user['id'] ."<br>";
				
		}
		
		$run_cart = mysqli_query($con,"select * from cart where ip_address='$ip'");
		
		$check_cart = mysqli_num_rows($run_cart);
		
		if($check_cart == 0)
		{
			$_SESSION['email'] = $email;
			echo "<script>alert('Account has been created successfully!')</script>";
			echo "<script>window.open('../View/my_account.php','_self')</script>";
		}
		else
		{
			$_SESSION['email'] = $email;
			echo "<script>alert('Account has been created successfully!')</script>";
			echo "<script>window.open('checkout.php','_self')</script>";
		}
		
	}
		} 
	}
}
?>