<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);

$cacheBuster = rand(999999999,9999999999999); // Put on an image URL will help always show new when changed
$encrypted_nos = base64_encode("s6k3k4lsjdfsdsasf453fs"); //this will be used in deleting response
include('scripts/DB_connect.php');
if($_POST)
{

$q=$_POST['searchword'];

$sql_res=mysql_query("SELECT * from images where concat(file_title,' ',doctor,' ',c_date) like '%$q%' order by image_id LIMIT 8");
$search_nums = mysql_num_rows($sql_res); //TOTAL NUMBER OF RESULTS
while($row=mysql_fetch_array($sql_res))
{
$doctor=$row['doctor'];
$file_title=$row['file_title'];
$id=$row['image_id'];
/*$country=$row['country'];
$email=$row['email'];
*/
$re_doctor='<b>'.$q.'</b>';
$re_file_title='<b>'.$q.'</b>';

$final_doctor = str_ireplace($q, $re_doctor, $doctor);

$final_file_title = str_ireplace($q, $re_file_title, $file_title);

	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	

?>

<div class="display_box" align="left">
<div class="container">
      <div class="row">
     
            <div class="alert alert-success">
              


<!--<?php echo $search_profile_pic; ?>--><div id="search_qD"><?php echo $final_file_title; ?>&nbsp;<?php echo $final_doctor; ?></div>
<span style="font-size:9px; color:#999999"></span></a>



                <span id="showSearchTerm"></span>
            </div>
    </div>
    </div>
</div>





<?php
}

}
else
{
echo "

<div class=\"container\">
      <div class=\"row\">
     
        
<div class=\"alert alert-info\">
                <strong>No More Results !</strong> 
            

                <span id=\"showSearchTerm\"></span>
            </div>
    </div>
    </div>
</div>";
}

if($search_nums > 5)

{
	
	echo '
<div class=\"container\">
      <div class=\"row\">
     
        
<div class=\"alert alert-info\">
                <strong>More results!</strong> 
            

                <span id=\"showSearchTerm\"></span>
            </div>
    </div>
    </div>
</div';
}
else {
echo "<div class=\"container\">
      <div class=\"row\">
     
        
<div class=\"alert alert-info\">
                <strong>No More Results !</strong> 
            

                <span id=\"showSearchTerm\"></span>
            </div>
    </div>
    </div>
</div>";
}
?>