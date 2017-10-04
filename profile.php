<?php
// Start_session, check if user is logged in or not, and connect to the database all in one included file
include_once("scripts/userlog.php");
// Include the class files for auto making links out of full URLs and for Time Ago date formatting
include_once("scripts/autoMakeLinks.php");
include_once ("scripts/agoTimeFormat.php");
// Create the two new objects before we can use below in this script
$activeLinkObject = new autoActiveLink;
$my_object = new convertToAgo;
?>
<?php 
// ------- INITIALIZE SOME VARIABLES ---------
// they must be initialized in some server environments or else errors will get thrown
$mainNameLine = "";
$user_pic = "";
$interactionBox = "";
$links = "";               
$username = "";          
$firstname = "";             
$middlename = "";              
$lastname = "";            
$gender = "";               
$birthday = "";           
$email = "";                             
$sign_up_date = "";             
$last_log_date = "";              
$bio_body = "";                
$website = "";               
$youtube = "";                 
$facebook = "";              
$twitter = "";                             
$user_type = "";              
$account_status = "";                          
$phone = "";               
$address = "";                           
$user_type="";  
$doy = "";  
$med_tips =""; 
$blood_group ="";  
$cacheBuster = rand(999999999,9999999999999); // Put on an image URL will help always show new when changed
$encrypted_nos = base64_encode("s6k3k4lsjdfsdsasf453fs"); //this will be used in deleting response
// ------- END INITIALIZE SOME VARIABLES ---------

// ------- ESTABLISH THE PAGE ID ACCORDING TO CONDITIONS ---------
if (isset($_GET['id'])) {
   $id = preg_replace('#[^0-9]#i', '', $_GET['id']); // filter everything but numbers
} else if (isset($_SESSION['idx'])) {
   $id = $logOptions_id;
} else {
   header("location: index.php");
   exit();
}
$id = preg_replace("#[^0-9]#i", '', $id);
$check_user = mysql_query("SELECT * FROM users WHERE id = '$id' LIMIT 1") or die(mysql_error());
$sql_confirmation = mysql_num_rows($check_user);
if($sql_confirmation == 0){
  header("location:index.php?msg=user_does_not_exist");
  }
while($row = mysql_fetch_array($check_user)) {
    $email = $row['email'];
  
  $username = $row["username"];
  $firstname = $row["firstname"];
  $middlename = $row["middlename"];
  $lastname = $row["lastname"];
  $user_type = $row["user_type"];
  $doy = $row["doy"];
  $address = $row["address"]; 
  $sign_up_date = $row["sign_up_date"];
    $sign_up_date = strftime("%b %d, %Y", strtotime($sign_up_date));
  $last_log_date = $row["last_log_date"];
    $last_log_date = strftime("%b %d, %Y", strtotime($last_log_date));  
  $bio_body = $row["bio_body"]; 
  $bio_body = str_replace("&#39;", "'", $bio_body);
  $bio_body = stripslashes($bio_body);
  $about_body = $row["about_body"]; 
  $about_body = str_replace("&#39;", "'", $about_body);
  $about_body = stripslashes($about_body);
  $website = $row["website"];
  $youtube = $row["youtube"];
    $facebook = $row["facebook"];
  $twitter = $row["twitter"];
  $google = $row["google"]; 
  $con_array = $row["con_array"];             
  $gender = $row["gender"];               
  $birthday = $row["birthday"];                                                       
  $user_type = $row["user_type"] ;
  $blood_group = $row["blood_group"];           
  $account_status = $row["account_status"];                          
  $phone = $row["phone"];              
}//close while loop
$quote_query = mysql_query("SELECT * FROM quotes ORDER by rand()") or die(mysql_error());
while($row = mysql_fetch_array($quote_query)) {
    $quote = $row['quote'];
}
  
/////////////////////////CHECK FOR USERNAME TO DISPLAY//////////
if($firstname != "")
  {
  $username = $firstname;
  $username = ucfirst($firstname).' '.ucfirst($middlename).' '.ucfirst($lastname);
  }else 
    {
    $username = ucfirst($username);
    }

