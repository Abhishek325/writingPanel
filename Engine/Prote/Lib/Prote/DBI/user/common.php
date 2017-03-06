<?php
namespace Prote\DBI\user;
use PHPMailer\PHPMailer;
use DIC\Service;

class common {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    } 

    public function addUser($name,$uname,$email,$pwd,$type=null){  
        $name=preg_replace("/ +/", " ", $name);
        $uname=preg_replace("/ +/", " ", $uname);
        $email=preg_replace("/ +/", " ", $email);
        $pwd=preg_replace("/ +/", " ", $pwd);  
        if(empty($type))
         $type='S';
        $this->Db->set_parameters(array($uname,$email));
        $c=$this->Db->find_many("SELECT uname,email from user_details where uname=? or email=?");
        foreach ($c as $data)
        {
            if($data->uname==$name || $data->email==$email)
            { 
              echo "Entered values already exists.<br>Please wait..";
              if($type=="E")
                header("refresh:2;url=/members/dashboard"); 
              else 
              header("refresh:2;url=/members");
              return 0;
            }
        }
        $this->Db->set_parameters(array($name,strtolower($uname),$email,$pwd,$type));
        if($this->Db->query('INSERT INTO `user_details` (`uid`, `name`, `uname`, `email`, `password`, `user_type` ) VALUES (NULL, ?, ?, ?, ?, ?);'))
        { 
          $curUname = $this->getUserUname(strtolower($uname));
          $curUid =  $this->mapUserId(strtolower($curUname));
          $this->Db->set_parameters(array($curUid));
          if($this->Db->query("INSERT INTO `user_status` (`uid`, `status`) VALUES (? , 'U')"))
          {
            //$this->Db->set_parameters(array($curUid));
            //if($this->Db->query("INSERT INTO `userLevelMapevelmap` (`uid`, `lid`) VALUES (?, 1)")) 
              return 1;
          }
        }
        return 0;
    }

    public function addTip($tipTitle,$tipContent,$type){   
        $sym=array("<",">");
        $map=array("&lt;","&gt;");
        $tipTitle=str_replace($sym,$map,$tipTitle);  
        $tipContent=str_replace($sym,$map,$tipContent);  

        $tipTitle=preg_replace("/ +/", " ", $tipTitle);
        $tipContent=preg_replace("/ +/", " ", $tipContent);  

        $this->Db->set_parameters(array($tipTitle));
        $c=$this->Db->find_many("SELECT title from admin_tips where title=?");
        foreach ($c as $data)
        {
            if($data->title==$tipTitle)
            { 
              echo "Entered values already exists.<br>Please wait..";
              header("refresh:3;url=/members/dashboard");
              return 0;
            }
        }
        $this->Db->set_parameters(array($tipTitle,$tipContent,$type));
        if($this->Db->query('INSERT INTO `admin_tips` (`tid`, `title`, `content`,`user_type`) VALUES (NULL, ?, ?,?);'))
            return 1;
        return 0;
    }

    public function addAnnouncement($announcement,$type){   
        $sym=array("<",">");
        $map=array("&lt;","&gt;");
        $announcement=str_replace($sym,$map,$announcement);   

        $announcement=preg_replace("/ +/", " ", $announcement); 

        $this->Db->set_parameters(array($announcement));
        $c=$this->Db->find_many("SELECT announcement from admin_announcement where announcement=?");
        foreach ($c as $data)
        {
            if($data->announcement==$announcement)
            { 
              echo "Entered value already exists.<br>Please wait..";
              header("refresh:3;url=/members/dashboard");
              return 0;
            }
        }
        $this->Db->set_parameters(array($announcement,$type));
        if($this->Db->query('INSERT INTO `admin_announcement` (`aid`, `announcement`,`user_type`) VALUES (NULL, ?,?);'))
            return 1;
        return 0;
    }

    public function addEmployer($employer,$from,$link,$info){   
        $sym=array("<",">");
        $map=array("&lt;","&gt;");
        $employer=str_replace($sym,$map,$employer);   

        $employer=preg_replace("/ +/", " ", $employer); 

        $this->Db->set_parameters(array($employer));
        $c=$this->Db->find_many("SELECT ename from employer where ename=?");
        foreach ($c as $data)
        {
            if($data->ename==$employer)
            { 
              echo "Entered value already exists.<br>Please wait..";
              header("refresh:3;url=/members/dashboard");
              return 0;
            }
        }
        $this->Db->set_parameters(array($employer,$from,$link,$info));
        if($this->Db->query('INSERT INTO `employer` (`eid`, `ename`,`efrom`,`elink`,`otherinfo`) VALUES (NULL, ?,?,?,?);'))
            return 1;
        return 0;
    }

     public function addJobUserMap($jid,$uid){    
        $this->Db->set_parameters(array($jid,$uid));
        $data=$this->Db->find_one("SELECT count(1) as count from job_writer_map where jid=? and uid=?");
        if($data->count>0)
        {
           echo "This mapping already exists";
           header("refresh:3;url=/members/dashboard");
           exit();
        }
        $data=$this->Db->find_one("SELECT count(1) as count from job_checkout_map where jid=? and uid=?");
        if($data->count>0)
        { 
          $this->Db->set_parameters(array($jid,$uid));
           $this->Db->query('UPDATE job_checkout_map SET checkout_count = checkout_count - 1 where jid=? and uid=?');  
        }
        else
        {
          $this->Db->set_parameters(array($uid,$jid,$this->getTries($jid)));
          $this->Db->query('INSERT INTO `job_checkout_map` (`uid`, `jid`, `checkout_count`) VALUES (?, ?, ?);');
        }

        $this->Db->set_parameters(array($uid,$jid));
        if($this->Db->query('INSERT INTO `job_writer_map` (`uid`, `jid`) VALUES (?, ?);'))
        {  
            return 1 ;
        }
        return 0;
    }

    public function assignWriter($uid,$jid)
    {
      $this->Db->set_parameters(array($uid,$jid));
        if($this->Db->query('INSERT INTO `job_writer_map` (`uid`, `jid`) VALUES (?, ?);'))
        {  
            return 1 ;
        }
    }

    public function addJobContentMap($jid,$uid,$content){    
        $this->Db->set_parameters(array($jid,$uid));
        $data=$this->Db->find_one("SELECT count(1) as count from job_content_map where jid=? and uid=?");
        if($data->count>0)
        { 
           $this->Db->set_parameters(array($content,$jid,$uid));
           $this->Db->query('UPDATE job_content_map SET jobContent=?,last_saved=CURRENT_TIMESTAMP where jid=? and uid=?'); 
           return 1;
        }
        $this->Db->set_parameters(array($uid,$jid,$content));
        if($this->Db->query('INSERT INTO `job_content_map` (`uid`, `jid`, `jobContent`, `last_saved`) VALUES (?,?,?, CURRENT_TIMESTAMP);'))
            return 1;
        return 0;
    }

     public function addSubmitJobMap($jid,$uid){    
        $this->Db->set_parameters(array('Y',$jid,$uid));   
        if($this->Db->query('UPDATE `job_writer_map` SET `submit`=?,time=CURRENT_TIMESTAMP where jid=? and uid=?'))
            return 1;
        return 0;
    }

    public function updateSubmitJobMap($stat,$jid,$uid){    
        $this->Db->set_parameters(array($stat,$jid,$uid));   
        if($this->Db->query('UPDATE `job_writer_map` SET `submit`=?,time=CURRENT_TIMESTAMP where jid=? and uid=?'))
            return 1;
        return 0;
    } 

    public function notifyAdmin($title,$notification)
    { 
        $this->Db->set_parameters(array($title,$notification));   
        if($this->Db->query('INSERT INTO `notification` ( `nid`, `title`, `noti`) VALUES ( NULL, ?,?);'))
            return 1;
    }

    public function addUserNotification($uid,$title,$notification)
    { 
        $this->Db->set_parameters(array($uid,$title,$notification));   
        if($this->Db->query('INSERT INTO `user_notification` ( `uid`, `title`, `noti`) VALUES ( ?, ?,?);'))
            return 1;
    }

    public function getMaxNotificationCount()
    {  
       if($data=$this->Db->find_one('SELECT max(nid) as nid from `user_notification`;'))
       return ($data->nid+1); 
      return 0;
    }

    public function addJob($jobname,$jobtype,$employer,$epay,$description,$level,$words,$namnt,$bamnt,$tries,$h,$m,$file)
    {
      $sym=array("<",">");
      $map=array("&lt;","&gt;");
      $jobname=str_replace($sym,$map,$jobname);
      $this->Db->set_parameters(array($jobname,$jobtype));
      $c=$this->Db->find_many("SELECT jname,jtype,employer from jobs where jname=? and jtype=?");
      foreach ($c as $data)
      {
            if($data->jname==$jobname && $data->jtype==$jobtype && $data->employer==$employer)
            {   
              $Msg = "Same job name, job type and employer combination already exits";
              header("refresh:3;url=/members/dashboard"); 
            }
      } 
      //learn new job type
      $flag=0;
      $this->Db->set_parameters(array($jobtype));
        $c=$this->Db->find_many("SELECT jtype from jobType where jtype=?"); 
        foreach ($c as $data)
        {
            if(strtolower($data->jtype)==strtolower($jobtype))
            {   
              $flag=1;
              break;
            }
        } 
        if($flag==0)
        {
          $this->addJobType($jobtype);
        } 
      $this->Db->set_parameters(array($jobname,$jobtype,$employer,$epay,$description,$level,$words,
        $namnt,$bamnt,$tries,$file));
      if($this->Db->query('INSERT INTO `jobs` (`jid`, `jname`, `jtype`, `employer`, `epay`, `description`, `writer_level`, `words`, `namount`, `bamount`, `tries`,`created`,`file`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP,?);'))
        {
         $lastJobId=$this->getLastJobId();
         $this->Db->set_parameters(array($lastJobId,$h,$m));
         if($this->Db->query('INSERT INTO `jobs_time_map` (`jid`,`hour`, `minute`) VALUES (?,?,?);'))
         {  
            return 1;
          }
      }
      return 0;
    }

    public function updateJob($jid,$jobname,$jobtype,$employer,$epay,$description,$level,$words,$namnt,$bamnt,$tries,$h,$m,$file)
    { 
      $sym=array("<",">");
      $map=array("&lt;","&gt;");
      $jobname=str_replace($sym,$map,$jobname);  
      $this->Db->set_parameters(array($jobname,$jobtype,$employer,$epay,$description,$level,$words,
        $namnt,$bamnt,$tries,$jid));
      if($this->Db->query('UPDATE `jobs` SET jname=?,jtype=?,employer=?,epay=?,description=?,writer_level=?,words=?,
        namount=?,bamount=?,tries=? where jid=?'))
        { 
          $this->Db->set_parameters(array($h,$m,$jid));
         if($this->Db->query('UPDATE `jobs_time_map` SET `hour`=?, `minute`=? where jid=?;'))
         {  
            return 1;
          }
      }
      return 0;
    }

    public function addJobType($jtype){   
        $sym=array("<",">");
        $map=array("&lt;","&gt;");
        $jtype=str_replace($sym,$map,$jtype);   

        $jtype=preg_replace("/ +/", " ", $jtype); 

        $this->Db->set_parameters(array($jtype));
        $c=$this->Db->find_many("SELECT jtype from jobType where jtype=?"); 
        foreach ($c as $data)
        {
            if(strtolower($data->jtype)==strtolower($jtype))
            {  
              echo " <h4 class='page-header'>This job type already exists !!! <br>Please wait...";
                        header("refresh:2;url=/members/admin_system_configure");
                        return 0;
            }
        } 
        $this->Db->set_parameters(array($jtype));
        if($this->Db->query('INSERT INTO `jobType` (`jtid`, `jtype`) VALUES (NULL, ?);'))
            return 1;
        return 0;
    }

    public function addLevel($level ,$words,$rank ,$hlimit,$climit ,$btime ,$namount){   
        $sym=array("<",">");
        $map=array("&lt;","&gt;");
        $level=str_replace($sym,$map,$level);   

        $level=preg_replace("/ +/", " ", $level);  
        $this->Db->set_parameters(array($level));
        $c=$this->Db->find_many("SELECT level from writerlevel where level=?"); 
        foreach ($c as $data)
        {
            if($data->level==$level)
            {  
              echo " <h4 class='page-header'>This level already exists !!! <br>Please wait...";
                        header("refresh:2;url=/members/admin_system_configure");
                        return 0;
            }
        } 
        $this->Db->set_parameters(array($level,$words,$rank,$hlimit,$climit,$btime,$namount)); 
        if($this->Db->query(' INSERT INTO `writerlevel` (`lid`, `level`, `words`, `rank`, `hlimit`, `climit`, `btime`, `namount`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?);'))
            return 1;
        return 0;
    } 

    public function createUpdateAttachmentMap($uid,$jid,$attachment)
    {
      $this->Db->set_parameters(array($uid,$jid));
      $c=$this->Db->find_many("SELECT attachment from writer_job_attachment_map where uid=? and jid=?"); 
        foreach ($c as $data)
        {
            if($data->attachment==$attachment)
            {   
              return;
            }
            else
            {
              $this->Db->set_parameters(array($attachment,$uid,$jid));
              $this->Db->query('UPDATE writer_job_attachment_map set attachment=? where uid=? and jid=?;');   
              return 1;
            }
        } 
        $this->Db->set_parameters(array($uid,$jid,$attachment)); 
        if($this->Db->query('INSERT INTO `writer_job_attachment_map` (`uid`, `jid`, `attachment`) VALUES (?,?,?);'))
            return 1;
    }

    public function postReview($uid,$jid,$rating,$comment)
    {
      $this->Db->set_parameters(array($uid,$jid,$rating,$comment)); 
        if($this->Db->query('INSERT INTO `feedback` (`uid`, `jid`, `rating`, `comments`) VALUES (?,?,?,?);'))
            return 1;
    }

    public function getAttachmentMap($uid,$jid)
    { 
      $this->Db->set_parameters(array($jid,$uid));
      if($data=$this->Db->find_one('SELECT attachment from writer_job_attachment_map where jid=? and uid=?;'))
       return $data->attachment; 
      return 0;
    }    

    public function getLastJobId()
    { 
      if($data=$this->Db->find_one('SELECT max(jid) as jid from `jobs`;'))
       return $data->jid; 
      return 0;
    }

    public function mapUser($uname)
    { 
      $this->Db->set_parameters(array($uname));
      if($data=$this->Db->find_one('SELECT name from `user_details` where uname = ?;'))
       return $data->name;
      else 
        return "Anonymous"; 
    }

    public function mapUname($uid)
    { 
      $this->Db->set_parameters(array($uid));
      if($data=$this->Db->find_one('SELECT uname from `user_details` where uid = ?;'))
       return $data->uname;
      else 
        return "Anonymous"; 
    }

    public function mapUserId($uname)
    { 
      $this->Db->set_parameters(array($uname));
      if($data=$this->Db->find_one('SELECT uid from `user_details` where uname =?;'))
       return $data->uid;
      else 
        return "Anonymous"; 
    }

    public function getUname($name)
    { 
      $this->Db->set_parameters(array($name));
      if($data=$this->Db->find_one('SELECT uname from `user_details` where name =?;'))
       return $data->uname;
      else 
        return "Anonymous"; 
    }


    public function getUserType($id)
    { 
      $this->Db->set_parameters(array($id));
      if($data=$this->Db->find_one('SELECT user_type from `user_details` where uid =?;'))
       return $data->user_type;
      else 
        return "Anonymous"; 
    }

    public function getJobAmount($jid)
    { 
      $this->Db->set_parameters(array($jid));
      if($data=$this->Db->find_one('SELECT namount from `jobs` where jid =?;'))
       return $data->bamount;
      else 
        return 0; 
    }

    public function getUserUname($uname)
    { 
      $this->Db->set_parameters(array($uname));
      if($data=$this->Db->find_one('SELECT uname from `user_details` where uname =?;'))
       return $data->uname;
      else 
        return "Anonymous"; 
    }

    public function getUserLevel($uid)
    { 
      $this->Db->set_parameters(array($uid));
      if($data=$this->Db->find_one('SELECT level from `userLevelMap` where uid =?;'))
       switch($data->level)
       {
        case 1: return "Beginner";
        case 2: return "Intermediate";
        case 3: return "Expert"; 
       }
       
      else 
        return "Anonymous"; 
    }

    public function getUserList($id)
    { 
      $this->Db->set_parameters(array($id));
      if($data=$this->Db->find_many('SELECT uname from `user_details` where uid<>?;'))
       return $data;
      else 
        return "Anonymous"; 
    }

    public function getUserNames()
    {  
      $this->Db->set_parameters(array($_SESSION['userId']));
      if($data=$this->Db->find_many('SELECT name from `user_details` where uid<>? order by name LIMIT 3'))
       return $data;
      else 
        return "Anonymous"; 
    }

    public function getTips()
    {  
      if($data=$this->Db->find_many('SELECT tid,title,content from admin_tips order by tid desc'))
       return $data; 
    }

    public function getAnnouncements()
    {  
      if($data=$this->Db->find_many('SELECT aid,announcement from admin_announcement'))
       return $data; 
    }

    public function getUserCount()
    {  
      if($data=$this->Db->find_one('SELECT count(1) as count from `user_details`'))
       return $data->count;
      else 
        return "0"; 
    }

    public function getSpecUser($type)
    { 
      $this->Db->set_parameters(array($type)); 
      if($data=$this->Db->find_many('SELECT uname, name from `user_details` where user_type=?'))
       return $data;
      else 
        return "0"; 
    }

    public function getUserSpecDetails($uname)
    { 
      $this->Db->set_parameters(array($uname)); 
      if($data=$this->Db->find_many('SELECT uid,email,uname,name,user_type from `user_details` where uname=?'))
       return $data;
      else 
        return "0"; 
    }

    public function getEmployerCount()
    {  
     if($data=$this->Db->find_one('SELECT count(1) as count from `employer`'))
       return $data->count;
      else 
        return 0;
    }

    public function getEmployerList()  
    {  
      if($data=$this->Db->find_many('SELECT eid,ename,efrom,elink,otherinfo from `employer` order by eid desc;'))
       return $data;
      else 
        return "Anonymous"; 
    }

    public function getUserStat($uid)
    { 
      $this->Db->set_parameters(array($uid));
      if($data=$this->Db->find_one('SELECT status from `user_status` where uid=?'))
      {
        switch($data->status)
        {
          case 'B': return "Blocked";  
          case 'U': return "Unblocked"; 
          default : return "NA";
        }
      }
    }

    public function getJobTypeCount()
    {
      if($data=$this->Db->find_one('SELECT count(1) as count from `jobType`'))
       return $data->count;
      else 
        return "0";
    }

    public function getJobType()
    {
      if($data=$this->Db->find_many('SELECT jtid,jtype from `jobType` order by jtype;'))
       return $data;
      else 
        return "None"; 
    }

    public function getJobDuration($jid)
    {
      $this->Db->set_parameters(array($jid));
      if($data=$this->Db->find_one('SELECT `hour`, `minute` from  `jobs_time_map` where jid=?'))
       return $data->hour."<small> Hrs</small> ".$data->minute."<small> mins</small>";
      else 
        return "None"; 
    }

    public function getJobName($jid)
    {
        $this->Db->set_parameters(array($jid));
      if($data=$this->Db->find_one('SELECT jname from `jobs` where jid=?'))
        return $data->jname;
      else
        return "";
    }

    public function getPreviousData($jid,$uid)
    {
        $this->Db->set_parameters(array($jid,$uid));
      if($data=$this->Db->find_one('SELECT count(1) as count from `job_content_map` where jid=? and uid=?;'))
       $count=$data->count;
      if($count>0) 
      { 
       $this->Db->set_parameters(array($jid,$uid)); 
       $data=$this->Db->find_one('SELECT jobContent,last_saved from `job_content_map` where jid=? and uid=?;');
       return $data;   
      }
      else
        return "No data saved";
    } 

    public function getWordCount($jid)
    {
        $this->Db->set_parameters(array($jid)); 
       if($data=$this->Db->find_one('SELECT words from `jobs` where jid=?;')) 
        return $data->words;    
        return 0;
    }

    public function getLevelCount()
    {
      if($data=$this->Db->find_one('SELECT count(1) as count from `writerlevel`'))
       return $data->count;
      else 
        return "0";
    }

    public function getLevel()
    {
      if($data=$this->Db->find_many('SELECT lid,level from `writerlevel` order by level;'))
       return $data;
      else 
        return "Anonymous"; 
    }

    public function getpwd($id)
    { 
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT `password` FROM `user_details` where uid=?')){
            return $data->password;
        }
        else 
            return 0; 
    } 

    public function getJobList($level)
    {
        $this->Db->set_parameters(array($level)); 
        if($data=$this->Db->find_many('SELECT j.jid,j.jname,j.jtype,j.employer,j.words,j.namount,j.bamount,
          SUBSTR(j.created,1,10) as created,jtm.hour,jtm.minute FROM `jobs_time_map` jtm INNER JOIN jobs j on j.jid=jtm.jid where writer_level=? and (SELECT count(jid) as count from job_writer_map where jid=j.jid)=0 and j.jid not in (select jid from user_transaction);')){ 
            return $data;
        }
        else 
            return 0; 
    }

    public function getAlljobs($level)
    {
        $this->Db->set_parameters(array($level)); 
        if($data=$this->Db->find_many('SELECT j.jid,j.jname,j.jtype,j.employer,j.words,j.namount,j.bamount,
          SUBSTR(j.created,1,10) as created,jtm.hour,jtm.minute,j.employer FROM `jobs_time_map` jtm INNER JOIN jobs j on j.jid=jtm.jid where writer_level=? order by j.jid;')){ 
            return $data;
        }
        else 
            return 0; 
    } 

    public function getMyJobs($uid)
    {
        $this->Db->set_parameters(array($uid,'NA','N')); 
        if($data=$this->Db->find_many('SELECT j.jid,j.jname,j.jtype,j.employer,j.words,j.namount,j.bamount,
          SUBSTR(j.created,1,10) as created,jwm.submit FROM `jobs` j INNER JOIN job_writer_map jwm on j.jid=jwm.jid where uid=? and approved=? and submit=?;')){
            return $data;
        }
        else 
            return 0; 
    }

    public function getMySubmittedJobs($uid,$approved)
    {
        $this->Db->set_parameters(array($uid,'Y',$approved)); 
        if($data=$this->Db->find_many('SELECT j.jid,j.jname,j.jtype,j.employer,j.words,j.namount,j.bamount,
          SUBSTR(j.created,1,10) as created,jwm.submit FROM `jobs` j INNER JOIN job_writer_map jwm on j.jid=jwm.jid where uid=? and submit=? and approved=?;')){
            return $data;
        }
        else 
            return 0; 
    }


    public function getSubmitStatus($jid)
    {
        $this->Db->set_parameters(array($jid)); 
        if($data=$this->Db->find_one('SELECT submit from job_writer_map where jid=?;')){
            return $data->submit;
        }
        else 
            return 0; 
    }

    public function getRating($jid)
    {
        $this->Db->set_parameters(array($jid)); 
        if($data=$this->Db->find_one('SELECT rating from feedback where jid=?;')){
            return $data->rating;
        }
        else 
            return 0; 
    }

    public function getComment($jid)
    {
        $this->Db->set_parameters(array($jid)); 
        if($data=$this->Db->find_one('SELECT comments from feedback where jid=?;')){
            return $data->comments;
        }
        else 
            return 0; 
    }

    public function getWriterList()
    {
        $this->Db->set_parameters(array('W')); 
        if($data=$this->Db->find_many('SELECT uid,name from user_details where user_type=? order by name;')){
            return $data;
        }
        else 
            return 0; 
    }

    public function getWriterName($jid)
    {
        $this->Db->set_parameters(array($jid)); 
        if($data=$this->Db->find_one('SELECT distinct ud.name from user_details, job_writer_map jwm,user_details ud where jwm.uid=ud.uid and jwm.jid=?;')){
            return $data->name;
        }
        else 
            return 0; 
    }

    public function checkApproved($jid)
    {
        $this->Db->set_parameters(array($jid)); 
        if($data=$this->Db->find_one('SELECT approved from job_writer_map where jid=?;')){
            return $data->approved;
        }
        else 
            return 0; 
    }

    public function getPaymentHistory ($uid)
    {
        $this->Db->set_parameters(array($uid)); 
        if($data=$this->Db->find_many('SELECT * from user_transaction where uid=? order by tnId;')){
            return $data;
        }
        else 
            return 0; 
    }

    public function getJobDetails($id)
    {
        $this->Db->set_parameters(array($id)); 
        if($data=$this->Db->find_many('SELECT j.jid,j.jname,j.jtype,j.employer,j.description,j.words,j.namount,j.bamount,j.tries,j.writer_level,j.file,j.epay,
          SUBSTR(j.created,1,10) as created,jtm.hour,jtm.minute FROM `jobs_time_map` jtm INNER JOIN jobs j on j.jid=jtm.jid where j.jid=?;')){
            return $data;
        }
        else 
            return 0; 
    }

    public function getJobDet($id)
    {
        $this->Db->set_parameters(array($id)); 
        if($data=$this->Db->find_one('SELECT j.jid,j.jname,j.jtype,j.employer,j.description,j.words,j.namount,j.bamount,j.tries,j.writer_level,j.file,
          SUBSTR(j.created,1,10) as created,jtm.hour,jtm.minute FROM `jobs_time_map` jtm INNER JOIN jobs j on j.jid=jtm.jid where j.jid=?;')){
            return $data;
        }
        else 
            return 0; 
    }

    public function getSubmittedJobs($level)
    {
        $this->Db->set_parameters(array($level,'Y')); 
        if($data=$this->Db->find_many('SELECT j.jname,j.jid,u.uid,u.uname,u.user_type,w.level,jcm.jobContent,jwm.time as submitted_on,jwm.approved,j.employer,j.namount,(j.tries-jchm.checkout_count) as retries FROM `job_content_map` jcm,`job_checkout_map` jchm,job_writer_map jwm,user_details u, jobs j,writerlevel w where j.jid=jcm.jid and jcm.uid=u.uid and jwm.jid=j.jid and jchm.jid=j.jid and  j.writer_level=w.level and w.level=? and jwm.uid=u.uid and jwm.submit=?')){
            return $data;
        }
        else 
            return 0; 
    }

    public function getTobePaidJobs()
    {
        $this->Db->set_parameters(array('Y'));  
        if($data=$this->Db->find_many('SELECT j.jid,u.name as Name,u.uname as Username,j.namount as Amount FROM job_writer_map jwm,user_details u, jobs j where jwm.jid=j.jid and jwm.uid=u.uid and jwm.approved=? and j.jid not in (SELECT jid from job_payment_map);')){
            return $data;
        }
        else 
            return 0; 
    }

    public function updateApproveStatus($status,$jid,$uid)
    {
        $this->Db->set_parameters(array($status,$jid,$uid)); 
        if($data=$this->Db->query('UPDATE job_writer_map SET approved = ? where jid=? and uid=?')){
            return 1;
        }
        else 
            return 0; 
    }

    public function addPayment($uid,$jid,$date,$desc,$type,$amount)
    { 
        //Check if payment has been made for this job to this user.
        $this->Db->set_parameters(array($uid,$jid)); 
        $data = $this->Db->find_one('SELECT *,count(1) as count from  user_transaction where uid=? and jid=?'); 
        if($data->count==0&&$amount<0)
        {  
          return -1;
        }   
        if($data->count>0&&$data->amount==$amount)//already exists
        {   
          $this->Db->set_parameters(array($uid,$jid,$date,$desc,$type,$amount));  
          if($data=$this->Db->query('INSERT INTO `user_transaction` (`tnId`, `uid`, `jid`, `tdate`, `particulars`, `type`, `amount`) VALUES (NULL, ?, ?, ?, ?, ?, ?);'))
            return 1;
        } 
        $this->Db->set_parameters(array($uid,$jid,$date,$desc,$type,$amount));  
        if($data=$this->Db->query('INSERT INTO `user_transaction` (`tnId`, `uid`, `jid`, `tdate`, `particulars`, `type`, `amount`) VALUES (NULL, ?, ?, ?, ?, ?, ?);')){ 
            return 1;
        }
        else 
        { 
            return 0; 
        }
    }

    public function updateSubmitstatus($status,$jid,$uid)
    {
        $this->Db->set_parameters(array($status,$jid,$uid)); 
        if($data=$this->Db->query('UPDATE job_writer_map SET submit = ?, time=CURRENT_TIMESTAMP  where jid=? and uid=?')){
            return 1;
        }
        else 
            return 0; 
    }

    public function makePayment($jid,$uid,$amt,$mode)
    {
        $this->Db->set_parameters(array($uid,$jid,$mode,$amt)); 
        if($data=$this->Db->query('INSERT INTO `job_payment_map` (`uid`, `jid`, `mode`, `amount`, `payDate`) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP);')){
            return 1;
        }
        else 
            return 0; 
    }

    public function paymentDone($jid,$uid)
    {
        $this->Db->set_parameters(array($jid,$uid)); 
        if($data=$this->Db->find_one('SELECT count(1) as count from  job_payment_map where jid=? and uid=?')){
            if($data->count>0)
              return 1;
        }
        else 
            return 0; 
    }


    public function getJobDes($id)
    {
        $this->Db->set_parameters(array($id)); 
        if($data=$this->Db->find_one('SELECT description,file from jobs where jid=?;')){
            return $data;
        }
        else 
            return 0; 
    }

     public function getJobContent($id)
    {
        $this->Db->set_parameters(array($id)); 
        if($data=$this->Db->find_one('SELECT jobContent from job_content_map where jid=?;')){
            return $data->jobContent;
        }
        else 
            return 0; 
    }

    public function relistjob($jid)
    {
        $this->Db->set_parameters(array($jid)); 
        if($this->Db->query('DELETE from `job_writer_map` where jid=?'))
        {     
           $this->Db->set_parameters(array($jid)); 
           $this->Db->query('DELETE from `job_content_map` where jid=?'); 

           $this->Db->set_parameters(array('R','Y',$jid)); 
           $this->Db->query('UPDATE `job_writer_map` SET approved=?,submit=?  where jid=?'); 
            return 1;
        }
        return 0;
    }

    public function getApplyHours($jid)
    {
      $this->Db->set_parameters(array($jid)); 
        if($data=$this->Db->find_one( "SELECT substr(time,12,2) as hour from job_writer_map where jid=?;")){
            return $data->hour;
        }
        else 
            return 0; 
    }

    public function getApplyMinutes($jid)
    {
      $this->Db->set_parameters(array($jid)); 
        if($data=$this->Db->find_one( "SELECT substr(time,15,2) as minute from job_writer_map where jid=?;")){
            return $data->minute;
        }
        else 
            return 0; 
    }  

    public function getApplySeconds($jid)
    {
      $this->Db->set_parameters(array($jid)); 
        if($data=$this->Db->find_one( "SELECT substr(time,18,2) as minute from job_writer_map where jid=?;")){
            return $data->minute;
        }
        else 
            return 0; 
    } 

    public function getWJobTime($jid,$p)
    {
      $this->Db->set_parameters(array($jid)); 
        if($data=$this->Db->find_one('SELECT * FROM `jobs_time_map` WHERE `jid` = ?;')){
          switch ($p) {
            case 'h':
              return $data->hour;
              break;
            case 'm':
              return $data->minute;
              break; 
            default: return 0;
              break;
          } 
        } 
    } 

    public function getJobTypeDetails($job)
    {
      $this->Db->set_parameters(array(strtolower($job),strtolower($job)));
        if($data=$this->Db->find_many('SELECT jid,jname,epay,description,words,namount, bamount, tries, file FROM `jobs` where jtype=? and jid=(select max(jid) from jobs where jtype=?) LIMIT 1;')){
            return $data;
        }
        else 
            return 0; 
    }

     public function getWriterFields($l)
    { 
      $this->Db->set_parameters(array($l));
      if($data=$this->Db->find_many('SELECT tries,words,namount,bamount from jobs where writer_level=?;')){
            return $data;
        }
        else 
            return 0; 
    }

    public function getWriterLevels()
    {  
        if($data=$this->Db->find_many('SELECT lid,level from writerlevel ;')){
            return $data;
        }
        else 
            return 0; 
    }

    public function getTries($jid)
    {
      $this->Db->set_parameters(array($jid));
        if($data=$this->Db->find_one('SELECT tries from jobs where jid=?;')){
            return $data->tries;
        }
        else 
            return 0; 
    }

    public function getAdminNotis()
    {    
        if($data=$this->Db->find_many("SELECT *,count(1) as count from notification where title not like '%message%';")){ 
          return $data; 
        }
        else 
            return 0; 
    }

    public function getAdminMsg()
    {    
        if($data=$this->Db->find_many("SELECT * from notification where title like '%message%';")){ 
          return $data; 
        }
        else 
            return 0; 
    }

    public function getAdminMsgCount()
    {    
        if($data=$this->Db->find_one("SELECT count(1) as count from notification where title like '%message%';")){ 
          return $data->count; 
        }
        else 
            return 0; 
    }

    public function getUserMsg($uid)
    {    
      $this->Db->set_parameters(array($uid));
        if($data=$this->Db->find_many("SELECT * from user_notification where uid in (select uid from job_writer_map where uid=?)")){ 
          return $data; 
        }
        else 
            return 0; 
    }

    public function getUserMsgCount($uid)
    {    
      $this->Db->set_parameters(array($uid));
        if($data=$this->Db->find_one("SELECT count(1) as count from user_notification where uid in (select uid from job_writer_map where uid=?)")){ 
          return $data->count; 
        }
        else 
            return 0; 
    } 

     public function getUserNotis($uid)
    {     
      $this->Db->set_parameters(array($uid));
        if($data=$this->Db->find_many("SELECT *,count(1) as count from user_notification where uid=? and title not like '%message%';")){ 
          return $data; 
        }
        else 
            return 0; 
    }

      public function getAdminEmail()
    {    
        if($data=$this->Db->find_one("SELECT email from user_details where user_type='A' LIMIT 1;")){ 
          return $data->email; 
        }
        else 
            return 0; 
    }

      public function getEmail($uid)
    {    
      $this->Db->set_parameters(array($uid));
        if($data=$this->Db->find_one("SELECT email from user_details where uid=?;")){ 
          return $data->email; 
        }
        else 
            return 0; 
    }

    public function sendEmail($notification)
    {
      $mail = new PHPMailer();
      $mail->IsSMTP();                                      // set mailer to use SMTP
      $mail->Host = "103.212.120.11";  // specify main and backup server
      $mail->SMTPAuth = true;     // turn on SMTP authentication
      $mail->Username = "mediawriting";  // SMTP username
      $mail->Password = "k?.N-2GxFUhv"; // SMTP password

      $mail->From = "jobs@mediawriting.com";
      $mail->FromName = "MediaWriting";
      $mail->AddAddress($this->getAdminEmail()); 
      $mail->IsHTML(true);                                  // set email format to HTML

      $mail->Subject = "A job appoval has been requested";
      $mail->Body    = "Hi Admin,<br> ".$notification."<br>Please login and do the needful.<br><br>Regards,<br>MediaWriting Team"; 

      if(!$mail->Send())
      {
         echo "Message could not be sent. <p>";
         echo "Mailer Error: " . $mail->ErrorInfo;
         exit;
      } 
      echo "Message has been sent"; 
    }

    public function alreadyApplied($jid,$uid)
    {
      $this->Db->set_parameters(array($jid,$uid));
        if($data=$this->Db->find_one('SELECT count(1) as count from job_writer_map where jid=? and uid=?;')){
            return $data->count;
        }
        else 
            return 0; 
    }

    public function submitted($jid,$uid)
    {
      $this->Db->set_parameters(array($jid,$uid,'Y'));
        if($data=$this->Db->find_one('SELECT count(1) as count from job_writer_map where jid=? and uid=? and submit=?;')){
            if($data->count>0)
              return 1;
        }
        else 
            return 0; 
    }

    public function getCheckOutCount($jid,$uid)
    {    
      $this->Db->set_parameters(array($jid,$uid));
        if($data=$this->Db->find_one ('SELECT checkout_count,count(1) as count from job_checkout_map where jid=? and uid=?;')){ 
          if(($data->checkout_count!=NULL && $data->checkout_count>0))
          {     
           return 1;
          } 
          if($data->count==0)
            return 1; 
        }
        else 
            return 0; 
    }

     public function getUsercheckOutLeft($jid,$uid)
    {    
      $this->Db->set_parameters(array($jid,$uid));
        if($data=$this->Db->find_one ('SELECT checkout_count from job_checkout_map where jid=? and uid=?;')){  
          return $data->checkout_count;
        }
        else 
            return 0; 
    }

    public function reduceCheckoutCount($jid,$uid)
    {   
      $this->Db->set_parameters(array($jid,$uid));
        if($this->Db->query('UPDATE `job_checkout_map` SET `checkout_count`=`checkout_count`-1 WHERE `jid`=? and `uid` = ?')){ 
            return 1; 
        }
        else 
            return 0; 
    }

    public function incCheckout($jid,$uid,$num)
    {    
      $this->Db->set_parameters(array($num,$jid,$uid));
        if($this->Db->query('UPDATE `job_checkout_map` SET `checkout_count`=`checkout_count`+ ? WHERE `jid`=? and `uid` = ?')){ 
            return 1; 
        }
        else 
            return 0; 
    }

     public function change_pwd($newpwd,$id){
        $this->Service->Prote()->DBI()->user()->func()->make_salt($_SESSION['userName'],$newpwd);
        $new=$this->Service->Prote()->DBI()->user()->func()->generate_hash($newpwd);   
        $this->Db->set_parameters(array($new,$id));
        if($this->Db->query('UPDATE `user_details` SET `password`=? WHERE `uid` = ?')){
            return 1;
        }else{
            return 0;
        }
    } 

    public function removeTip($tid)
    { 
        $this->Db->set_parameters(array($tid));
        if($this->Db->query('DELETE from `admin_tips` where tid=?'))
            return 1;
        return 0;
    } 

    public function removeNoti($id)
    { 
        $this->Db->set_parameters(array($id));
        if($this->Db->query('DELETE from `notification` where nid=?'))
            return 1;
        return 0;
    } 

    public function removeUserNoti($nid)
    { 
        $this->Db->set_parameters(array($nid));
        if($this->Db->query('DELETE from `user_notification` where nid=?'))
            return 1;
        return 0;
    } 

    public function removeEmployer($eid)
    { 
        $this->Db->set_parameters(array($eid));
        if($this->Db->query('DELETE from `employer` where eid=?'))
            return 1;
        return 0;
    }

    public function removeUser($uid)
    {  
          $this->Db->set_parameters(array($uid));
          $this->Db->query('DELETE from `user_status` where uid=?'); 
          $this->Db->set_parameters(array($uid));
          $this->Db->query('DELETE from `user_details` where uid=?');
          return 1;  
    }

    public function removeAnnouncement($aid)
    { 
        $this->Db->set_parameters(array($aid));
        if($this->Db->query('DELETE from `admin_announcement` where aid=?'))
            return 1;
        return 0;
    }

    public function deleteJob($jid)
    { 
        $this->Db->set_parameters(array($jid));
        if($this->Db->query('DELETE from `job_writer_map` where jid=?'))
        { 
          $this->Db->set_parameters(array($jid));
           $this->Db->query('DELETE from `job_checkout_map` where jid=?');

           $this->Db->set_parameters(array($jid));
           $this->Db->query('DELETE from `job_content_map` where jid=?');

           $this->Db->set_parameters(array($jid));
           $this->Db->query('DELETE from `jobs_time_map` where jid=?'); 

           $this->Db->set_parameters(array($jid));
           $this->Db->query('DELETE from `jobs` where jid=?');

           $this->Db->set_parameters(array($jid));
           $this->Db->query('DELETE from `chat` where jid=?');
           return 1;
        }
        return 0;
    }

    public function updateStatus($flag,$uid)
    { 
        $this->Db->set_parameters(array($flag,$uid));
        if($this->Db->query('UPDATE `user_status` SET status=? where uid=?'))
            return 1;
        return 0;
    }

     public function changeEmail($uid,$email)
    { 
        $this->Db->set_parameters(array($email,$uid));
        if($this->Db->query('UPDATE `user_details` SET email=? where uid=?'))
            return 1;
        return 0;
    }

    public function updateType($uid,$type)
    { 
        $this->Db->set_parameters(array($type,$uid));
        if($this->Db->query('UPDATE `user_details` SET user_type=? where uid=?'))
            return 1;
        return 0;
    }

    public function updateLevel($lid,$level)
    { 
        $this->Db->set_parameters(array($level,$lid));
        if($this->Db->query('UPDATE `writerlevel` SET level=? where lid=?'))
            return 1;
        return 0;
    }

    public function updateJobType($jtid,$jtype)
    { 
        $this->Db->set_parameters(array($jtype,$jtid));
        if($this->Db->query('UPDATE `jobType` SET jtype=? where jtid=?'))
            return 1;
        return 0;
    }

    public function  updateTip($tid,$title,$content)
    { 
        $this->Db->set_parameters(array($title,$content,$tid));
        if($this->Db->query('UPDATE `admin_tips` SET title=?, content=? where tid=?'))
            return 1;
        return 0;
    }

    public function  updateEmployer($eid,$ename)
    { 
        $this->Db->set_parameters(array($ename,$eid));
        if($this->Db->query('UPDATE `employer` SET ename=? where eid=?'))
            return 1;
        return 0;
    }

    public function  updateAnnouncement($aid,$announcement)
    { 
        $this->Db->set_parameters(array($announcement,$aid));
        if($this->Db->query('UPDATE `admin_announcement` SET announcement=? where aid=?'))
            return 1;
        return 0;
    }

    public function install(){
        $payload1="CREATE TABLE  IF NOT EXISTS `user_details` (
                  uid int primary key auto_increment,
                  name varchar(255) not null,
                  uname varchar(255) not null,
                  email varchar(255) not null,
                  password varchar(255) not null,
                  user_type CHAR(1) NOT NULL
                  )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;"; 

        $payload2="CREATE TABLE IF NOT EXISTS `protesession` (
                  `session_id` varchar(255) NOT NULL DEFAULT '',
                  `session_data` text NOT NULL,
                  `session_lastaccesstime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  PRIMARY KEY (`session_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"; 
        
        $payload3="CREATE TABLE  IF NOT EXISTS `admin_tips` (
                  tid int primary key auto_increment,
                  title varchar(255) not null,
                  content varchar(255) not null,
                  )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;"; 

        $payload4="CREATE TABLE  IF NOT EXISTS `admin_announcement` (
                  aid int primary key auto_increment,
                  announcement varchar(500) not null 
                  )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;"; 

        $payload5="CREATE TABLE  IF NOT EXISTS `user_status` (
                  uid int,
                  status char(1) DEFAULT 'U',
                  foreign key(uid) references user_details(uid)
                  )ENGINE=InnoDB DEFAULT CHARSET=latin1"; 

        $payload6="CREATE TABLE IF NOT EXISTS `jobs`( 
                  jid int primary key auto_increment, 
                  jname varchar(255),
                  jtype varchar(255),
                  employer varchar(255),
                  epay int, 
                  description text, 
                  writer_level varchar(255), 
                  words int, 
                  namount int, 
                  bamount int, 
                  tries int )ENGINE=InnoDB DEFAULT CHARSET=latin1"; 

        $payload7="CREATE TABLE `jobs_time_map`(
                   jid int,  
                   hour int,
                   minute int,
                   foreign key(jid) references jobs(jid)
                   )ENGINE=InnoDB DEFAULT CHARSET=latin1";

        $payload8="CREATE TABLE IF NOT EXISTS `employer` (
                  `eid` int(11) NOT NULL AUTO_INCREMENT,
                  `ename` varchar(255) DEFAULT NULL,
                  PRIMARY KEY (`eid`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1";

        $payload9="CREATE TABLE IF NOT EXISTS `writerlevel` (
                  `lid` int primary key AUTO_INCREMENT,
                  `level` varchar(255)  
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1";   

        $payload10="CREATE TABLE IF NOT EXISTS `jobType` (
                  `jtid` int primary key AUTO_INCREMENT,
                  `jtype` varchar(255)  
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1";

        $payload11="CREATE TABLE IF NOT EXISTS `userLevelMap` (
                  `uid` int ,
                  `lid` int , 
                   foreign key(uid) references user_details(uid),
                   foreign key(lid) references writerlevel(lid)
                 ) ENGINE=InnoDB  DEFAULT CHARSET=latin1";                
        
        $payload12="ALTER TABLE `admin_announcement` ADD `user_type` CHAR(1) NOT NULL DEFAULT 'S' ";

        $payload13="CREATE TABLE IF NOT EXISTS `job_checkout_map` (
                  `uid` int ,
                  `jid` int , 
                  `checkout_count` int(2),
                   foreign key(uid) references user_details(uid),
                   foreign key(jid) references jobs(jid)
                   ) ENGINE=InnoDB  DEFAULT CHARSET=latin1";

        $payload14="CREATE TABLE IF NOT EXISTS `job_writer_map` (
                  `uid` int ,
                  `jid` int ,  
                  `time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP, 
                  `submit` CHAR(1) NOT NULL DEFAULT 'N',
                   foreign key(uid) references user_details(uid),
                   foreign key(jid) references jobs(jid)
                   ) ENGINE=InnoDB  DEFAULT CHARSET=latin1";     

        $payload15="create table job_content_map (
                    uid int ,
                    jid int , 
                    jobContent text,
                    last_saved TIMESTAMP NULL default CURRENT_TIMESTAMP,
                    foreign key(uid) references user_details(uid),
                    foreign key(jid) references jobs(jid)
                     ) ENGINE=InnoDB  DEFAULT CHARSET=latin1";

        $payload16="CREATE TABLE IF NOT EXISTS `notification` ( 
                    `nid` int(255) NOT NULL AUTO_INCREMENT,
                     `title` VARCHAR(255) NOT NULL ,
                    `noti` varchar(255) NOT NULL,
                     PRIMARY KEY (`nid`)
                   ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";

        $payload17="ALTER TABLE `job_writer_map` ADD `approved` VARCHAR(10) NOT NULL DEFAULT 'NA' ;";                    
        $payload18="create table `user_transaction`
                    (
                        tnId int primary key,
                        tdate date,
                        particulars varchar(255),
                        type varchar(255),
                        amount INT NOT NULL
                    );";

        $payload19 = "CREATE TABLE IF NOT EXISTS `user_notification` ( 
                     uid int,
                     `title` VARCHAR(255) NOT NULL ,
                    `noti` varchar(255) NOT NULL 
                   ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";

        $payload20 = "ALTER TABLE `user_notification` ADD `nid` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`nid`) ;";

        $payload21 = "ALTER TABLE `user_transaction` ADD `uid` INT NOT NULL AFTER `tnId`;";
        $payload22 = "ALTER TABLE `user_transaction` ADD  `jid` INT NOT NULL AFTER `uid`;";

        $payload23="create table writer_job_attachment_map 
                    (   uid int,
                        jid int,
                        attachment varchar(255),
                        foreign key(uid) references user_details(uid),
                        foreign key(jid) references jobs(jid))";

        $payload24="CREATE TABLE IF NOT EXISTS `chat` (
                    `id` int(9) NOT NULL AUTO_INCREMENT,
                    `jid` int(11) NOT NULL,
                    `user1` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
                    `user2` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
                    `chattext` text COLLATE utf8_unicode_ci NOT NULL,
                    `chattime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0;";  

        $payload25="CREATE TABLE IF NOT EXISTS `feedback` (
                        uid int,
                        jid int,
                        rating int,
                        comments text,
                        foreign key(uid) references user_details(uid),
                        foreign key(jid) references jobs(jid))";  

        $payloads = (array($payload25));
        $this->Db->drop_payload($payloads,$this);
    }

}