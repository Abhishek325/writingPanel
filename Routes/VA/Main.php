 <?php   
  session_start();
  date_default_timezone_set('Asia/Kolkata'); 
/**
 * @package Routes 
 **/   

$Router->get('/members/',function() use ($Service) {
	include('Views/VA/common_login-register_page.html');
});

$Router->post('/members/register',function() use ($Service) {  
	 $Service->Prote()->DBI()->user()->func()->make_salt($_POST['username'],$_POST['pwd']);
	 $pwd=$Service->Prote()->DBI()->user()->func()->generate_hash($_POST['pwd']);  
	 echo $pwd; 
	 exit();
	 if($_POST['pwd']!=$_POST['pwdn'])
	 {
	 	echo "<center>Passwords you entered don't match !!!<br>Please try again.<br>
	 			<button onclick='window.history.back()'>Go back</button>
	 		  </center>";
	 	exit();
	 }
	 if($Service->Prote()->DBI()->user()->common()->addUser($_POST['name'],$_POST['username'],$_POST['email'],$pwd))
	 {

	 	 $successMsg = "<p style='color:#333;text-align: center;font-weight: 600;
		 	font-family:\"Open Sans\", sans-serif;'>You have been succesfully registered.<br>Login to continue <b>:</b></p>";
		 include('Views/VA/common_login-register_page.html');
	 }
	 else
	 	echo "Sorry something went wrong...<br>Try again";
});

$Router->post('/members/login',function() use ($Service) { 
	if($Service->Auth()->login($_POST['uname'],$_POST['upwd'],$Service->Html()->auth_token))
	{  
	 $_SESSION['uname']=$_POST['uname'];
     $_SESSION['userName']=$Service->Prote()->DBI()->user()->common()->mapUser($_SESSION['uname']);
	 $_SESSION['userId']=$Service->Prote()->DBI()->user()->common()->mapUserId($_SESSION['uname']);	
	 $user_type = $Service->Prote()->DBI()->user()->common()->getUserType($_SESSION['userId']); 
	 $_SESSION['userType'] = $user_type;
	 header("location:/members/dashboard");   
	}
	else
	{
		 $errMsg = 
		 "<p style='color: rgba(255, 0, 0, 0.95);font-weight: bold;text-align: center;
		 	font-family:\"Open Sans\", sans-serif;'>Invalid username or password</p>";
		 include('Views/VA/common_login-register_page.html');
	}		
}); 

$Router->post('/members/changeEmail',function() use ($Service) { 
	if($Service->Auth()->logged_in())  
	{   
	 $Service->Prote()->DBI()->user()->common()->changeEmail($_SESSION['userId'],$_POST['email']);  
	 header("location:/members/dashboard");   
	} 	
});

$Router->get('/members/dashboard',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{   
	 	$userName = $_SESSION['userName'];
	 	$userId = $_SESSION['userId'];

	    switch ($_SESSION['userType']) {
	 	case 'A': $UserType="Admin"; 	
	 			  include("Views/VA/admin.html");
	 			  break; 
	 	case 'E': $UserType="Editor"; 
	 			  include("Views/VA/editor.html");
	 			  break; 
	 	case 'S':
	 	case 'W': $UserType="Writer"; 
	 			  include("Views/VA/writer.html"); 
	 			  break; 
	 	default: $UserType="Writer";
	 			  include("Views/VA/writer.html");  
	 			 break;
	 }  
	}
	else
		header("location:/members");
});

$Router->post('/members/logout',function() use ($Service) {
	if($Service->Auth()->logout($_POST['auth_token'])){
		    header("location:/members");
		}
		else{
			 session_destroy();
			 header("location:/members");	 
		}
});

$Router->get('/members/checkUserName',function() use ($Service) { 
	 $name=$_GET['username'];
	 if($Service->Prote()->DBI()->user()->validate()->checkUserName($name)==true)
	  echo "<div style='color:rgb(255,0,9);font-size:12px;'><b> Username <em>".$name."</em> is taken!!! Try something else.</bdiv>"; 
	 else
	  echo "007"; 
});

$Router->get('/members/checkUserEmail',function() use ($Service) { 
	 $name=$_GET['email'];
	 if($Service->Prote()->DBI()->user()->validate()->checkUserEmail($name)==true)
	  echo "<div style='color:rgb(255,0,9);font-size:12px;'><b> This Email-Id  is already registered!!! Try another email.</bdiv>"; 
	 else
	  echo "007"; 
});

$Router->get('/members/chat',function() use ($Service) {  
	 include('Views/VA/chat/index.php'); 
});

$Router->post('/members/mngEditor',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{
	  $editor=$_POST['edname']; 
	  include($Service->Config()->get_basepath().'/Views/VA/header.html');
	  $c=$Service->Prote()->DBI()->user()->common()->getUserSpecDetails($editor); 
	  foreach ($c as $data) { 
	  	echo "<div id='wrapper'>  
	        <div id='page-wrapper'> 
            <div class='container-fluid'> 
                <!-- Page Heading -->
                <div class='row'>
                    <div class='col-lg-12'>
                        <h2 class='page-header'>
                             ".$data->uname."'s details
                        </h2>  
                    </div> 
                    <div class='col-sm-4'>
                    		<form action='/members/updateUserDet' method='post'> 
                    		  <input type='hidden'  name='uid' maxlength='200' value='".$data->uid."'> 
                              <input type='email' class='form-control' name='email' maxlength='200' placeholder='".$data->uname." email' value='".$data->email."' required>   
                               <input type='text' class='form-control' name='edname' maxlength='200' placeholder='".$data->uname." full name' value='".$data->name."' required>   
                               <input type='text' class='form-control' name='ename' maxlength='200' placeholder='".$data->uname." user name' value='".$data->email."' required>   
                               <small>Write a new password to update password</small>
                               <input type='password' class='form-control' name='password' maxlength='200' pattern='.{8,}' placeholder='".$data->uname." password' required>     
                       <button type='submit'  class='btn btn-success' >Update editor</button>  
                      </form> 
                      ";
	  			break;
	  }
	} 
	else
		header("location:/members");
});