///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
  $check_pic = "users/$id/profile.jpg";
  $default_pic = "users/0/profile.png";
  if (file_exists($check_pic)) {
    $user_pic = "<img class=\"img-profile img-circle img-responsive center-block\" src=\"$check_pic?$cacheBuster\" \  />"; 
  } else {
  $user_pic = "<img class=\"img-profile img-circle img-responsive center-block\" src=\"$default_pic\" \ />"; 
  }
  ///////////////////////////////////////////////////////////
  /////////////////FUNCTIONS GOES HERE////////////////////////////////////////////////////////-------------///
  ////function show name in active links//////////
  function show_name($name,$profile_id, $true = true, $s = true)
    {
    if($s == true)
      {
      $s = '\'s';
      }else
        {
        $s = '';
        }
    if($true == true)
      {
      $name = '<a href="home.php?id='.$profile_id.'">'.$name.$s.'</a>';
      }else 
        {
        $name = $name;
        }
    
    return $name;
    }
    //--------//
    //close function------//
    
    //----------//FUNCTION TO CUT LONG WORDS IN STRING VERY POWERFUL/////////////---//
    function wrap($str, $width=20, $break="\n", $char_no=5) 
      {
        return preg_replace('#(\S{'.$width.',})#e', "chunk_split('$1', ".$char_no.", '".$break."')", $str);
      }
    ///////////COUNT REPLIES///////////
    function count_replies($b_id)
      {
      $reply_sql = mysql_query("select id from blab_reply where blab_id = '$b_id' ") or die(mysql_error());
      return mysql_num_rows($reply_sql);
      }//close function 
          
    /////////////////////END FUNCTIONS BUILDING///////////////////
    
  //MECHANISM TO DISPLAY NAME
  if($firstname != ""){
    $show_name = show_name($username, $id);
    }else
     {
      $show_name = show_name($username, $id);
      }
  //MECHANISM TO DISPLAY INFOS
  $bio = "";
  
  if($bio_body != ""){
    $bio.='<div class="infoHeader"><span class="boldStuff2"><strong>Bio:</strong></span></div>';
    $bio.='<div class="infoBody">'.wrap($bio_body).'</div>';
    }else 
      {
      $bio = "";
      while($row = mysql_fetch_array($quote_query)) {
    $quote = $row['quote'];
}
      }
  
  //////////////Caclulate Age////////////////////////////////////////
  $age = "";
   $todayis= date("Y");
   
   $age = $todayis-$doy;
  ///////////////////////////////////////////////////////////////
  
  
  //////////////////Find Min Upload Date////////////////////////////
  $m_date = mysql_query("SELECT MIN(YEAR(uploaded_date)) FROM images WHERE own_id='$id'");
  $m_row = mysql_fetch_row($m_date);
  $m_year = $m_row[0];
  
  
  
  
  ///////////////////////Populate Timeline/////////////////////////////////
  $timeline_year = range($todayis,$m_year);
  $time_line_div ="";
  
  
      
    
    
  
  
  foreach($timeline_year as $t_year){
    
      ////////////////////////Get Time Line Files /////////////////////////////
    $time_line_display = "";

    if($user_type =='u' || $user_type=='a'){
    $time_line_query = mysql_query("SELECT * from images where own_id='$id' AND YEAR(uploaded_date)='$t_year' ORDER BY uploaded_date");
    }
    if($user_type =='d'){
    $time_line_query = mysql_query("SELECT * FROM images WHERE doctor_id ='$id' OR own_id ='$id' AND YEAR(uploaded_date) ='$t_year' ORDER BY uploaded_date");
    }

    while($row=mysql_fetch_array($time_line_query)){
      
    $t_id = $row["image_id"];
    $t_filename = $row["filename"];
    $t_filename2 = $row["filename2"];
    $t_date = $row["uploaded_date"];
    $t_title = $row["file_title"];
    $t_own = $row["own_id"];
    $t_desc = $row["file_desc"];
    
    $time_line_display.= '
     <div class="wrapper_records'.$t_year.'" style="display:none;float:left; ">
<div class="drive-item module text-center">
                                <div class="drive-item-inner module-inner">
                                    <div class="drive-item-title"><a href="#">'.$file_title.'</a></div>
                                    <div class="drive-item-thumb">
                                        <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="'.$file_title.'" data-caption="'. $t_desc.'" data-image="users/'.$t_own.'/reports/'.$t_filename.'" data-target="#image-gallery">
                                        <img class="img-responsive" src="users/'.$t_own.'/reports/'.$t_filename.'" lt="'.$t_filename.'"></a>
                                    </div>
                                </div>
                                <div class="drive-item-footer module-footer">
                                    <ul class="utilities list-inline">
                                        <li><a href="users/'.$t_own.'/reports/'.$t_filename.'"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Download" download><i class="fa fa-download" ></i></a></li>
                                        <li><a href="javascript:remove('.$t_id.')  data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a></li>
 <li><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-calendar"></i> '.date($t_date).'</a></li>
                                        
                                    </ul>
                                </div>
                            </div>


                </div>';
    
    }

  
  if($t_year == $t_date){
     $time_line_div.='<div class="btn-group btn-group-justified" role="group" aria-label="...">
     
     
                  
                  <div class="btn-group" role="group" >
                    <button id="'.$t_year.'" type="button" class="timeline_slide btn btn-primary btn-block">'.$t_year.'<span class="glyphicon glyphicon-heart-empty"></span></button>
                  </div>
                
                '.$time_line_display.'
                
              
                  
              </div>
              <div class="space2"></div>';
  }else{
  
  }
    }
  
    
  
  
  
  
  ////////////////////////////////////////////////////////////////////////////
  
