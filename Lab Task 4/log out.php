<!DOCTYPE html>
<html>
<?php include 'templates/head.html';?>
<body>
<?php include 'templates/header.php';?>
<?php
session_start();
if (isset($_SESSION['uname'])) {
    session_destroy();
    header("location:login.php");

}else{
    header("location:login.php");
}
?>
</body>
<?php include 'templates/footer.php';?>
</html>