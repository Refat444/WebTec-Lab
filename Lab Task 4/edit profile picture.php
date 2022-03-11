<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
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
include 'templates/header.php';
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    $name = $email = $gender = $dob = '';
    $err = '';
    include 'templates/sidenav.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errCount = 0;
        if (!empty($_POST["name"])) {
            $name = check_input($_POST["name"]);
            $wcount = str_word_count($name);
            if ($wcount < 2 ) {
                $nameErr = "Minimum 2 words required";
                $errCount = $errCount + 1;
            }

            if (!preg_match("/^[a-zA-Z]/", $name)) {
                $nameErr = "Name must start with a letter!";
                $name ="";
                $errCount = $errCount + 1;
            }

            if (!preg_match("/^[a-zA-Z_\-. ]*$/",$name)) {
                $nameErr = "Only letters, period and white space allowed";
                $name="";
                $errCount = $errCount + 1;
            }
        }

        if (!empty($_POST["email"])) {
            $email = check_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $email="";
                $errCount = $errCount + 1;
            }
        }

        if (!empty($_POST["gender"])) {
            $gender = check_input($_POST["gender"]);
        }

        if (!empty($_POST["dob"])) {
            $dob = $_POST["dob"];
        }

        if($errCount > 0) {
            echo "<span class='error'>One or more error occurred!</span>";
        } else {
            if (file_exists('data.json')) {
                $strJsonFileContents = file_get_contents("data.json");
                $arra = json_decode($strJsonFileContents);
                $user_found = false;
                $user_edited = false;
                foreach ($arra as $item) {
                    if ($_SESSION['uname'] === $item->username) {
                        $user_found = true;
                        if (!($name === $item->name)) {
                            $item->name = $name;
                            $user_edited = true;
                        }
                        if (!($email === $item->email)) {
                            $item->email = $email;
                            $user_edited = true;
                        }
                        if (!($gender === $item->gender)) {
                            $item->gender = $gender;
                            $user_edited = true;
                        }
                        if (!($dob === $item->dob)) {
                            $item->dob = $dob;
                            $user_edited = true;
                        }
                    }
                }
                if ($user_edited){
                    $final_data = json_encode($arra);
                    if(file_put_contents('data.json', $final_data)){
                        echo "<span style='color: green'>User Edited Successfully!</span>";
                    }
                }
            }
        }


    } else {

        $strJsonFileContents = file_get_contents("data.json");
        $arra = json_decode($strJsonFileContents);
        foreach ($arra as $item) {
            if ($_SESSION['uname'] === $item->username) {
                $name = $item->name;
                $email = $item->email;
                $gender = $item->gender;
                $dob = $item->dob;
            }
        }
    }

} else{
    header('Location: login.php');
}
function check_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<br>
<fieldset>
    <legend> <b>Edit Profile:</b></legend>
        <div class="donor-info">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                
                <label>Name:</label> <input type="text" name="name" value="<?php echo $name;?>">
                <br> <hr>
                <label>E-mail:</label> <input type="text" name="email" value="<?php echo $email;?>">
                <br> <hr>
                <fieldset>
                <span>Gender: </span>
                <input type="radio" id="male" name="gender" value="male" <?php if ($gender === 'male'){ echo 'checked';}?> >
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female" <?php if ($gender === 'female'){ echo 'checked';}?> >
                <label for="female">Female</label>
                <input type="radio" id="other" name="gender" value="other" <?php if ($gender === 'other'){ echo 'checked';}?> >
                <label for="other">Other</label>
                </fieldset>
                <hr>
                <fieldset>
                <legend>Date of Birth:</legend> 
                <input type="date" name="dob" value="<?php echo $dob;?>"  placeholder="dd-mm-yyyy"
                min="1990-01-01" max="2000-12-31"> <br><br>
                </fieldset> <br> <hr>
                <input type="submit" name="submit" value="Update">
                <input type="reset">
            </form>

</div>
</fieldset>
</body>
<?php include 'templates/footer.php';?>
</html>