///////////////////////////////////////////////////////////////////////
/////////////////////////////////END MECHANISM TO DISPLAY LINKS///////////////////////

//////////////////////MECHANISM TO parse BLAB FROM OTHERS//////////////////////////////
$blab_outout_msg = "";

/////////////////////mechanism to parse blabs for users profile/////////////
if(isset($_POST['blab_field']) && $_POST['blab_field'] != "" && $_POST['blab_field'] != " " ){
  $blabWipit = $_POST['blabWipit'];
  $sess_wipit = base64_decode($_SESSION['wipit']);
  //if(!isset($_SESSION['wipit'])) {
    //}elseif
  if($sess_wipit == $blabWipit){
    // Delete any blabs over 50 for this member
    // $sqlDeleteBlabs = mysql_query("SELECT * FROM blabbing WHERE mem_id='$id' ORDER BY blab_date DESC LIMIT 50");
     //$bi = 1;
      //while ($row = mysql_fetch_array($sqlDeleteBlabs)) 
        //{
       //$blad_id = $row["id"];
       //if ($bi > 20) {
          // $deleteBlabs = mysql_query("DELETE FROM blabbing WHERE id='$blad_id'");
         //}
       //$bi++;
      //}//close while
     }
      // End Delete any blabs over 20 for this member 
    //take values from form status  
    $blab_field = $_POST['blab_field'];
    $blab_field = preg_replace("#(\s{2,})#i", "",$blab_field); 
    $blab_field = str_replace("\\", "", $blab_field);
    $blab_field = stripslashes($blab_field);
    $blab_field = strip_tags($blab_field);
    $blab_field = mysql_real_escape_string($blab_field);
    $blab_field = str_replace("'", "&#39;", $blab_field);
    //if(strlen($blab_field) > 255)
      //{
    //  $blab_outout_msg = "<font color=\"#FF0000\">Error: Only 255 characters is allowed. Please try again.</font>";
      //}else
      if(strlen($blab_field) < 2 || $blab_field == "")
        {
        $blab_outout_msg = "<font color=\"#FF0000\">Error: Post at least 2 characters. Please try again.</font>";
        }else
          {
          $sql = mysql_query("INSERT INTO blabbing (mem_id, the_blab, blab_date) VALUES('$id','$blab_field', now())") 
              or die (mysql_error());
          $blab_new_id = mysql_insert_id();
          $blab_outout_msg = "";
          
    
      
          }//close else
      
  }//close if isset $_POST['blab_field']

  
