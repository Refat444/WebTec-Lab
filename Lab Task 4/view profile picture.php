<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>
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
    include 'templates/sidenav.php';
    echo '
    <fieldset>
    <legend> <b>Profile:</b></legend>
    
    ';

    $strJsonFileContents = file_get_contents("data.json");

    $arra = json_decode($strJsonFileContents);
    foreach($arra as $item) { 
        if ($_SESSION['uname'] === $item->username){
            echo '<img src="' . $item->ppic_abs_path . '"width="120" height="120"> <br><a href="profile_picture.php">Change Profile Picture</a> <br>';
            echo '<br><div> Name: '. $item->name . '</div> <br>';
            echo '<div> Email: '. $item->email . '</div> <br>';
            echo '<div> Gender: '. $item->gender . '</div> <br>';
            echo '<div> Date of Birth: '. $item->dob . '</div> <br>';
        }
    }
    echo '<br>';
    echo '<b><a href="edit_profile.php"> Edit Profile ' . '</a></b> <br>';
    echo '</fieldset>';

} else{
    header('Location: login.php');
}

?>
<br>
</body>
<?php include 'templates/footer.php';?>
</html>