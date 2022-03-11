<?php
$nameErr = $emailErr = $degreeErr = $genderErr = $userErr = $passErr = $confrmPassErr = $dobErr = "";
$name = $email = $gender = $username = $password = $cnfrmPass = $successmsg = $dob = $dobdd = $dobmm = $dobyy = ""; 
$errCount = 0;  
 $message = '';
 $error = '';
 if(isset($_POST["submit"])){

     //name validation
    if (empty($_POST["name"])){
    $nameErr = "Name is required";
    $errCount = $errCount + 1;     
     } else {
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
           $nameErr = "Only letters, period, dash and underscore are allowed";
           $name="";
           $errCount = $errCount + 1;   
         }   
    }

    //email validation
    if (empty($_POST["email"])) {
    $emailErr = "Email is required";
    $errCount = $errCount + 1;     
     } else {
         $email = check_input($_POST["email"]);
         
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $emailErr = "Invalid email format";
           $email="";
           $errCount = $errCount + 1;   
         }
     }


     //username validation
     if (empty($_POST["username"])) {
         $userErr = "Username is required";
         $errCount = $errCount + 1;     
       } else {
         $username = $_POST["username"];

         if (strlen($username) <2 ) {
        
          $userErr = "Minimum 2 characters required";
          $errCount = $errCount + 1;    
         }

        
         if (!preg_match("/^[a-zA-Z_\-.]*$/", $username)) {
          $userErr = "Only letters, period, dash and underscore are allowed";
          $username ="";
          $errCount = $errCount + 1;    
         }

       }


       //password validation
     if (empty($_POST["password"])) {
         $passErr = "Password is required";
         $errCount = $errCount + 1;     
       } else {

          $password = check_input($_POST["password"]);
          $cnfrmPass = check_input($_POST["cnfrmPass"]);

          if (empty($cnfrmPass)) {
         
               $confrmPassErr = "Confirm password is required";
               $errCount = $errCount + 1;  
          } else {
               if ($password != $cnfrmPass) {
        
                    $confrmPassErr = "Confirm password doesn't match with password!";
                    $errCount = $errCount + 1;
               }
          }

     
          if (strlen($password) < 8 ) {
             
               $passErr = "Minimum 8 characters required";
               $errCount = $errCount + 1;    
              }

         if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[%$#@]).+$/", $password)) {
               $passErr .= "Password must contain 8 characters with atleast a digit, a lower case, an upper case letter, atleast one of the [%$#@] and no space.";
               $password ="";
               $errCount = $errCount + 1;
              }

          }

     //gender validation
     if (empty($_POST["gender"])) {
         $genderErr = "Gender is required";
         $errCount = $errCount + 1;
     } else {
         $gender = check_input($_POST["gender"]);
     }

     //dob val
     if (empty($_POST["dob"])) {
         $dobErr = "Date of Birth is required";
         $errCount = $errCount + 1;
     } else {
         $dob = $_POST["dob"];
     }


     //json setup
      if($errCount > 0) {
      echo "<span class='error'>One or more error occurred!</span>";
      } else {
           if(file_exists('data.json'))  
           {  
                $current_data = file_get_contents('data.json');  
                $array_data = json_decode($current_data, true);  
                $extra = array(  
                     'name'               =>     $_POST['name'],  
                     'email'          =>     $_POST["email"],  
                     'username'     =>     $_POST["username"],
                     'password'     =>     $_POST["password"],
                     'gender'     =>     $_POST["gender"],
                     'dob'     =>     $_POST["dob"]  
                );  
                $array_data[] = $extra;  
                $final_data = json_encode($array_data);  
                if(file_put_contents('data.json', $final_data))  
                {  
                     $message = "<label class='text-success'>Your Registration is Success!</p>";
                }  
           }  
           else  
           {  
                $error = 'JSON File not exists';
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
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Registration</title>
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
           <div class="donor-info make-it-center" style="width:400px;">  
                <fieldset>
                <legend> <b>Registration</b></legend>
                <form method="post">  
                     <?php   
                     if(isset($error))  
                     {  
                          echo $error;  
                     }  
                     ?>  
                       
                     <label>Name:</label>  <span class="error">* <?php echo $nameErr;?></span>
                     <input type="text" name="name" class="form-control" value="<?php echo $name;?>"> <br> <br>
                     <hr>
                     <label>E-mail:</label> <span class="error">* <?php echo $emailErr;?></span>
                     <input type="text" name = "email" class="form-control" value="<?php echo $email;?>" > <br> <br>
                     <hr>
                     <label>Username:</label>  <span class="error">* <?php echo $userErr;?></span>
                     <input type="text" name = "username" class="form-control" value="<?php echo $username;?>" > <br> <br>
                     <hr>
                     <label>Password:</label>  <span class="error">* <?php echo $passErr;?></span>
                     <input type="password" name = "password" class="form-control"> <br> <br>
                     <hr>
                     <label>Confirm Password:</label>  <span class="error">* <?php echo $confrmPassErr;?></span>
                     <input type="password" name = "cnfrmPass" class="form-control"> <br> <br>
                     <hr>

                    <fieldset>
                    <legend>Gender</legend>  <span class="error">* <?php echo $genderErr;?></span>
                    <input type="radio" id="male" name="gender" value="male">
                     <label for="male">Male</label>                     
                     <input type="radio" id="female" name="gender" value="female">
                     <label for="female">Female</label>
                     <input type="radio" id="other" name="gender" value="other">
                     <label for="other">Other</label><br>
                     </fieldset>
                     <hr>
                     <fieldset>
                     <legend>Date of Birth:</legend>  <span class="error">* <?php echo $dobErr;?></span>
                     <input type="date" name="dob"  placeholder="dd-mm-yyyy"
                     min="1990-01-01" max="2000-12-31"> <br><br>
                     </fieldset> <br> <hr>

                     <input type="submit" name="submit" value="Register" class="btn btn-info">
                     <input type="reset">
                     <br>

                     <?php  
                     if(isset($message))  
                     {  
                          echo $message;  
                     }  
                     ?> 

                </form>  
                </fieldset>
                </div>  
             
      </body> 
      <?php include 'templates/footer.php';?>
 </html> 