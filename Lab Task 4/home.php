<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
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
session_start();
if (isset($_SESSION['uname'])) {
    header('Location: dashboard.php');
}
?>

<h1 style="text-align:center"; >Welcome to Trojan horse</h1>

<?php include 'templates/footer.php';?>
</body>
</html>