// ------- ESTABLISH THE PROFILE INTERACTION TOKEN ---------//
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum); // Will always overwrite itself each time this script runs
// ------- END ESTABLISH THE PROFILE INTERACTION TOKEN ---------  


///////////////////////display the form for log-in user + interactionbox///////////////////////////////////////////////
$the_blab_form = "";
//$thisRandNum = rand(9999999999999,999999999999999999);
/*if(isset($_SESSION['idx']) && $logOptions_id != $id) {//If SESSION idx is set, AND it does not equal the profile owner's ID
  $the_blab_form = ' '.$blab_outout_msg.' '.
      '<form action="home.php?id='.$id.'" method="post" enctype="multipart/form-data" name="reply_from">'.
      '<div style=" padding:8px;">
      
      <input name="parse_var" type="hidden" value="reply" />
      <input name="id" type="hidden" value="'.$id.'" />
      <textarea name="reply_field" cols="60" class="status_textarea" id="update"></textarea>
            <div align="right">
      <input name="updateBtn2" type="submit" id="updateBtn2" value="Post" />
      </div>
      </div>
      </form>';
    
  }else*/
  if(isset($_SESSION['idx']) && $logOptions_id = $id) {// If SESSION idx is set, AND it does equal the profile owner's ID
    $the_blab_form = ' '.$blab_outout_msg.' '.'
    <form action="home.php" method="post" enctype="multipart/form-data" name="blab_from">
      <div style=" padding:8px;">
    
    <textarea name="blab_field" cols="60" class="status_textarea" id="update" placeholder="Post a news..."></textarea>
        <input name="blabWipit" type="hidden" value="' . $thisRandNum . '" />
    <div align="right">
        <input id="update_button" name="submit" type="submit" value="Update" />
    </div>
        </form>
         </div>'; 
     $interaction_box = '';
    }else {// If no SESSION id is set, which means we have a person who is not logged in
      $the_blab_form = '';
      $interaction_box = "";
        }
    // END DISPLAY OF THE STATUS OUTPUT////////

/////////////MECHANISM FOR DISPLAY UPLOADED PAGES/////////////////////////////
$pageDisplay="";

$sql_pages = mysql_query("SELECT * FROM page where own_id='$id' ORDER BY uploaded_date");
while($row = mysql_fetch_array($sql_pages)){
  $pid = $row['page_id'];
  $pname = $row['file_title'];
  
  
  }
  $page_check = mysql_num_rows($sql_pages);
if($page_check != 0){
  $pageDisplay = '<div id='.$pid.'>'.$pname.'-<span><span class="color"><a href="javascript:remove8('.$pid.')">Delete</a></span></span></div>'; }
  else{
    $pageDisplay ="Please add a page to continue";
    }
  
  ////////////////////// PAGE DELETE MECHANISM ////////////////////////
if(isset($_GET['remove_id8']))
{
  $res=mysql_query("SELECT * FROM page WHERE page_id=".$_GET['remove_id8']);
  $row=mysql_fetch_array($res);
  mysql_query("DELETE FROM page WHERE page_id=".$_GET['remove_id8']);
  unlink("".$row['file_title'].".php");
  header("Location: index.php");
}


////////////////////////////////////////// Mechanism to add new cases /////////////////////////////////////////////////////////////////////

