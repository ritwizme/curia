
<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);
$from = ""; // Initialize the email from variable
// This code runs only if the username is posted
if (isset ($_POST['email'])){
   
   $username = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['username']);
   $gender = preg_replace('#[^a-z]#i', '', $_POST['gender']); // filter everything but lowercase letters
   $dob = preg_replace('#[^0-9]#i', '', $_POST['dob']); // filter everything but numbers
   $blood_group = preg_replace('#[^a-z]#i', '', $_POST['blood_group']); // filter everything but lowercase letter
   $phone= preg_replace('#[^0-9]#i', '', $_POST['phone']); // filter everything but numbers
   $aadhar= preg_replace('#[^0-9]#i', '', $_POST['aadhar']); // filter everything but numbers

  
     $email = $_POST['email'];
    
     $pass = $_POST['pass'];
   

     $email = stripslashes($email); 
     $pass = stripslashes($pass); 
  
   
     $email = strip_tags($email);
     $pass = strip_tags($pass);


     // Connect to database
     include_once 'scripts/DB_connect.php'; 
     $emailCHecker = mysql_real_escape_string($email);
   $emailCHecker = str_replace("`", "", $emailCHecker);
  
     // Database duplicate e-mail check setup for use below in the error handling if else conditionals
     $sql_email_check = mysql_query("SELECT email FROM users WHERE email='$emailCHecker'");
     $email_check = mysql_num_rows($sql_email_check);

     // Error handling for missing data
     if ((!$username) || (!$gender) || (!$dob) || (!$blood_group) || (!$phone) || (!$aadhar) || (!$email) || (!$pass)) { 

     $errorMsg = '<div class="alert alert-danger"><strong>Error!</strong> You must fill all the informations.</div>';

     } else if ($email_check > 0){ 
              $errorMsg ='<div class="alert alert-danger"><strong>Error!:</strong> Your Email address is already in use inside of our system. Please use another.</div>'; 
     } else { // Error handling is ended, process the data and add member to database
     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
     $email = mysql_real_escape_string($email);
     $pass = mysql_real_escape_string($pass);
   
     // Add MD5 Hash to the pass variable
     $db_pass = md5($pass); 
   
   // Convert Birthday to a DATE field type format(YYYY-MM-DD) out of the month, day, and year supplied 
  

     // GET USER IP ADDRESS
     $ipaddress = getenv('REMOTE_ADDR');

     // Add user info into the database table for the main site table
     $sql = mysql_query("INSERT INTO users (username, gender, dob, blood_group, phone, aadhar, email, password, ipaddress, sign_up_date) 
     VALUES('$username','$gender','$dob','$blood_group','$phone','aadhar','$email','$db_pass', '$ipaddress', now())")  
     or die (mysql_error());
 
     $id = mysql_insert_id();
   
   // Create directory(folder) to hold each user's files(pics, MP3s, etc.)    
     mkdir("users/$id", 0755);  
     mkdir("users/$id/prescriptions", 0755); 
     mkdir("users/$id/reports", 0755); 

    //!!!!!!!!!!!!!!!!!!!!!!!!!    Email User the activation link    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $to = "$email";
                     
    /*from = $dyn_www; // $adminEmail is established in [ scripts/connect_to_mysql.php ]
    $subject = 'Complete Your ' . $dyn_www . ' Registration';
    //Begin HTML Email Message
    $message = "Hi $firstname,

   Complete this step to activate your login identity at $dyn_www

   Click the line below to activate when ready

   http://$dyn_www/activation.php?id=$id&sequence=$db_pass
   If the URL above is not an active link, please copy and paste it into your browser address bar

   Login after successful activation using your:  
   E-mail Address: $email 
   pass: $pass

   See you on the site!";
   //end of message
  $headers  = "From: $from\r\n";
    $headers .= "Content-type: text\r\n";

    mail($to, $subject, $message, $headers);
  */
   $success = "<h2>You have been successfully registered. Please login</h2>";
   
   include_once 'success.php'; 
   exit();

   } // Close else after duplication checks

} else { // if the form is not posted with variables, place default empty variables so no warnings or errors show
    
    $errorMsg = "";
    $username = "";
    $gender = "";
    $dob = "";
    $blood_group = "";
    $phone = "";
    $aadhar = "";
    $email = "";
    $pass = "";
}

?>

<!DOCTYPE html>
<html>
<head>

   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <title>Welcome To Curius</title>
</head>
<style type="text/css">
 body{

    width: 100%;
    min-height:750px;
    height:auto;
    background-image:url(img/background.jpg);
    background-size:cover;
    background-repeat:repeat-y;
  }

  .space1{
    width:100%;
    height:10px;
  }
  .space2{
    width: 100%;
    height:50px;
  }
  .space3{}


</style>


<body>
<div id="loginpage">
<?php echo $errorMsg;?>
<div class="space2"></div><div class="space2"></div>
<div class="space1"></div>
<div class="panel panel-default col-md-4 col-md-offset-4">
<h4 class="panel panel-title" style="font-weight: bold; padding:4px;">Register yourself here.. </h4>
  <div class="panel-body">
    <form action="register.php" method="post" >

    <div class="space1"></div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
        <div class="form-group">
      <label for="email">Name:</label>
      <input type="text" class="form-control" id="username" placeholder="Enter name" name="username">
    </div>
        <div class="form-group">
      <label for="email">Blood group:</label>
      <input type="text" class="form-control" id="blood_group" placeholder="Enter Blood group" name="blood_group">
    </div>
     <div class="form-group">
      <label for="email">Phone No.:</label>
      <input type="number" class="form-control" id="phone" placeholder="Enter Phone No" name="phone">
    </div>
    <div class="form-group">
      <label for="aadhar">Aadhard Card Number.:</label>
      <input type="number" class="form-control" id="aadhar" placeholder="Enter Aadhar No." name="aadhar">
    </div>
    <div class="form-group">
      <label for="email">DOB:</label>
      <input type="date" class="form-control" id="dob" placeholder="Enter Phone No" name="dob">
    </div>

      <div class="form-group">
      <label for="gender">Gender:</label>
     <label class="radio-inline">
      <input type="radio" name="gender" value="male">Male
    </label>
    <label class="radio-inline">
      <input type="radio" name="gender" value="female">Female
    </label>
    </div>
   
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pass" placeholder="Enter password" name="pass">
    </div>
    <div class="space1"></div>
     <div class="form-group">
      <label for="pwd">Confirm Password:</label>
      <input type="password" class="form-control" id="pass2" placeholder="Confirm password" name="pass2">
    </div>
    <div class="space1"></div>
    
    <button name="submit" class="btn btn-primary btn-block">Register</button>
    
   <small>Already a member?</small> <a href="index.php"><small class="pull-right">Login</small></a> 
    
    
  
  </form>
  <div class="space1"></div>
  </div>
  
    <!-- Modal -->
 
  
  

</div>
  

</div>
</body>
</html>