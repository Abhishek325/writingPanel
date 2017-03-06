<?php  
$conn = mysqli_connect("localhost","root","") or die("Error");
mysqli_select_db($conn,"mediawriting"); 
   $arr = array();
   
   $rs = mysqli_query($conn,"SELECT j.jname as Job,j.jid As JobId,u.name as Writer,jwm.time as submitted_on,jwm.approved as Status,j.employer as Employer,j.namount as Amount,(j.tries-jchm.checkout_count) as Retries,.j.writer_level  as Level FROM `job_content_map` jcm,`job_checkout_map` jchm,job_writer_map jwm,user_details u, jobs j,writerlevel w where j.jid=jcm.jid and jcm.uid=u.uid and jwm.jid=j.jid and jchm.jid=j.jid and  j.writer_level=w.level  and jwm.uid=u.uid and jwm.submit='Y'; ");

   while($obj = mysqli_fetch_array($rs)) {
   	   $status = $obj['Status'];
   	   if($status=='Y')
   	   	$obj['Status']='Approved';
   	   else if($status=='NA')
   	   	$obj['Status']='To be reviewed';  
    	$arr[]=array_map('utf8_encode', $obj);
  }
  header("Content-type: application/json"); 
  echo "{\"data\":" .json_encode($arr). "}";
?> 