$Router->post('/members/addTip',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{  
	  if($_POST['tipTitle']&&$_POST['tipContent'])
	  { 
	   if($Service->Prote()->DBI()->user()->common()->addTip($_POST['tipTitle'],$_POST['tipContent'],$_POST['type']))
	   {
	   	$Msg = "<div class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Tip has been succesfully added.</div>";
	  	include('Views/VA/admin.html');
	   }
	   else
	   	echo "Something went wrong";
	  }
	  else		
	   echo "Data insufficiency!!!";
	} 
	else
		header("location:/members");
});

$Router->post('/members/removeTip',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{   
	  if($Service->Prote()->DBI()->user()->common()->removeTip($_POST['tipId']))
	  	header("location:/members/mngTips");
	  echo "Something went wrong";
	} 
	else
		header("location:/members");
});

$Router->post('/members/addAnnouncement',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{  
	  if($_POST['announcement'])
	  if($Service->Prote()->DBI()->user()->common()->addAnnouncement($_POST['announcement'],$_POST['type'])) 
	  { 
	    $Msg = "<div class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Announcement has been succesfully added.</div>";            
	  	include('Views/VA/admin.html');
	  }
	  echo "Something went wrong";
	} 
	else
		header("location:/members");
});

$Router->post('/members/addEmployer',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{  
	  if($_POST['ename']&&$_POST['efrom']&&$_POST['info'])
	  if($Service->Prote()->DBI()->user()->common()->addEmployer($_POST['ename'],$_POST['efrom'],$_POST['link'],$_POST['info']))
	  	header("location:/members/admin_system_configure");
	  echo "Something went wrong";
	} 
	else
		header("location:/members");
});

$Router->get('/members/Job',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{  
	  include('Views/VA/job.html');  			  
	} 
	else
		header("location:/members");
});

$Router->post('/members/addJob',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{   
	  $jobname = $_POST['name'];
	  $jobtype = $_POST['type'];
	  $employer = $_POST['employer'];
	  $epay = $_POST['pay'];
	  if($_POST['predesc'])
	   $description = $_POST['predesc'];
	  else
	  $description = $_POST['description']; 

	  $level = $_POST['writer'];
	  $words = $_POST['words'];
	  $namnt = $_POST['namount'];
	  $bamnt = $_POST['bamount'];
	  $tries = $_POST['tries']; 
	  $h = $_POST['hours'];
	  $m = $_POST['minutes'];  
	  if(isset($_FILES["sample"]["name"]))
	   $target_file=$_FILES["sample"]["name"];
	  else
	   $target_file="";	
	  if($_POST['uploadFile']=='Y')
	  { 
	  $target_dir = 'Static/VA/uploads/';
			$new_filename = $_SESSION['id'].'_file'.uniqid();
			$file_img_name= $new_filename.basename($_FILES["sample"]["name"]); 
			$target_file = $target_dir . $file_img_name;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);  
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			    exit();
			}
			// Check file size Max 5 MB
			if ($_FILES["sample"]["size"] > (5*1024*1024)) {
			    //echo "Sorry, your file is too large.";
			    $default_select_error_msg=$_FILES["sample"]["size"]."Document upload failed due to large size.<br>"; 
			    echo $default_select_error_msg;   
			    $uploadOk = 0; 
			}
			// Allow certain file formats
			$imageFileType=strtolower($imageFileType); 
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			    exit();
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["sample"]["tmp_name"], $target_file)) {
			    		echo "Upload successful !!";
			    	}
			     }
		} //upload file 
		if($Service->Prote()->DBI()->user()->common()->addJob($jobname,$jobtype,$employer,$epay,$description,$level,$words,$namnt,$bamnt,$tries,$h,$m,$target_file))
				  { 
				  	$Msg = "<div class='alert alert-info alert-dismissable'>
                                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Your job with name <b><em>".$jobname."</em></b> has been succesfully added.
                                  <br>Assign this job to a writer now <b>:</b><br>  
                                  <div class='form-group input-group'> 
                                  <form action='/members/assignWriter' method='post' onsubmit='return confirm(\"Are you sure?\")'>
                                    <select class='form-control' style='width:80%;' name='writer' required>";  
                                     $jid=$Service->Prote()->DBI()->user()->common()->getLastJobId(); 

                                     $c = $Service->Prote()->DBI()->user()->common()->getWriterList(); 
                                     foreach($c as $data){
                                      $Msg = $Msg."<option value='".$data->uid."'>".$data->name."</option>";
                                     }   
                                    $Msg = $Msg."</select>  
                                    <input type='hidden' value='".$jid."' name='jid'>
                                    <span class='input-group-addon' style='padding:0;line-height:0;background:none;border:none;float: left;'>
                                    <button type='sumit' class='btn btn-info' style=''>Assign</button>
                                    </span>
                                    <a href='/members/dashboard' class='btn btn-primary' style='margin-top:1rem;'>Dashboard</a>
                                   </form>
                                  </div> 
                                  </div> "; 
				  }
				  else
				  { 
				  		$Msg = "<div class='alert alert-info alert-dismissable'>
			                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='fa fa-info-circle'></i>&nbsp;There is some error processing your request. Please try again after some time.</div>"; 
				  }  
				 if($_SESSION['userType']=='A')
				 {
				 	$UserType="Admin"; 	  
	 			 }
	 		     else if($_SESSION['userType']=='E')
	 		     { 
	 		     	$UserType="Editor";  
	 			 }
	 			 else
	 			 { 
	 			 	$UserType="Writer"; 
	 			 } 
	 			 	include('Views/VA/job.html');  			     
	} 
	else
		header("location:/members");
});

