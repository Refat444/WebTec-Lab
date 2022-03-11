<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
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
        .sidenav {
            height: "auto";
            position: fixed;
            top: 0; 
            left: 0;
            padding-left: 200px;
            padding-top: 80px;
        }

        .sidenav a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            display: block;
        }
        .footer{
            text-align:center;
        }
    </style>
</head>
<body>
<?php

session_start();
include 'templates/sidenav.php';
include 'templates/header.php';
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    $curPassErr = $newPassErr = $retypePassErr = $userErr = "";
    $username = "";
    $currPass = $newPass = $retypePass = "";
    $errCount = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $username = $_SESSION['uname'];

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
                    $retypePassErr = "You must retype your new password!";
                    $errCount = $errCount + 1;
                }

                if ($newPass === $currPass) {
                    $newPassErr .= " New Password should not be same as the Current Password";
                    $errCount = $errCount + 1;
                }

                if ($newPass !== $retypePass) {
                    $retypePassErr .= " Retype password don't match with new password!";
                    $errCount = $errCount + 1;
                }

                if (strlen($currPass) < 8) {
                    $curPassErr .= " Current password cannot be less than 8 characters. Error!";
                    $errCount = $errCount + 1;
                }

                if ($errCount <= 0) {
                    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[\d%$#@]).+$/", $newPass)) {
                        $newPassErr = "New Password must contain at-least a digit, a lower case and an upper case letter, atleast one of the [%$#@] and no space.";
                        $errCount = $errCount + 1;
                    }
                }

            }

        if ($errCount < 1){
            $strJsonFileContents = file_get_contents("data.json");

            $arra = json_decode($strJsonFileContents);
            $user_found = false;
            $pass_change = false;
            foreach($arra as $item) {
                if ($username === $item->username){
                    $user_found = true;
                   
                    if ($currPass === $item->password){
                        echo "<br>";
                        echo "Thanks for approving the password change $item->name! Request processing...";   
                        $item->password = $newPass;
                        echo "<br>";
                        $pass_change = true;

                    }else{
                        $curPassErr .= "Please check your password again or create an account.";
                    }
                }
            }

            if ($pass_change){
                $final_data = json_encode($arra);
                if(file_put_contents('data.json', $final_data)){
                    echo "<span style='color: green'>Password Changed Successfully!</span><br>";
                }
            }

            if (!$user_found){
                echo $userErr .= "No account found!";
            }

        }

    }


} else{
    header('Location: login.php');
}

function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


<fieldset>
<legend><b>Change Password</b></legend>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Current Password: <input type="password" name="current_pass">
    <span class="error">* <?php echo $curPassErr;?></span>
    <br><br>
    New Password: <input type="password" name="new_password">
    <span class="error">* <?php echo $newPassErr;?></span>
    <br> <br>
    Retype New Password: <input type="password" name="retype_password">
    <span class="error">* <?php echo $retypePassErr;?></span>
    <br> <hr>

    <input type="submit" name="submit" value="Submit">
    <input type="reset">
</form>
</fieldset>
<br>
</body>
<?php include 'templates/footer.php';?>
</html>