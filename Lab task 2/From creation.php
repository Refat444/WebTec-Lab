<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
body{
        background: #F7F3D7;
        margin: auto;
        width: 60%;
          
        border: 2px solid black;
        padding: 20px;
        }
</style>
</head>
<body>  

<?php

$nameErr = $emailErr = $dobErr = $genderErr = $degreeErr = $bloodErr = "";
$name = $email = $dd= $mm=$yyyy= $gender = $degree =$blood = "";

//name
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-'. ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
      $name="";
    }else if(str_word_count($name)<2){
      $nameErr = "Invalid name. Please type your full name";
      $name="";
      }
      
  }
}

//email
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
      $email="";
    }
  }}

  //dob
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	if(empty($_POST["dd"]) or empty($_POST["mm"]) or empty($_POST["yyyy"])){
      $dobErr="Date of birth input is requied";
      $dd = test_input($_POST["dd"]);
      $mm = test_input($_POST["mm"]);
      $yyyy = test_input($_POST["yyyy"]);
  
    }
    else
    {
      $dd = test_input($_POST["dd"]);
      $mm = test_input($_POST["mm"]);
      $yyyy = test_input($_POST["yyyy"]);
  
      if( !filter_var($dd,FILTER_VALIDATE_INT,array('options' => array(
              'min_range' => 1, 
              'max_range' => 31
          )))|!filter_var($mm,FILTER_VALIDATE_INT,array('options' => array(
              'min_range' => 1, 
              'max_range' => 12
          )))|!filter_var($yyyy,FILTER_VALIDATE_INT,array('options' => array(
              'min_range' => 1953, 
              'max_range' => 2000
          ))))
        {$dobErr="Must be valid numbers(ex: dd:1-31,mm: 1-12,yyyy: 1953-1998)";
          $dd ="";
          $mm ="";
          $yyyy = "";
        }
      }
    }

//gender
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
    $gender="";
  } else {
    $gender = test_input($_POST["gender"]);
  }
}

//degree
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  if (empty($_POST["degree"])) {
    $degreeErr = "Degree is required";
  } else {
    
     if (sizeof($_POST["degree"])<2)
{
  $degreeErr="At least two must be selected";
  $degree="";
} else{ $degree = ($_POST["degree"]);}
  }
}

//blood
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
if(empty($_POST["blood"]))
	{
		$bloodErr="Must be selected";
	}
	else
	{
    $blood = test_input($_POST["blood"]);
	}
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2> Form Validation Example OF PHP</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

<fieldset style="width: 400px;">
<legend><b>NAME</b></legend>
   <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  </fieldset>
  <br>

  <fieldset style="width: 400px;">
  <legend><b>EMAIL</b></legend>
  <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  </fieldset>
  <br>

<fieldset style="width: 400px;">
<legend><b>DATE OF BIRTH</b></legend> 
<table>
<tr style="text-align: center;">
	<th style="font-weight: normal;"><label for="dd" >dd</label></th>
	<th></th>
	<th style="font-weight: normal;"><label for="mm" >mm</label></th>
	<th></th>
	<th style="font-weight: normal;"><label for="yyyy" >yyyy</label></th>
	<th></th>
</tr>
<tr>
<td><input type="text" name="dd" style="width: 30px" value="<?php echo $dd;?>"></td>
<td>/</td>
<td><input type="text" name="mm" style="width: 30px" value="<?php echo $mm;?>"></td>
<td>/</td>
<td><input type="text" name="yyyy" style="width: 30px;" value="<?php echo $yyyy;?>"></td>
<td style="padding-left: 10px"><span class="error">* <?php echo $dobErr;?></span></td>
</tr>
</table>
</fieldset>
<br>

<fieldset style="width: 400px;">
<legend><b>GENDER</b></legend>
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="Female") echo "checked";?> value="Female">Female
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="Male") echo "checked";?> value="Male">Male
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="Other") echo "checked";?> value="Other">Other  
  <span class="error">* <?php echo $genderErr;?></span>
  </fieldset>
  <br>

<fieldset style="width: 400px;">
<legend><b>DEGREE</b></legend>
  <input type="checkbox" name="degree[]" <?php if (isset($degree) && $degree=="SSC") echo "checked";?> value="SSC">SSC
  <input type="checkbox" name="degree[]" <?php if (isset($degree) && $degree=="HSC") echo "checked";?> value="HSC">HSC
  <input type="checkbox" name="degree[]" <?php if (isset($degree) && $degree=="BSc") echo "checked";?> value="BSc">BSc
  <input type="checkbox" name="degree[]" <?php if (isset($degree) && $degree=="MSc") echo "checked";?> value="MSc">MSc
  <span class="error">* <?php echo $degreeErr;?></span>
  </fieldset>
  <br>

<fieldset style="width: 400px;">
<legend><b>BLOOD GROUP</b></legend>
	<select name="blood">
		<option <?php if (isset($blood) && $blood=="error") echo "error";?> value="error">Select</option>
		<option <?php if (isset($blood) && $blood=="AB+") echo "AB+";?> value="AB+">AB+</option>
		<option <?php if (isset($blood) && $blood=="AB-") echo "AB-";?> value="AB-">AB-</option>
		<option <?php if (isset($blood) && $blood=="A+") echo "A+";?> value="A+">A+</option>
		<option <?php if (isset($blood) && $blood=="A-") echo "A-";?> value="A-">A-</option>
		<option <?php if (isset($blood) && $blood=="B+") echo "B+";?> value="B+">B+</option>
		<option <?php if (isset($blood) && $blood=="B-") echo "B-";?> value="B-">B-</option>
		<option <?php if (isset($blood) && $blood=="O+") echo "O+";?> value="O+">O+</option>
		<option <?php if (isset($blood) && $blood=="O-") echo "O-";?> value="O-">O-</option>
	</select>		
	<span class="error" >* <?php echo $bloodErr;?></span>
  </fieldset>
  <br>

  <input type="submit" name="submit" value="Submit" style="width: 200px">  
</form>

<?php
echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $dd;
echo $mm;
echo $yyyy;
echo "<br>";
echo $gender;
echo "<br>";

{
  echo "<br>";
}
echo $blood;
?>
</body>
</html>