$Router->post('/members/assignWriter',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{   
		$writer = $_POST['writer']; 
		$jid = $_POST['jid']; 
		$Service->Prote()->DBI()->user()->common()->assignWriter($writer,$jid); 
		$assignMsg = "<div class='alert alert-success alert-dismissable'>
			                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='fa fa-info-circle'></i>&nbsp;The job (jid:".$jid.") has been succesfully assigned.</div>";
        $Service->Prote()->DBI()->user()->common()->addUserNotification($writer,"Job assigned","The job with id:".$jid." has been assigned to you.Click <a href='/members/submitJob'>here</a> to view job"); 
	    include('Views/VA/job.html');  			     
	}
	else
		header("location:/members");
});

$Router->post('/members/saveJob',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{   
	  $jobname = $_POST['name'];
	  $jobtype = $_POST['type'];
	  $employer = $_POST['employer'];
	  $epay = $_POST['pay']; 
	  $description = $_POST['description'];  
	  $level = $_POST['writer'];
	  $words = $_POST['words'];
	  $namnt = $_POST['namount'];
	  $bamnt = $_POST['bamount'];
	  $tries = $_POST['tries']; 
	  $h = $_POST['hours'];
	  $m = $_POST['minutes'];   
	  if(isset($_FILES["sample"]["name"]))
	   $target_file=$_FILES["sample"]["name"];
	  else
	   $target_file="";	
	  if($target_file!="")
	  { 
	  $target_dir = 'Static/VA/uploads/';
			$new_filename = $_SESSION['id'].'_file'.uniqid();
			$file_img_name= $new_filename.basename($_FILES["sample"]["name"]); 
			$target_file = $target_dir . $file_img_name;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);  
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			    exit();
			}
			// Check file size Max 5 MB
			if ($_FILES["sample"]["size"] > (5*1024*1024)) {
			    //echo "Sorry, your file is too large.";
			    $default_select_error_msg=$_FILES["sample"]["size"]."Document upload failed due to large size.<br>"; 
			    echo $default_select_error_msg;   
			    $uploadOk = 0; 
			}
			// Allow certain file formats
			$imageFileType=strtolower($imageFileType); 
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			    exit();
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["sample"]["tmp_name"], $target_file)) {
			    		echo "Upload successful !!";
			    	}
			     }
		} //upload file 
		if($Service->Prote()->DBI()->user()->common()->updateJob($_POST['jid'],$jobname,$jobtype,$employer,$epay,$description,$level,$words,$namnt,$bamnt,$tries,$h,$m,$target_file))
				  { 
				  	$Msg = "<div class='alert alert-info alert-dismissable'>
			                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Your job with name <b><em>".$jobname."</em></b> has been succesfully updated.</div>"; 
				  }
				  else
				  { 
				  		$Msg = "<div class='alert alert-info alert-dismissable'>
			                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='fa fa-info-circle'></i>&nbsp;There is some error processing your request. Please try again after some time.</div>"; 
				  }  
				 if($_SESSION['userType']=='A')
				 {
				 	$UserType="Admin"; 	  
	 			 }
	 		     else if($_SESSION['userType']=='E')
	 		     { 
	 		     	$UserType="Editor";  
	 			 }
	 			 else
	 			 { 
	 			 	$UserType="Writer"; 
	 			 } 
	 			 	include('Views/VA/editjob.html');  			     
	} 
	else
		header("location:/members");
});

$Router->post('/members/blkunblk',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{  
	  $userName = $_POST['userName'];	
	  $userId = $Service->Prote()->DBI()->user()->common()->mapUserId($userName);
	  if($userName)
	  { 
	   $userStatus = $Service->Prote()->DBI()->user()->common()->getUserStat($userId); 
	   if($userStatus == "Blocked")
	   { 
	   	$oppStatus =  "Unblock";
	   	$statFlag = 'U';
	   }
	   else
	   { 
	   	$oppStatus =  "Block";
	   	$statFlag = 'B';
	   }
	   echo "The user <strong>".$userName."</strong> is <i>".$userStatus."</i><br>
	   		Click <form action='/members/updateStatus' method='post'>
	   			  <input type='hidden' name='stat' value='".$statFlag."'>
	   			  <input type='hidden' name='uid' value='".$userId."'>
	   			  <button type='submit'>here</button> to ".$oppStatus;
	  } 
	} 
	else
		header("location:/members");
});
$Router->post('/members/addJobAttachment',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='W'))  
	{
		$target_dir = 'Static/VA/uploads/';
			$new_filename = $_SESSION['id'].'_file'.uniqid();
			$file_img_name= $new_filename.basename($_FILES["sample"]["name"]); 
			$target_file = $target_dir . $file_img_name;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);  
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			    exit();
			}
			// Check file size Max 5 MB
			if ($_FILES["sample"]["size"] > (5*1024*1024)) {
			    //echo "Sorry, your file is too large.";
			    $default_select_error_msg=$_FILES["sample"]["size"]."Document upload failed due to large size.<br>"; 
			    echo $default_select_error_msg;   
			    $uploadOk = 0; 
			}
			// Allow certain file formats
			$imageFileType=strtolower($imageFileType); 
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			    exit();
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["sample"]["tmp_name"], $target_file)) 
			    { 
			    	 $Service->Prote()->DBI()->user()->common()->createUpdateAttachmentMap($_POST['uid'],$_POST['jid'],$target_file);
			    	  $Msg="<div class='alert alert-success alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            &nbsp;The attachment is succesfully added for this job..
                        </div>"; 
                        $jid = $_POST['jid'];
                        $uid = $_POST['uid'];
			    	 include('Views/VA/checkout.html');  
			    }
			}
	}
});

