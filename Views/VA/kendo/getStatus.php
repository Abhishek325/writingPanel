<?php  
$conn = mysqli_connect("localhost","root","") or die("Error");
mysqli_select_db($conn,"mediawriting"); 
   $arr = array();

   $rs = mysqli_query($conn,"SELECT distinct approved as Status FROM job_writer_map");

   while($obj = mysqli_fetch_array($rs)) { $status = $obj['Status'];
   	   if($status=='Y')
   	   	$obj['Status']='Approved';
   	   else if($status=='NA')
   	   	$obj['Status']='To be reviewed';
    	$arr[]=array_map('utf8_encode', $obj);
  }
  header("Content-type: application/json"); 
  echo "{\"data\":" .json_encode($arr). "}";
?> 