if(isset($_POST['case_phone'])){

  $case_phone = preg_replace('#[^0-9]#i', '', $_POST['case_phone']); // filter everything but numbers
  $case_disease = preg_replace("#(\s{2,})#i", "",$_POST['case_disease']); 
  $case_desc = preg_replace("#(\s{2,})#i", "",$_POST['case_desc']); 
  $case_sym = preg_replace("#(\s{2,})#i", "",$_POST['case_sym']);
  $case_meds = preg_replace("#(\s{2,})#i", "",$_POST['case_meds']);
  $case_dur= preg_replace("#(\s{2,})#i", "",$_POST['case_dur']);

  $c_query = mysql_query("INSERT INTO cases (doc_id, case_phone, case_disease, case_desc, case_sym,case_meds, case_dur, case_date) VALUES('$id', '$case_phone', '$case_disease', '$case_desc', '$case_sym','$case_meds', '$case_dur', now())")  
     or die (mysql_error());

     echo 'Successfully added a new case';
}



    
    ////////////////Push Notification //////////////////////////////////

  $sql_push = mysql_query("SELECT * FROM cases where case_phone='$phone'");
  $sql_pcount = mysql_num_rows($sql_push);
  while($row = mysql_fetch_array($sql_push)){
   $cs_phone = $row['case_phone']; // filter everything but numbers
  $cs_disease = $row['case_disease']; 
  $cs_desc = $row['case_desc']; 
  $cs_sym = $row['case_sym'];
  $cs_meds = $row['case_meds'];
  $cs_dur= $row['case_dur'];
  $cs_date =$row['case_date'];

 $now = new DateTime();
    $startdate = new DateTime($case_date);
    $enddate = new DateTime($case_dur);

    if($startdate <= $now && $now <= $enddate) {
        $push_notify.= '<div>You are suffering from: '.$cs_disease.'</div>'.
        '<div>You need to take the following medicines: '.$cs_meds.'</div>';
    }else{
        $push_notify.= '';
    }


  }




   //////////////////////////////MECHANISM TO DISPLAY FRIENDS///////////////////////////////////////////////////////////////
$friends_list = "";
$i=0; //declare to check if its = to 2 so that add tr inside the foreach loop
$num = 5;
if($con_array != ""){
    $con_array = explode(",", $con_array);
    $con_count = count($con_array);
    $con_array6 = array_slice($con_array, 0, 10);
    
    /*$friends_list.='<div class="infoHeader">'.$show_name.' Friends (<font color="#FF0000">'.$friends_count.'</font>)</div>';
    */
    $friends_list.='<table id="connections_table" align="center" border="0"><tr>';
    foreach($con_array6 as $key => $value){
    
      $sql = mysql_query("SELECT * FROM users WHERE phone='$value' LIMIT 1");
      
      
      while($row = mysql_fetch_array($sql)){
        $friend_uname = $row['username'];
        $f_id = $row['id'];
       
      
        
        }//close while

          $check_pic = "users/".$f_id."/profile.jpg";
        if(file_exists($check_pic)){
          $friends_pic = '<a href="profile.php?id=' . $f_id . '"><img class="connections_pic" style="width:80px;height:80px;" src="' . $check_pic . '"  /></a>';
            }else {
              $friends_pic = '<img class="connections_pic" style="width:80px;height:80px;" src="' . $check_pic . '"  /></a>';
              } 
        
        //display now the friends 
      $friends_list.='<td valign="top"><div id="connections_user_div">'.$friends_pic.'</div><a href="profile.php?id='.$f_id.'">'.$friend_uname.'</a></td>';
      $i++;
      if($i == $num){
        $friends_list.="</tr><tr>";
        $i=0;
        }//close if i = $num
      
      
        
    }//close foreach
    /////mechanism to display view all or not///
    if($friends_count > 6)
      {
      $view_all = '<div id="view_friens_list" style="text-align:right;"><a href="#" onclick="return false" 
            onmousedown="javascript:view_all_friends(\''.$id.'\');">View all</a></div>';
      }else
        {
        $view_all = '';
        }
    
    $friends_list.='</table>'.$view_all.'</div>';
      
  }else{ //if friends array is empty this code will run
    $friends_list = "";
    }