$Router->post('/members/updateStatus',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{    
	  if($Service->Prote()->DBI()->user()->common()->updateStatus($_POST['stat'],$_POST['uid'])) 
		header("location:/members/dashboard");   
	} 
	else
		header("location:/members");
});

$Router->post('/members/changePwd',function() use ($Service) {  
	$Service->Prote()->DBI()->user()->func()->make_salt($_SESSION['userName'],$_POST['prepwd']);
	$pwd=$Service->Prote()->DBI()->user()->func()->generate_hash($_POST['prepwd']);   
	if($Service->Prote()->DBI()->user()->common()->getpwd($_SESSION['userId'])==$pwd)
	{  
			if($Service->Prote()->DBI()->user()->common()->change_pwd($_POST['npwd1'],$_SESSION['userId']))
			{ 
	   			 $msgchangePwd="<div class='alert alert-info alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                                Your password has been succesfully changed @".date('H').":".date('i').":".date('s')."
                        </div>";  
			}
	}
	else
	{ 
	  			 $msgchangePwd="<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                                <i class='fa fa-info-circle'></i>&nbsp;The password you entered doesn't match with the existing password. Please try again.
                        </div>";  
	} 
				 if($_SESSION['userType']=='A')
				 {
				 	$UserType="Admin"; 	 
	 				include('Views/VA/admin.html');  			  
	 			 }
	 		     else if($_SESSION['userType']=='E')
	 		     { 
	 		     	$UserType="Editor"; 	
	 				include('Views/VA/editor.html');  			  
	 			 }
	 			 else
	 			 { 
	 			 	$UserType="Writer"; 	
	 			 	include('Views/VA/writer.html');  			     
	 			 }
}); 
 
$Router->get('/members/getJobTypeDetails',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{    
	  if($c = $Service->Prote()->DBI()->user()->common()->getJobTypeDetails($_GET['jobType']))
	  { 
	  	foreach ($c as $data) { 
	  		$jobDet = array($data->epay,$data->description,$data->words,$data->namount,$data->bamount,$data->tries,$data->jname,$data->file);
	  		break;
	  	}
	  	echo json_encode($jobDet);
	  }
	  else
	  {
	  	echo json_encode("Error");
	  }
	}
	else
	 header("location:/members");	
});

$Router->get('/members/getWriterFields',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{    
	  if($c= $Service->Prote()->DBI()->user()->common()->getWriterFields($_GET['writerLevel']))
	  { 
	  	 	foreach ($c as $data) { 
	  		$levelDet = array($data->words,$data->bamount,$data->namount,$data->tries);
	  		break;
	  	}
	  	echo json_encode($levelDet);
	  }
	  else
	  {
	  	echo json_encode("Error");
	  }
	}
	else
	 header("location:/members");	
});

$Router->get('/members/jobs',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{     
		include('Views/VA/startup_jobs.html');
	}
	else
	 header("location:/members");	
});

$Router->get('/members/ViewJobs',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{     
		include('Views/VA/admin_jobs.html');
	}
	else
	 header("location:/members");	
});

$Router->get('/members/editor-jobs-view',function() use ($Service) {
	if($Service->Auth()->logged_in()&&$_SESSION['userType']=='E')  
	{     
		include('Views/VA/editor_jobs.html');
	}
	else
	 header("location:/members");	
});

$Router->get('/members/jobinfo',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{       
	 $jid=openssl_decrypt(base64_decode(base64_decode(substr($_SERVER['REQUEST_URI'],21))),"AES-256-CBC",hash("sha256", "Abh1sh3k"),0,substr(hash("sha256",base64_encode(session_id())), 0,16));      
	 include('Views/VA/jobinfo.php');
	}
	else
	 header("location:/members");	
});

$Router->get('/members/adminJobView',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{       
	 $jid= $_GET['jid'];
	 $backToJobs = "Y";
	 include('Views/VA/jobinfo.php');
	}
	else
	 header("location:/members");	
});

$Router->get('/members/adminJobInfo',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{       
	 $jid=$_GET['jid'];
	 $_SESSION['jid']=$jid;
	 include('Views/VA/adminjobinfo.php');
	}
	else
	 header("location:/members");	
});

$Router->get('/members/admin_system_configure',function() use ($Service) {
	if($Service->Auth()->logged_in()&&$_SESSION['userType']=='A')  
	{        
	 include('Views/VA/configure.html');
	}
	else
	 header("location:/members");	
});

$Router->get('/members/editJob',function() use ($Service) {
	$jid = $_GET['jid'];
	include('Views/VA/editjob.html');
});

$Router->post('/members/addJobType',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{  
	  if($_POST['jtype'])
	  { 
	   if($Service->Prote()->DBI()->user()->common()->addJobType($_POST['jtype']))
	   {
	  	header("location:/members/admin_system_configure");
	   }
	   else
	   	echo "Something went wrong";
	  }
	  else		
	   echo "Data insufficiency reported!!!";
	} 
	else
		header("location:/members");
});

$Router->post('/members/addLevel',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{    
	  if($_POST['wlevel'])
	  { 
	   if($Service->Prote()->DBI()->user()->common()->addlevel($_POST['wlevel'],$_POST['words'] ,$_POST['rank'] ,$_POST['hlimit'],$_POST['climit'] ,$_POST['btime'] ,$_POST['namount']))
	   {
	  	header("location:/members/admin_system_configure");
	   }
	   else
	   	echo "Something went wrong";
	  }
	  else		
	   echo "Data insufficiency!!!";
	} 
	else
		header("location:/members");
});

