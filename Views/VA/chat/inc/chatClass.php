<?php

  class chatClass
  {
    public static function getRestChatLines($id)
    {
      $arr = array();
      $jsonData = '{"results":[';
      $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
      $db_connection->query( "SET NAMES 'UTF8'" ); 
      $statement = $db_connection->prepare( "SELECT  id,user1,chattext, chattime FROM chat WHERE id > ? and chattime >= DATE_SUB(NOW() , INTERVAL 1 HOUR) and jid=?");
        $statement->bind_param( 'is', $id ,$_SESSION['jid']); 
      $statement->execute();
      $statement->bind_result($id,$user1, $chattext, $chattime);
      $line = new stdClass;
      while ($statement->fetch()) { 
        $line->id = $id;     
        if($user1!=$_SESSION['uname']) 
        {    
          $line->chattext= "<div style='float:left;font-size:12px;padding:7px;font-size:14px;' class='label label-info' >".$chattext."</div>";
          $line->align='left';
        }
      else
      { 
        $line->chattext= "<div style='float:right;font-size:12px;padding:7px;font-size:14px;' class='label label-warning' >".$chattext."</div>"; 
        $line->align='right';
        }
        $line->chattime = date('H:i:s', strtotime($chattime));
        $arr[] = json_encode($line);
      }
      $statement->close(); 
      $jsonData .= implode(",", $arr);
      $jsonData .= ']}';
      return $jsonData;
    }
    
    public static function setChatLines($chattext,$u1,$u2,$jid) { 
      $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
      $db_connection->query( "SET NAMES 'UTF8'" );      
      //notify someone
      if(!isset($_SESSION['notify']))
      { 
        $_SESSION['notify'] = "Done";
        if($_SESSION['userType']=='W'||$_SESSION['userType']=='S')
        { 
         $title = "New message"; 
         $noti = "You have a message from <i>".$u1."</i> for job id:".$jid.".<a href='/members/reviewJob?jid=".$jid."&uname=".$u1."'>Click here</a> to view job details and reply.";
         $statement = $db_connection->prepare( "INSERT INTO `notification` ( `nid`, `title`, `noti`) VALUES ( NULL, ?,?);");  
         $statement->bind_param( 'ss', $title, $noti);
         $statement->execute();     
       }
       
       else if($_SESSION['userType']=='A')
       { 
         $title="New message";
         $noti ="You have a message for job id:".$jid.".<a href='/members/viewJob?jid=".$jid."'>Click here</a> to view message details and reply.";
         $statement = $db_connection->prepare( "INSERT INTO `user_notification` ( `nid`,`uid`, `title`, `noti`) VALUES ( NULL, ?,?,?);");    
         $statement->bind_param( 'iss', $_SESSION['writer'], $title, $noti);
        $statement->execute();   
      }
      } 
      $statement = $db_connection->prepare( "INSERT INTO `chat` (`id`,`jid`, `user1`, `user2`, `chattext`, `chattime`) VALUES (NULL,?,?,?,?, CURRENT_TIMESTAMP);");  
      $statement->bind_param( 'isss', $jid , $u1,$u2,$chattext);
      $statement->execute();   
      $db_connection->close();
    } 
  }
?>