////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  
  
  $error_p ="";
  /////////////////////////////// Mechanism to connect with patients ///////////////////////////////////////
  if(isset($_POST['phone_c'])){

    $phone_c= preg_replace('#[^0-9]#i', '', $_POST['phone_c']); // filter everything but numbers
  // Connect to database
  
    $sql_check_if_con = mysql_query("SELECT con_array FROM users WHERE id='$id' LIMIT 1") or die(mysql_error());
    $sql_con_check2 = mysql_query("SELECT usera,userb FROM con_req WHERE usera='$phone'");
     $con_check2 = mysql_num_rows($sql_con_check2);

  while($row = mysql_fetch_array($sql_check_if_con))
    {
    $con_list = $row['con_array'];
    }//close while

    $con_list_arr = explode(",", $con_list);
      if(in_array($phone, $con_list_arr)){
        echo '<div>Already connected to this number</div>';
      }elseif($phone == $phone_c){
        echo 'You cant connect with yourself';
      }elseif($con_check2>0){
        echo 'Request pending';

      }else{

       $sql = mysql_query("INSERT INTO con_req (usera, userb, con_date) VALUES('$phone','$phone_c',now())")  
     or die (mysql_error());
      

       echo 'success';
      }


      }

      ////////////////////// Notification for phone Request /////////////////////////

      $sql_alert_p = mysql_query("SELECT * from con_req where userb='$phone' LIMIT 1"); 


      $check_palert = mysql_num_rows($sql_alert_p);   

      while($row=mysql_fetch_array($sql_alert_p)){
        $ap_id = $row["id"];
        $c_u = $row["usera"]; 
        $con_date = $row["con_date"];

        $sql_cname = mysql_query("SELECT * from users where phone='$c_u' LIMIT 1");

        while($row= mysql_fetch_array($sql_cname)){

        $d_name= $row['username'];
        }
        
        if($check_palert>0){

        $p_alert.= '<div id="'.$ap_id.'""> '.$d_name.' wants to connect to you</div>

        <a id="'.$c_u.'" class="accept" onclick="return false">Accept</a> | 
        <a id="'.$c_u.'" class="deny" onclick="return false">Deny</a>';

      }else{
        $p_alert.= '';
      }
      }
      
  
  
//////////////MECHANISM for displaying blabs////////////////////////////////////
    $blabDisplay="";
    ///////  END Mechanism to Display Pic 