$Router->post('/members/updateLevel',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{  
	  if($_POST['level'])
	  { 
	   if($Service->Prote()->DBI()->user()->common()->updatelevel($_POST['lid'],$_POST['level']))
	   {
	  	header("location:/members/admin_system_configure");
	   }
	   else
	   	echo "Something went wrong";
	  }
	  else		
	   echo "Data insufficiency!!!";
	} 
	else
		header("location:/members");
}); 

$Router->post('/members/updateJobType',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{  
	  if($_POST['jtype'])
	  { 
	   if($Service->Prote()->DBI()->user()->common()->updateJobType($_POST['jtid'],$_POST['jtype']))
	   {
	  	header("location:/members/admin_system_configure");
	   }
	   else
	   	echo "Something went wrong";
	  }
	  else		
	   echo "Data insufficiency!!!";
	} 
	else
		header("location:/members");
}); 

$Router->post('/members/updateTip',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{  
	  if($_POST['tid']&&$_POST['tipTitle']&&$_POST['tipContent'])
	  { 
	   if($Service->Prote()->DBI()->user()->common()->updateTip($_POST['tid'],$_POST['tipTitle'],$_POST['tipContent']))
	   {
	  	header("location:/members/mngTips");
	   }
	   else
	   	echo "Something went wrong";
	  }
	  else		
	   echo "Data insufficiency!!!";
	} 
	else
		header("location:/members");
});

$Router->post('/members/updateEmployer',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{  
	  if($_POST['eid']&&$_POST['employer'])
	  { 
	   if($Service->Prote()->DBI()->user()->common()->updateEmployer($_POST['eid'],$_POST['employer']))
	   {
	  	header("location:/members/dashboard");
	   }
	   else
	   	echo "Something went wrong";
	  }
	  else		
	   echo "Data insufficiency!!!";
	} 
	else
		header("location:/members");
});

$Router->post('/members/removeEmployer',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{   
	  if($Service->Prote()->DBI()->user()->common()->removeEmployer($_POST['eid']))
	  	header("location:/members/dashboard");
	  echo "Something went wrong";
	} 
	else
		header("location:/members");
});

$Router->get('/members/mngAnnouncements',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='A'))  
	{   
	   include($Service->Config()->get_basepath().'/Views/VA/header.html');	
	   echo "   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400' rel='stylesheet'>
	   <div id='wrapper'> 
        <div id='page-wrapper'>
            <div class='container-fluid'>
               <!-- Page Heading -->
                <div class='row'>
                    <div class='col-lg-8 col-md-offset-2'> 
                     <div class='table-responsive' style='margin-top: -1.5rem;'>  
                            <table class='table table-hover '>
                            <thead>
                                    <tr>   
                                        <th><h2>Announcements</h2></th>  
                                        </tr>
                                </thead>
                                <tbody>";
	 						  $c = $Service->Prote()->DBI()->user()->common()->getAnnouncements(); 
                              if($c)
                              { 
                               foreach($c as $data){  
                               echo "
                                        <tr><td> <form action='/members/updateAnnouncement' method='post' style='display: inline;'> 
                                         <input type='hidden' name='aid' value='".$data->aid."'>  
                                         <div class='form-group input-group'>
                                         <textarea rows='5' name='announcement' class='form-control'  style='border:none;font-size:16px;font-family: \"Open Sans\", sans-serif;'>".$data->announcement."'</textarea>
                                         <span class='input-group-addon' style='padding:0;line-height:0;background:none;border:none;'> 
                                         <button type='submit' class='btn btn-primary' ><i class='fa fa-check'></i></button>  
                                         </form>
                                         <form action='/members/removeAnnouncement' method='post' style=' display: inline'>
								          <input type='hidden' name='aid' value='".$data->aid."'>
								          <button type='submit' class='btn btn-danger'><i class='fa fa-close'></i></button>
								           </form>
                                		 </span>
                                         </div> 
                                       </td> 
          <td></td>
           </tr> 
          ";  
         }
        } 
        }  
	else
		header("location:/members");
});

$Router->get('/members/mngTips',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='A'))  
	{   
	   include($Service->Config()->get_basepath().'/Views/VA/header.html');	
	   echo "   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400' rel='stylesheet'>
	   <div id='wrapper'> 
        <div id='page-wrapper'>
            <div class='container-fluid'>
               <!-- Page Heading -->
                <div class='row'>
                    <div class='col-lg-8 col-md-offset-2'> 
                     <div class='table-responsive' style='margin-top: -1.5rem;'>  
                            <table class='table table-hover '>
                            <thead>
                                    <tr>   
                                        <th><h2>Tips</h2></th>  
                                        </tr>
                                </thead>
                                <tbody>";
	 						  $c = $Service->Prote()->DBI()->user()->common()->getTips(); 
                              if($c)
                              { 
                               foreach($c as $data){  
                               echo "
                                        <tr><td> 
                                        <form action='/members/updateTip' method='post' style='display: inline;'>  
                                         <div class='form-group input-group'> 
                                         <input type='hidden' name='tid' value='".$data->tid."'> 
                                         <input type='text' name='tipTitle' class='form-control' value='".$data->title."' style='border:none;border-bottom-style:1px solid #ccc;font-size:16px;font-family: \"Open Sans\", sans-serif;'required>
                                         <textarea rows='3' name='tipContent' class='form-control' autocomplete='off'style='border:none;font-size:16px;font-family: \"Open Sans\", sans-serif;' required>".$data->content."</textarea>   
                                         <span class='input-group-addon' style='padding:0;line-height:0;background:none;border:none;'> 
                                         <button type='submit' class='btn btn-primary' ><i class='fa fa-check'></i></button>  
                                         </form>
                                         <form action='/members/removeTip' method='post' style=' display: inline'>
								          <input type='hidden' name='tipId' value='".$data->tid."'>
								          <button type='submit' class='btn btn-danger'><i class='fa fa-close'></i></button>
								           </form>
                                		 </span>
                                         </div> 
                                       </td> 
          <td></td>
           </tr> 
          ";  
         }
        } 
        }  
	else
		header("location:/members");
});

