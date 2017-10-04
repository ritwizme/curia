<?php
include_once("scripts/userlog.php");
?>
<?php
session_start();
if (isset($_SESSION['idx'])) {
  header("location: profile.php");
}
$errorMsg = '';
$email = '';
$pass = '';
$remember = '';
$timestamp = time() + 300;
if (isset($_POST['email'])) {
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  if (isset($_POST['remember'])) {
    $remember = $_POST['remember'];
  }
  $email = stripslashes($email);
  $pass = stripslashes($pass);
  $email = strip_tags($email);
  $pass = strip_tags($pass);
  
  if ((!$email) || (!$pass)) { 

    $errorMsg = '<div class="alert alert-danger">
  <strong>Error!</strong> Please fill in both fields
</div>';

  } else { 
    include 'scripts/DB_connect.php'; 
    $email = mysql_real_escape_string($email); 
   
    $pass = md5($pass); 
    
        $sql = mysql_query("SELECT * FROM users WHERE email='$email' AND password='$pass'"); 
    $login_check = mysql_num_rows($sql);
        
    if($login_check > 0){ 
          while($row = mysql_fetch_array($sql))
          {
    
          $id = $row["id"];   
          $_SESSION['id'] = $id;
    
          $_SESSION['idx'] = base64_encode("g4p37hmp3h9xfn8sq03hs2234$id");
        
          $username = $row["username"];
          $_SESSION['username'] = $username;

          mysql_query("UPDATE users SET last_log=now(), online = '1', timestamp = '$timestamp' WHERE id='$id' LIMIT 1");
                } 
  
        
          if($remember == "yes")
          {
                    $encryptedID = base64_encode("ghdg94enm2c0c4y3dn3727553$id");
              setcookie("idCookie", $encryptedID, time()+60*60*24*100, "/"); 
              setcookie("passCookie", $pass, time()+60*60*24*100, "/"); 
            } 
          
          header("Location: profile.php?dashboard=$id"); 
          exit();
  
    } else { 
        $errorMsg = '<div class="alert alert-danger">
  <strong>Error!</strong> Please fill in both fields
</div>';
    }


    } 

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
	#loginpage{

		width: 100%;
		height:750px;
		background-image:url(img/background.jpg);
		background-size:cover;
		background-repeat:no-repeat;
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
  <div class="panel-body">
    <img src="img/Doctor.jpg" class="img-circle col-md-offset-5" width="70" height="70">
    <form action="index.php" method="post" >
    <div class="space1"></div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pass" placeholder="Enter password" name="pass">
    </div>
  	<div class="space1"></div>
    <button name="submit" class="btn btn-primary btn-block">Login</button>
    
    <a><small>Forgot your password?</small></a> <a><small class="pull-right" data-toggle="modal" data-target="#myModal">Register</small></a> 
    
    
  
  </form>
  <div class="space1"></div>
  </div>
  
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Register yourself here.. </h4>
        </div>
           <form action="register.php" method="post">
        <div class="modal-body">
      
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

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
      </div>
      
    </div>
  </div>
  
  
  
  </form>
  
</div>
	

</div>
</body>
</html>