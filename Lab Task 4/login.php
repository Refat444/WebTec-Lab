<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<style>
        body{
          margin: auto;
          width: 30%;
          padding: 20px;

        }
        .make-it-center{
          margin: auto;
          width: 50%;
        }
        .error{
        	color: red;
        }
        .required:after {
          content:"*";
          color: red;
        }
        .footer{
            text-align:center;
        }
    </style>
</head>
<body>
<?php include 'templates/header.php';?>

<?php
session_start();
$userErr = $passErr = "";
$username = $password = ""; 
$errCount = 0;

if (isset($_SESSION['uname'])) {
    header('Location: dashboard.php');
}

//username
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (empty($_POST["username"])) {
	    $userErr = "Username is required";
	    $errCount = $errCount + 1;	
	  } else {
	    $username = check_input($_POST["username"]);

	    if (strlen($username) <2 ) {
	    	$userErr = "Minimum 2 characters required";
	    	$errCount = $errCount + 1;	
	    }

	    
	    if (!preg_match("/^[a-zA-Z_\-.]*$/", $username)) {
	    	$userErr = "Username can contain alpha numeric characters, period, dash or underscore only!";
	    	$username ="";
	    	$errCount = $errCount + 1;	
	    }else{
            if (isset($_POST['rembr'])) {
                $time = time();
                setcookie('username', $username, $time + 300);
                setcookie('password', $password, $time + 300);
            }
	  }
    }

  //password
  if (empty($_POST["password"])) {
    $passErr = "Password is required";
    $errCount = $errCount + 1;	
  } else {
    $password = check_input($_POST["password"]);
  }

    //no need of these validations for checking password

  	// if (strlen($password) <8 ) {
	    	
	  //   	$passErr = "Minimum 8 characters required";
	  //   	$errCount = $errCount + 1;	
	  //   }

    // if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[%$#@]).+$/", $password)) {
    	
	  //   	$passErr .= " Password must contain atleast a digit, a lower case and an upper case letter, atleast one of the [%$#@] and no space.";
	  //   	$password ="";
	  //   	$errCount = $errCount + 1;	
	  //   }

        if ($errCount < 1){
            $time = time();
            if (isset($_POST['rembr'])) {
                setcookie('username', $username, $time + 60);
                setcookie('password', $password, $time + 60);
            }}

    //retrive password and match from json file
    if ($errCount < 1){

        $strJsonFileContents = file_get_contents("data.json");
        

        $arra = json_decode($strJsonFileContents);
        
        $user_found = false;
        foreach($arra as $item) {
            if ($username === $item->username){
                $user_found = true;
               
                if ($password === $item->password){
                    echo "Welcome $item->name,";
                    $_SESSION['uname'] = $username;
                    header('Location: dashboard.php');
                    exit;
                }else{
                    $passErr .= "Please check your password again!";
                }
            }
        }
        if (!$user_found){
            echo $userErr .= "No account found!";
        }

    }

}

  function check_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<div class="donor-info make-it-center">
<fieldset>
<legend> <b> Login</b></legend>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <label>Username:</label> 
  <input type="text" name="username" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; }?>">
  <span class="error">* <?php echo $userErr;?></span>
  <br><br>
  <label>Password:</label>  
  <input type="password" name="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; }?>">
  <span class="error">* <?php echo $passErr;?></span>
  <br><br> <hr>
  <input type="checkbox" id="rembr" name="rembr" value="True">
  <label for="rembr"> Remember Me</label>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
  <a href="/WebTechCourse/Lab task 4/forget_pass.php"> <span style="color:blue;">Forgot Password?</span> </a>

</form>
</fieldset>

</div>
</body>

<?php include 'templates/footer.php';?>
</html>