$Router->post('/members/updateAnnouncement',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{  
	  if($_POST['aid']&&$_POST['announcement'])
	  { 
	   if($Service->Prote()->DBI()->user()->common()->updateAnnouncement($_POST['aid'],$_POST['announcement']))
	   {
	  	header("location:/members/mngAnnouncements");
	   }
	   else
	   	echo "Something went wrong";
	  }
	  else		
	   echo "Data insufficiency!!!";
	} 
	else
		header("location:/members");
});

$Router->post('/members/removeAnnouncement',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{   
	  if($Service->Prote()->DBI()->user()->common()->removeAnnouncement($_POST['aid']))
	  	header("location:/members/mngAnnouncements");
	  echo "Something went wrong";
	} 
	else
		header("location:/members");
});

$Router->post('/members/removeNoti',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{   
	  if($Service->Prote()->DBI()->user()->common()->removeNoti($_POST['nid']))
	  	header("location:/members/dashboard");
	  echo "Something went wrong";
	} 
	else
		header("location:/members");
});

$Router->post('/members/removeUserNoti',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{   
	  if($Service->Prote()->DBI()->user()->common()->removeUserNoti($_POST['nid']))
	  	header("location:/members/dashboard");
	  echo "Something went wrong";
	} 
	else
		header("location:/members");
});

$Router->post('/members/addEditor',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{   
	 $Service->Prote()->DBI()->user()->func()->make_salt($_POST['ename'],$_POST['password']);
	 $pwd=$Service->Prote()->DBI()->user()->func()->generate_hash($_POST['password']);   
	  if($Service->Prote()->DBI()->user()->common()->addUser($_POST['ename'],$_POST['edname'],$_POST['email'],$pwd,"E"))
	  	header("location:/members/dashboard");
	  echo "Something went wrong";
	} 
	else
		header("location:/members");
});

$Router->post('/members/updateUserDet',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{   
	  $Service->Prote()->DBI()->user()->common()->removeUser($_POST['uid']);
	  $Service->Prote()->DBI()->user()->func()->make_salt($_POST['ename'],$_POST['password']);
	  $pwd=$Service->Prote()->DBI()->user()->func()->generate_hash($_POST['password']);   
	  $Service->Prote()->DBI()->user()->common()->addUser($_POST['ename'],$_POST['edname'],$_POST['email'],$pwd,"E");
	  	header("location:/members/dashboard"); 
	} 
	else+
		header("location:/members");
});

$Router->get('/members/submitJob',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='W' ||$_SESSION['userType']=='S'))  
	{   
	   include('Views/VA/submitjob.html');
	} 
	else
		header("location:/members");
});

$Router->post('/members/apply',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='W' ||$_SESSION['userType']=='S'))  
	{      
	  if($Service->Prote()->DBI()->user()->common()->addJobUserMap($_POST['jid'],$_POST['uid']))
	  {  
	    $jid=$_POST['jid'];			                            
	  	header("location:/members/submitJob");
	  }
	} 
	else
		header("location:/members");
});

$Router->post('/members/submit',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='W' ||$_SESSION['userType']=='S'))  
	{       
	  	//Save job
	  	$Service->Prote()->DBI()->user()->common()->addJobContentMap($_POST['jid'],$_SESSION['userId'],$_POST['content']);
		$Service->Prote()->DBI()->user()->common()->addSubmitJobMap($_POST['jid'],$_SESSION['userId']); 
		$title="New job submitted @".date('H').":".date('i');
		$notification="A job (id:".$_POST['jid'].") has been submitted for approval by ".$_SESSION['userName']."(".$_SESSION['uname'].")";
		$Service->Prote()->DBI()->user()->common()->notifyAdmin($title,$notification); 
		$jid=base64_encode(base64_encode(openssl_encrypt(strtolower($_POST['jid']),"AES-256-CBC",hash("sha256", "Abh1sh3k"),0,substr(hash("sha256",base64_encode(session_id())), 0,16)))); 
		$sub="A job approval has been requested";
		$Service->Prote()->DBI()->user()->common()->sendEmail($sub,$notification); 
			  	header("location:/members/success?jid=".$jid); 
	} 
	else
		header("location:/members");
});

$Router->get('/members/submitted-jobs',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='A'))  
	{      
		include('Views/VA/subjobs.html');
	}
	else
		header("location:/members");	
});

$Router->get('/members/success',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='W' ||$_SESSION['userType']=='S'))  
	{       
		$jid=openssl_decrypt(base64_decode(base64_decode(substr($_SERVER['REQUEST_URI'],21))),"AES-256-CBC",hash("sha256", "Abh1sh3k"),0,substr(hash("sha256",base64_encode(session_id())), 0,16));       
		if($jid)
		{ 
		 $data=$Service->Prote()->DBI()->user()->common()->getJobDet($jid);
		 header("refresh:10;url=/members/submitJob");
	 	 include($Service->Config()->get_basepath().'/Views/VA/header.html');	
	     echo "   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400' rel='stylesheet'>
	     <div id='wrapper'> 
         <div id='page-wrapper'>
            <div class='container-fluid'>
               <!-- Page Heading -->
                <div class='row'>
                    <div class='col-lg-8'>
                    <h2 class='page-header'>
                    Job submitted succesfully</h2>
                    <div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Your job with title <b>".$data->jname."</b> has been submitted succesfully.<br>You will be notified about further progress.<br>
                    	<a href='/members/myJobs' class='btn btn-primary' style='padding:4px;border-radius:0;margin-top:5px;'>
                    		My Jobs</a></div>";    
       }
       else
       	header("location:/members/dashboard");
	} 
	else
		header("location:/members");
});

