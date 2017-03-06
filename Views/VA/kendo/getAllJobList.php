<?php  
$conn = mysqli_connect("localhost","root","") or die("Error");
mysqli_select_db($conn,"mediawriting"); 
   $arr = array();
   
   $rs = mysqli_query($conn,"SELECT j.jid as JobId,j.jname as Job,j.jtype as Type,j.employer as Employer,j.words as Words,j.namount as Net_Amount,j.bamount as Base_Amount,SUBSTR(j.created,1,10) as Created,concat(jtm.hour,' Hrs ',jtm.minute,' mins') as Deadline,j.employer FROM `jobs_time_map` jtm INNER JOIN jobs j on j.jid=jtm.jid order by j.jid;");

   while($obj = mysqli_fetch_array($rs)) { 
      $rs1 = mysqli_query($conn,"SELECT count(1) as count,jid from job_writer_map where jid='".$obj['JobId']."'");    
      if(mysqli_fetch_array($rs1)['count']>0)
        $obj['status'] = 'Undertaken';
      else
        $obj['status'] = 'Open'; 
      
    	$arr[]=array_map('utf8_encode', $obj);
  }
  header("Content-type: application/json"); 
  echo "{\"data\":" .json_encode($arr). "}";
?> 


