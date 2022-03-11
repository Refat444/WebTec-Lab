<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
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
<?php include 'templates/header.php';?>

<?php
$userErr = $passErr = "";
$username = $password = ""; 
$errCount = 0;

$email = "";
$emailErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required for this action!";
        $errCount = $errCount + 1;
    } else {
        $email = check_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $email="";
            $errCount = $errCount + 1;
        }
    }

    if ($errCount < 1){

        $strJsonFileContents = file_get_contents("data.json");

        $arra = json_decode($strJsonFileContents);
        $user_found = false;
        foreach($arra as $item) {

            if ($email === $item->email){
                $user_found = true;
                if ($item->password){
                    echo "<br><div style='color: green'>Your username is $item->username </br></div>";
                    echo "<div style='color: green'> Your Password is $item->password </br></div>";
                }else{
                    $passErr .= "Password Not Found!!";
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
<h2>FORGOT PASSWORD</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Enter Email: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br> <hr>

<input type="submit" name="submit" value="Submit">  
</form>

</div>
</body>
<?php include 'templates/footer.php';?>
</html>