$Router->get('/members/myJobs',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='W' ||$_SESSION['userType']=='S'))  
	{   
	   include('Views/VA/myjobs.html');
	} 
	else
		header("location:/members");
});

$Router->post('/members/writeJob',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='W' ||$_SESSION['userType']=='S'))  
	{     
		 $jid= $_POST['jid'];
		 if($jobContent=$Service->Prote()->DBI()->user()->common()->getPreviousData($jid,$_SESSION['userId']))
		 { 
		 	if(isset($jobContent->last_saved))
		 		$lastSaved=$jobContent->last_saved;
		 	if(isset($jobContent->jobContent))
		 		$content=$jobContent->jobContent;
			include('Views/VA/checkout.html');
		}
	} 
	else
		header("location:/members");
});

$Router->post('/members/save',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{    
		 $jid= $_POST['jid'];
		 $jContent = $_POST['content'];
		 $uid=$_POST['uid'];
		 if($_SESSION['userType']=='S'||$_SESSION['userType']=='W')
		 { 
		  if($Service->Prote()->DBI()->user()->common()->addJobContentMap($jid,$_SESSION['userId'],$jContent))
		  {
		 	if($jobContent=$Service->Prote()->DBI()->user()->common()->getPreviousData($jid,$_SESSION['userId']))  $lastSaved=$jobContent->last_saved;  
		 	$content=$jContent; 	
		     include('Views/VA/checkout.html');
		  }
		 }
		  else
		 	 if($_SESSION['userType']=='A'||$_SESSION['userType']=='E')
		 	 {
		 	  $Service->Prote()->DBI()->user()->common()->addJobContentMap($jid,$uid,$jContent);	
		 	  $jname=$_POST['jname'] ;
		 	  $content=$jContent;
		 	  $jid = $_POST['jid'];
		      include('Views/VA/review.html');	
		  	} 
	} 
	else
		header("location:/members");
});

$Router->post('/members/reviewJob',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='A'))  
	{    
		 $jid= $_POST['jid']; 
		 $uid= $_POST['uid'];
		 $jname= $_POST['jname'];
		 $content=$Service->Prote()->DBI()->user()->common()->getPreviousData($jid,$uid)->jobContent;
		 include('Views/VA/review.html'); 
	} 
	else
		header("location:/members");
});

$Router->get('/members/reviewJob',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='A'))  
	{    
		 $jid= $_GET['jid']; 
		 $_SESSION['jid'] = $jid;
		 $uid= $Service->Prote()->DBI()->user()->common()->mapUserId($_GET['uname']);
		 $jname= $Service->Prote()->DBI()->user()->common()->getJobName($jid); 
		 $content=$Service->Prote()->DBI()->user()->common()->getPreviousData($jid,$uid)->jobContent;
		 include('Views/VA/review.html'); 
	}
	else
		header("location:/members");
});

$Router->post('/members/approveJob',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='A'))  
	{    
		 $jid= $_POST['jid']; 
		 $uid= $_POST['uid'];
		 $jname= $_POST['jname'];
		 $amount = $Service->Prote()->DBI()->user()->common()->getJobAmount($jid); 
		 //update startup to writer
		 if($Service->Prote()->DBI()->user()->common()->getUserType($uid)=='S') 
		  $Service->Prote()->DBI()->user()->common()->updateType($uid,'W');
		 $Service->Prote()->DBI()->user()->common()->updateApproveStatus('Y',$jid,$uid);
		 $Service->Prote()->DBI()->user()->common()->addPayment($uid,$jid,date("Y-m-d"),"For completing ".$jname." (id:".$jid.")","Income",$amount);
		 $Service->Prote()->DBI()->user()->common()->addUserNotification($uid,"Job approved","The job with id:".$jid." has been approved and payment has been added to  your account.Click on <i>Transactions</i> to view."); 
		 header("location:/members/submitted-jobs");
	} 
	else
		header("location:/members");
});

$Router->post('/members/cancelJob',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='A'))  
	{    
		 $jid= $_POST['jid']; 
		 $uid= $_POST['uid'];  
		 //remove everything related to this job.
		 $Service->Prote()->DBI()->user()->common()->deleteJob($jid); 
		 $Service->Prote()->DBI()->user()->common()->addUserNotification($uid,"Job deleted","The job with id:".$jid." has been deleted."); 
		 header("location:/members/submitted-jobs");
	} 
	else
		header("location:/members");
});

$Router->post('/members/disapproveJob',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='A'))  
	{    
		 $jid= $_POST['jid']; 
		 $uid= $_POST['uid']; 
		 $Service->Prote()->DBI()->user()->common()->updateApproveStatus('NA',$jid,$uid); 
		 $Service->Prote()->DBI()->user()->common()->updateSubmitstatus('N',$jid,$uid); 
		 $Service->Prote()->DBI()->user()->common()->addUserNotification($uid,"Re-submission requested","Your job with id:".$jid." has been requested for re-submission. Go to Submit Jobs to view your job.");
		 header("location:/members/submitted-jobs");
	} 
	else
		header("location:/members");
});

$Router->post('/members/pay',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='A'))  
	{    
		 $jid= $_POST['jid']; 
		 $uid= $_POST['uid'];   
		 include('Views/VA/pay.html'); 
	} 
	else
		header("location:/members");
});

