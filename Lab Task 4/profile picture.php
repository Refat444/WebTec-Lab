<!DOCTYPE html>
<html>
<head>
    <title>Profile Picture</title>
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
include 'templates/sidenav.php';
$userErr = $passErr = "";
$username = $password = "";
$abs_path = '';
$imgErr = '';
$errCount = 0;

if (isset($_SESSION['uname'])) {
    if (file_exists('data.json')) {
        $strJsonFileContents = file_get_contents("data.json");
        $arra = json_decode($strJsonFileContents);
        foreach ($arra as $item) {
            if ($_SESSION['uname'] === $item->username) {
                $abs_path = $item->ppic_abs_path;
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submit"])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image_to_up"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $mime_type_arr = array('jpg', 'png', 'jpeg');
            if (in_array($imageFileType, $mime_type_arr)) {
                if ($_FILES["image_to_up"]["size"] > 4000000) {
                    $imgErr .= " Sorry, your file is larger than 4MB";
                    $uploadOk = 0;
                } else {
                    if (file_exists($target_file)) {
                        $imgErr .= " Sorry, image already exists.";
                        $uploadOk = 0;
                    } else {
                        if (move_uploaded_file($_FILES["image_to_up"]["tmp_name"], $target_file)) {
                            $abs_path = $target_file;

                            if (file_exists('data.json')) {
                                $strJsonFileContents = file_get_contents("data.json");
                                $arra = json_decode($strJsonFileContents);
                                $user_found = false;
                                $user_edited = false;
                                foreach ($arra as $item) {
                                    if ($_SESSION['uname'] === $item->username) {
                                        $user_found = true;
                                        $item->ppic_abs_path = $abs_path;
                                        $user_edited = true;
                                    }
                                }
                                if ($user_edited) {
                                    $final_data = json_encode($arra);
                                    if (file_put_contents('data.json', $final_data)) {
                                        echo "<span style='color: green'>Profile Picture Updated Successfully!</span>";
                                    }
                                }
                            }

                        } else {
                            $imgErr .= "Sorry, there was an error uploading your file.";
                        }
                    }
                }
            } else {
                $imgErr .= " Sorry, only JPG, JPEG & PNG files are allowed";
                $uploadOk = 0;
            }
        }
    }

} else{
    header('Location: login.php');
}

?>

<fieldset>
        <legend><b>Change Profile Picture</b></legend>
    <img src="<?php echo $abs_path;?>" width="150" height="150"> <br>  <br>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            <input type="file" id="image_to_up" name="image_to_up"><br>
            <span class="error"> <?php echo $imgErr;?></span> <br>

            <input type="submit" value="Upload Image" name="submit">

        </form><br>

</fieldset><br>

</body>
<?php include 'templates/footer.php';?>
</html>