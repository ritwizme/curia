<?php
// Start_session, check if user is logged in or not, and connect to the database all in one included file
include_once("scripts/userlog.php");
// Include the class files for auto making links out of full URLs and for Time Ago date formatting
include_once("scripts/autoMakeLinks.php");
include_once ("scripts/agoTimeFormat.php");
// Create the two new objects before we can use below in this script
$activeLinkObject = new autoActiveLink;
$my_object = new convertToAgo;
if (isset($_GET['id'])) {
	 $id = preg_replace('#[^0-9]#i', '', $_GET['id']); // filter everything but numbers
} else if (isset($_SESSION['idx'])) {
	 $id = $logOptions_id;
} else {
   header("location: index.php");
   exit();
}
$id = preg_replace("#[^0-9]#i", '', $id);
echo $id;
$UploadDirectory	= 'users/'.$id.'/reports/'; //Upload Directory, ends with slash & make sure folder exist
$UploadDirectory2	= 'users/'.$id.'/prescriptions/'; //Upload Directory, ends with slash & make sure folder exist
// replace with your mysql database details
include('scripts/DB_connect.php');
if (!@file_exists($UploadDirectory)) {
	//destination folder does not exist
	die("Make sure Upload directory exist!");
}
if($_POST)
{	
if(!isset($_POST['mTitle']) || strlen($_POST['mTitle'])<1)
	{
		//required variables are empty
		die("Enter your disease name");
	}
	if(!isset($_POST['mDoc']) || strlen($_POST['mDoc'])<1)
	{
		//required variables are empty
		die("Enter your consulting doctor details");
	}
	if(!isset($_POST['mDate']) || strlen($_POST['mDate'])<1)
	{
		//required variables are empty
		die("Enter your checkup date");
	}
	
	if(!isset($_POST['mDesc']) || strlen($_POST['mDesc'])<1)
	{
		//required variables are empty
		die("Enter the description of your disease");
	}
	if(!isset($_FILES['mFile']))
	{
		//required variables are empty
		die("File is empty!");
	}
	if(!isset($_FILES['mFile2']))
	{
		//required variables are empty
		die("File is empty!");
	}
	if($_FILES['mFile']['error'])
	{
		//File upload error encountered
		die(upload_errors($_FILES['mFile']['error']));
	}
	$FileName			= strtolower($_FILES['mFile']['name']); //uploaded file name
	$FileName2			= strtolower($_FILES['mFile2']['name']); //uploaded file name
	$FileDesc			= mysql_real_escape_string($_POST['mDesc']); // file title
	$FileDoc			= mysql_real_escape_string($_POST['mDoc']); // Doctor title
	$C_Date			= mysql_real_escape_string($_POST['mDate']); // check up date
	$FileTitle			= mysql_real_escape_string($_POST['mTitle']); // file title
	$FileTitle2			= mysql_real_escape_string($_POST['mTitle']); // file title
	$ImageExt			= substr($FileName, strrpos($FileName, '.')); //file extension
	$OwnId				= $logOptions_id;
	$FileType			= $_FILES['mFile']['type']; //file type
	$FileSize			= $_FILES['mFile']["size"]; //file size
	$RandNumber   		= rand(0, 9999999999); //Random number to make each filename unique.
	$uploaded_date		= date("Y-m-d H:i:s");
	switch(strtolower($FileType))
	{
		//allowed file types
		case 'image/png': //png file
		case 'image/gif': //gif file 
		case 'image/jpeg': //jpeg file
		/*case 'application/pdf': //PDF file
		case 'application/msword': //ms word file
		case 'application/vnd.ms-excel': //ms excel file
		case 'application/x-zip-compressed': //zip file
		case 'text/plain': //text file
		case 'text/html': //html file*/
			break;
		default:
			die('Unsupported File!<br />
<a href="admin/home.php">Go Back</a>');
			 //output error
	}
	//File Title will be used as new File name
	$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($FileTitle));
	$NewFileName = $NewFileName.'_'.$RandNumber.$ImageExt;
	$NewFileName2 = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($FileTitle2));
	$NewFileName2 = $NewFileName2.'_'.$RandNumber.$ImageExt;
   //Rename and save uploded file to destination folder.
   if(move_uploaded_file($_FILES['mFile']["tmp_name"], $UploadDirectory . $NewFileName )){
	   
	    if(move_uploaded_file($_FILES['mFile2']["tmp_name"], $UploadDirectory2 . $NewFileName2 ))
   
   {
		//connect & insert file record in database
		$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);	
		@mysql_query("INSERT INTO images (filename,filename2, file_desc, doctor, c_date, file_title, file_size, own_id, uploaded_date) VALUES ('$NewFileName','$NewFileName2','$FileDesc','$FileDoc','$C_Date','$FileTitle',$FileSize,'$OwnId','$uploaded_date')");
		mysql_close($dbconn);
		header('location:profile.php');	
  }else{
	   die('error uploading file!<br />
<a href="profile.php">Go Back</a>');
	   }
   }else{
   		die('error uploading File!<br />
<a href="profile.php">Go Back</a>');
   }
}
//function outputs upload error messages, http://www.php.net/manual/en/features.file-upload.errors.php#90522
function upload_errors($err_code) {
	switch ($err_code) { 
        case UPLOAD_ERR_INI_SIZE: 
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini'; 
        case UPLOAD_ERR_FORM_SIZE: 
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'; 
        case UPLOAD_ERR_PARTIAL: 
            return 'The uploaded file was only partially uploaded'; 
        case UPLOAD_ERR_NO_FILE: 
            return 'No file was uploaded'; 
        case UPLOAD_ERR_NO_TMP_DIR: 
            return 'Missing a temporary folder'; 
        case UPLOAD_ERR_CANT_WRITE: 
            return 'Failed to write file to disk'; 
        case UPLOAD_ERR_EXTENSION: 
            return 'File upload stopped by extension'; 
        default: 
            return 'Unknown upload error'; 
    } 
} 
?>