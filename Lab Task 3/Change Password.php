<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Change Pasasword</title>
	<style>
        .required:after {
          content:"*";
          color: red;
        }
    </style>
</head>
<body>

<?php
$curPassErr = $newPassErr = $retypePassErr = $userErr = "";
$username = "";
$currPass = $newPass = $retypePass = "";
$errCount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"])) {
        $userErr = "Username is required to change password";
        $errCount = $errCount + 1;
    } else {
        $username = $_POST["username"];

        if ($errCount < 1){
            $strJsonFileContents = file_get_contents("data.json");
            $arrray = json_decode($strJsonFileContents);
            $user_found = false;
            $pass_change = false;
            foreach($arrray as $item) { 
                if ($username === $item->username){
                    $user_found = true;
                    
                    if ($currPass === $item->password){
                       
                        $item->password = $newPass;
                        $pass_change = true;
    
                    }else{
                        $curPassErr .= "Please check your password again or create an account.";
                        $currPass="";
                    }
                }
            }
    
            if ($pass_change){
                $final_data = json_encode($arrray);
                if(file_put_contents('data.json', $final_data)){
                    echo "<span style='color: green'>Password Changed Successfully!</span>";
                }
            }
    
            if (!$user_found){
                echo $userErr .= "No account found!";
            }
        }

        if (empty($_POST["current_pass"])) {
            $curPassErr = "Current password is required to change password";
            $errCount = $errCount + 1;
        } else {
            $currPass = check_input($_POST["current_pass"]);

            $newPass = check_input($_POST["new_password"]);
            $retypePass = check_input($_POST["retype_password"]);

            if (empty($newPass)) {
                $newPassErr = "New password is required to change password";
                $errCount = $errCount + 1;
            }

            if (empty($retypePass)) {
                $retypePassErr = "Confirm your new password!";
                $errCount = $errCount + 1;
            }

            if ($newPass === $currPass) {
                
                $newPassErr .= " New Password can not be same as the Current Password";
                $errCount = $errCount + 1;
            }

            if ($newPass !== $retypePass) {
               
                $retypePassErr .= " Confirm password doesn't match with new password!";
                $errCount = $errCount + 1;
            }

           
            if ($errCount <= 0) {
                if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[\d%$#@]).+$/", $newPass)) {
                    $newPassErr = "New Password must contain atleast 8 characters with a digit, a lower case, an upper case letter, atleast one of the [%$#@] and no space.";
                    $errCount = $errCount + 1;
                }
            }

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
<legend><b>Change Password</b></legend>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Username: <input type="text" name="username" value="<?php echo $username;?>">
  <span class="error">* <?php echo $userErr;?></span>
  <br>

  Current Password: <input type="password" name="current_pass">
  <span class="error">* <?php echo $curPassErr;?></span>
  <br>
 
  New Password: <input type="password" name="new_password">
  <span class="error">* <?php echo $newPassErr;?></span>
  <br>
  
  Retype New Password: <input type="password" name="retype_password">
  <span class="error">* <?php echo $retypePassErr;?></span>
  <br><br> <hr>

  <input type="submit" name="submit" value="Submit"> 
  <input type="reset"> 

</form>
</fieldset>
</div>


</body>
</html>