$sql_blabs = mysql_query("SELECT * FROM blabbing where mem_id='$id' ORDER 
                BY blab_date DESC LIMIT 20");


while($row = mysql_fetch_array($sql_blabs)){
$row_id = $row['id'];
      $id_to_delete = "tms007".$row_id; 
      //$encrypted_login_id = base64_encode("g4p3h9xfn8sq03hs2234h$id_to_delete");
      $the_blab = $row['the_blab'];
      $whenBlab = $row['blab_date'];
      //get the ago date/time
      $converted_time = ($my_object -> convert_datetime($whenBlab));
      $blab_date_converted = ($my_object -> makeAgo($converted_time));
      $blabbers_id = $row["mem_id"];
      ///////////////////
      $sql5 = mysql_query("SELECT id, username FROM users where id = '$blabbers_id' LIMIT 1");
        while($row = mysql_fetch_array($sql5)) 
          {
          $blabbers_poster_id = $row['id'];
          //$blabbers_uname = $row['username'];
          
          }
      //check for username display
      
  
  
  $del_btn = "";
        if(isset($_SESSION['idx']))
          {
          if($id == $logOptions_id)
            {
            $del_btn = '<a href="#" class="delete_blab" id="'.$row_id.'" alt="remove">Delete</a>';
            }else
              {
              $del_btn = '';
              }}

$check_pic4 = "users/$blabbers_poster_id/profile.jpg";
      $default_pic = "users/0/profile.png";
      if (file_exists($check_pic4)) 
        {
        $member_pic = "<img style=\"margin-left:35%;\" class=\"img-circle col-md-offset-1\" width=\"150px\" height=\"150\" src=\"$check_pic4?$cacheBuster\" width=\"150px\" height=\"150px\"  border=\"0\" />"; 
        } else
           {
          $member_pic = "<img style=\"margin-left:35%;\" class=\"img-circle col-md-offset-1\" width=\"150px\" height=\"150\" src=\"$default_pic\" width=\"150px\" height=\"150px\" border=\"0\"  />"; 
          }
            
        $blabDisplay.= '
        
          <div class="feed_display" id="full_blab_div'.$row_id.'">
      <div class="news" id="full_blab_div'.$row_id.'">
              
 
              <div class="wrapper">
                <div class="date">'. $whenBlab .'</div>
              </div>
              <div>'. $del_btn . '</div>
        
        <div class="full_blab_div" id="full_blab_div'.$row_id.'">
<div class="wrapper"><div id="b_profile_pic">'. $member_pic .'</div>
              <div id="b_div"> '. $the_blab . '</div>
              </div>
            </div></div></div>';
  
}







//-----encoded str for delete response-----------//
$thisRandNum2 = rand(999999999999,99999999999999999);
//----------END ENCODE STR FOR DELETE RESPONSE----------///



///////////////////////////////MECHANISM TO FETCH CONNECTIONS///////////////////////////////////////////////////////////////
$sql_check_if_con = mysql_query("SELECT con_array FROM users WHERE id='$id' LIMIT 1") or die(mysql_error());
  while($row = mysql_fetch_array($sql_check_if_con))
    {
    $con_list = $row['con_array'];
    }//close while
  if($con_list != "")
    {
    $con_list_arr = explode(",", $con_list);
    if(in_array($logOptions_id, $con_list_arr))
      {
      $interaction_box.='<a id="control_button" href="#" onclick="return false" 
                  onmousedown="javascript:toggleSlideBox(\'disconnect_user_div\');">Disconnect</a>';
      }else
        {
        $interaction_box.='<a id="control_button" href="#" onclick="return false" 
                  onmousedown="javascript:toggleSlideBox(\'connect_user_div\');">Connect</a>';
        }
    }else
      {
      $interaction_box.='
                <a id="control_button" href="#" onclick="return false" onmousedown="javascript:toggleSlideBox(\'connect_user_div\');">Connect</a>';
      }//close else for if $friends != empty


?>

<?php
include('functions.php');

// Get Top Rankings
$result = mysql_query("SELECT *, ROUND(score/(1+(losses/wins))) AS performance FROM images ORDER BY ROUND(score/(1+(losses/wins))) DESC");
while($row = mysql_fetch_object($result)) $top_ratings[] = (object) $row;

?>
<?php
// Get minimum uploaded date


// Get random 2
$query="SELECT * FROM images WHERE image_id AND own_id='$id' ORDER BY uploaded_date";
$result = @mysql_query($query);

while($row = mysql_fetch_object($result)) {
  $images[] = (object) $row;
}
?>
<?if (isset($_POST['parse_var'])){
$thisWipit = $_POST['thisWipit'];
$sessWipit = base64_decode($_SESSION['wipit']);

if ($_POST['parse_var'] == "about"){
  $about_body = $_POST['about_body'];
   // Update the database data now here for all fields posted in the form
   $sqlUpdate = mysql_query("UPDATE users SET about_body='$about_body' WHERE id='$id' LIMIT 1");
     if ($sqlUpdate){
            $success_msg = '<img src="images/round_success.png" width="20" height="20" alt="Success" />Your health mood has been updated sucessfully.';
     } else {
        $error_msg = '<img src="images/round_error.png" width="20" height="20" alt="Failure" /> ERROR: Problems arose during the information exchange, please try again later.</font>';
     }
}
} // <<--- This closes "if ($_POST['parse_var']){"
//if (!isset($_SESSION['wipit'])) { // Check to see if session wipit is set yet
//  session_register('wipit'); // Be sure to register the session if it is not set yet
//}
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
// Close the connection
mysql_close();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
      <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</head>


<style type="text/css">
	#patient-pro-wrapper{

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
  <script>
$(document).ready(function() {
  $("body").delegate(".timeline_slide", "click", function() {
      var element = $(this);
      var ids = element.attr("id");
      $(".wrapper_records"+ids).slideToggle();
       $(".wrapper_records"+ids).css("display:block;");
        
      });



$("#search_q").keyup(function() 
{
var search_q= $(this).val();
var dataString = 'searchword='+ search_q;

if(search_q=='')
{
document.getElementById('display').style.display = 'none';
}
else
{

$.ajax({
type: "POST",
url: "search.php",
data: dataString,
cache: false,
success: function(html)
{

$("#display").html(html).show();
  
  }


});


}return false;    


});

//////IF LOGIN USER ACCPT A FRND//////
$(".accept").click(function(){
  var pid = $(this).attr("id");
 
  var url = "con_parse.php";
  $("#loader"+pid).html("<img src='images/loading30.gif' />").fadeIn().delay(7000).fadeOut();
  //$("#loader").fadeIn().delay(10000).fadeOut();
  $.post(url, {request: "acceptCon", reqID: pid}, function(data){
    //$("#loader").html(data).show();
    window.location.href = data;
  });//close function(data) success
});//close $.accept

////////////////IF A USER DENY FRIEND REQUESTS////
$(".deny").click(function(){
  var pid = $(this).attr("id");
  alert(pid);
  var url = "con_parse.php";
  $("#loader"+pid).html("<img src='images/loading30.gif' />").fadeIn().delay(7000).fadeOut();
  //$("#loader").fadeIn().delay(10000).fadeOut();
  $.post(url, {request: "denyCon", reqID: pid}, function(data){
    $("#loader"+pid).html(data).parent().parent().fadeOut();
    //$("#loader").html(data).show();
    //window.location.href = data;
  });//close function(data) success
});//close $.deny
});




</script>
<script>
$(document).ready(function(){
    $("#alertview").click(function(){
        $("#alertbox").slideToggle();
    });
      $("#remview").click(function(){
        $("#rembox").slideToggle();
    });
    

});
</script>
<script type="text/javascript">
  $(document).ready(function(){

    loadGallery(true, 'a.thumbnail');

    //This function disables buttons when needed
    function disableButtons(counter_max, counter_current){
        $('#show-previous-image, #show-next-image').show();
        if(counter_max == counter_current){
            $('#show-next-image').hide();
        } else if (counter_current == 1){
            $('#show-previous-image').hide();
        }
    }

    /**
     *
     * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
     * @param setClickAttr  Sets the attribute for the click handler.
     */

    function loadGallery(setIDs, setClickAttr){
        var current_image,
            selector,
            counter = 0;

        $('#show-next-image, #show-previous-image').click(function(){
            if($(this).attr('id') == 'show-previous-image'){
                current_image--;
            } else {
                current_image++;
            }

            selector = $('[data-image-id="' + current_image + '"]');
            updateGallery(selector);
        });

        function updateGallery(selector) {
            var $sel = selector;
            current_image = $sel.data('image-id');
            $('#image-gallery-caption').text($sel.data('caption'));
            $('#image-gallery-title').text($sel.data('title'));
            $('#image-gallery-image').attr('src', $sel.data('image'));
            disableButtons(counter, $sel.data('image-id'));
        }

        if(setIDs == true){
            $('[data-image-id]').each(function(){
                counter++;
                $(this).attr('data-image-id',counter);
            });
        }
        $(setClickAttr).on('click',function(){
            updateGallery($(this));
        });
    }
});
</script>

<script type="text/javascript">
function remove(report_id)
{
  if(confirm(' Sure to remove this report ? '))
  {
    window.location='delete.php?remove_id3='+report_id;
  }
}
</script>

<?php 
if(isset($_SESSION['idx'])){

if($user_type =='u'){ 
include_once("user_body.php");
}elseif($user_type=='d'){
include_once("doc_body.php");
}else{
  include_once("def_body.php");
}
}else{
  echo 'You didnt find what you came looking for';
}
?>
</html>
