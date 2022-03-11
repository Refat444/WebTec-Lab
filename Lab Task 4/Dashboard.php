<!DOCTYPE html>
<html>
<head>
<title>Midnight Mart</title>
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
include 'templates/sidenav.php';
session_start();
include 'templates/header.php';
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    echo "<h1> Welcome ".$_SESSION['uname']." to the Midnight Mart</h1>";

    echo '<img src="logo.jpg" width="350" height="350">';
    echo '<br>';

} else{
    header('Location: login.php');
}

?>
<br>
</body>
<?php include 'templates/footer.php';?>
</html>