<?php  
$conn = mysqli_connect("localhost","root","") or die("Error");
mysqli_select_db($conn,"mediawriting"); 
   $arr = array();

   $rs = mysqli_query($conn,"SELECT distinct ename as Employer FROM employer");

   while($obj = mysqli_fetch_array($rs)) { 
    	$arr[]=array_map('utf8_encode', $obj);
  }
  header("Content-type: application/json"); 
  echo "{\"data\":" .json_encode($arr). "}";
?> 