$Router->post('/members/makePayment',function() use ($Service) {
	if($Service->Auth()->logged_in())  
	{     
		$jid=$_POST['jid'];
		$uid=$Service->Prote()->DBI()->user()->common()->mapUserId($_POST['uname']);	  
		//$Service->Prote()->DBI()->user()->common()->makePayment($jid,$uid,$_POST['amount'],$_POST['mode']);   
		$Service->Prote()->DBI()->user()->common()->addPayment($uid,$jid,date("Y/m/d"),"Payment done for job (id:".$jid.")","Payment",$_POST['amount']
			);
		include('Views/VA/feedback.html'); 
	} 
	else
		header("location:/members");
});

$Router->get('/members/viewJob',function() use ($Service) { 
		 $jid=$_GET['jid'];      
		 $content = $Service->Prote()->DBI()->user()->common()->getJobContent($jid); 
		 $_SESSION['jid']=$jid;   
		 if(!isset($_GET['uid']))
		 	$uid=$_SESSION['userId'];
		 else
		 	$uid=$_GET['uid'];
		 $content=$Service->Prote()->DBI()->user()->common()->getPreviousData($jid,$uid)->jobContent;
		 if($Service->Auth()->logged_in())
		 {  
		  echo "<title>Job @Mediawriting</title>".$content;  
		  echo "<iframe src='/members/chat' style='height:50%;width:300px;border:1px solid #ccc;position:fixed;top:0;right:0;'></iframe>";
		 }
		 else
		 	header("location:/members");
});

$Router->post('/members/reList',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='A'))  
	{    
		 $jid= $_POST['jid']; 
		 $uid= $_POST['uid'];  
		 $amount = $Service->Prote()->DBI()->user()->common()->getJobAmount($jid); 
		 $Service->Prote()->DBI()->user()->common()->relistjob($jid); 
		 if($Service->Prote()->DBI()->user()->common()->addPayment($uid,$jid,date("Y/m/d"),"Job re-listed (id:".$jid.")","Income",(-$amount))==-1)  
		 { 
		 	$Service->Prote()->DBI()->user()->common()->addUserNotification($uid,"Job Re-listed","Your job with id:".$jid." has been relisted. You can view it under <i>Select Jobs</i> of <i>My Menu</i> if it is available."); 	  
		 }
		 else 
		 $Service->Prote()->DBI()->user()->common()->addUserNotification($uid,"Job Re-listed","The job with id:".$jid." has been relisted. So your payment(".$amount.") wil be deducted from your account the same.");
		 header("location:/members/submitted-jobs");
	} 
	else
		header("location:/members");
});

$Router->post('/members/incCheckout',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='A'))  
	{     
		 $jid= $_POST['jid'];  
		 $uid= $_POST['uid'];
		 $Service->Prote()->DBI()->user()->common()->incCheckout($jid,$uid,1); //increase by 1
		 $Service->Prote()->DBI()->user()->common()->updateSubmitJobMap('N',$jid,$uid);
		 $Service->Prote()->DBI()->user()->common()->addUserNotification($uid,"Checkout exceeded","Your checkout limit for job with id:".$jid." has been increased. You can view your job under <i>Submit Jobs</i> of <i>My Menu</i>.");
		 header("location:/members/submitted-jobs");
	} 
	else
		header("location:/members");
});

$Router->get('/members/myTransactions',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='W'))  
	{       
		include('Views/VA/transaction.html');
	} 
	else
		header("location:/members");
});

$Router->get('/members/payWriters',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='E'))  
	{       
		include('Views/VA/pay.html');
	} 
	else
		header("location:/members");
});

$Router->post('/members/payWriter',function() use ($Service) {
	if($Service->Auth()->logged_in()&&($_SESSION['userType']=='E'))  
	{        
		include($Service->Config()->get_basepath().'/Views/VA/header.html');		
		echo "<body> 
			    <div id='wrapper'> 
			        <div id='page-wrapper' style='height:700px;'>
			            <div class='container-fluid'>
			               <!-- Page Heading -->
			                <div class='row'>
			                    <div class='col-lg-12'>
			                        <h1 class='page-header' >
			                            Transfer funds
			                        </h1> 
			                        Pay to <b>:</b> ".$_POST['uname']."<br>
			                        Pay by <b>:</b> ".$_SESSION['uname']."<br>
			                        <div class='col-lg-4' style='margin-left:-1.5rem;'>
			                        <form action='/members/makePayment' method='post' onsubmit='return confirm(\"Are your sure you want to transfer funds?\");'>
			                         <input type='hidden' name='jid' value='".$_POST['jid']."'> 
                                        <input type='hidden' name='uname' value='".$_POST['uname']."'> 
			                         <input type='number' placeholder='Amount to be transferred' min='0' class='form-control' value='".$_POST['amount']."' name='amount' required>
			                         <input type='text' placeholder='Mode of payment' min='0' class='form-control' name='mode' required>
			                         <button type='submit' class='btn btn-primary'>Transfer funds</button>
			                        </form>
			                        ";
	} 
	else
		header("location:/members");
});

$Router->post('/members/feedback',function() use ($Service) {
	if($Service->Auth()->logged_in())
	{
 		$r1= $_POST['f1'];
 		$r2= $_POST['f2'];
 		$r3= $_POST['f3'];
 		$r4= $_POST['f4'];
 		$r5= $_POST['f5'];
 		$r6= $_POST['f6'];
 		$rating = ($r1+$r2+$r3+$r4+$r5+$r6)/6;
 		$comment= $_POST['comment'];
 		if($Service->Prote()->DBI()->user()->common()->postReview($_POST['uid'],$_POST['jid'],$rating,$comment))
 		{
 			$Msg = "<div class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Payment has been succesfully made.</div>";
 		}
 		else
 		  $Msg = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Error processing this payment.</div>";	

 		  include('Views/VA/pay.html');
	}
	else
		header("location:/members");
});