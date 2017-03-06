<?php
include($Service->Config()->get_basepath().'/Views/VA/header.html');
	 $c=$Service->Prote()->DBI()->user()->common()->getJobDetails($jid);
   echo "hell".$jid;
	 foreach($c as $data)
	 { 
	  echo "
        <title>Job info</title>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400' rel='stylesheet'>
	  		<div id='wrapper'>  
	        <div id='page-wrapper'> 
            <div class='container-fluid'> 
                <!-- Page Heading -->
                <div class='row'>
                    <div class='col-lg-12'>
                        <h2 class='page-header'>
                             ".$data->jname."
                        </h2> 
                        <ol class='breadcrumb'>
                            <li class='active'>
                                <i class='fa fa-fw fa-edit'></i> Job description (".$data->writer_level.")
                            </li>
                        </ol> 
                    </div> 
                    <div class='col-sm-4'>
                    Job posted on <b>:</b><label style='font-family: \"Open Sans\", sans-serif;'>".$data->created."</label> <br>
                    Word limit <b>:</b><label style='font-family: \"Open Sans\", sans-serif;'> ".$data->words."</label><br>
                    Job Type <b>:</b><label style='font-family: \"Open Sans\", sans-serif;'> ".$data->jtype."</label><br>
                    Employer <b>:</b><label style='font-family: \"Open Sans\", sans-serif;'> ".$data->employer."</label><br>
                    Base rate <b>:</b><label style='font-family: \"Open Sans\", sans-serif;'> ".$data->bamount."</label><br>
                    My rate <b>:</b><label style='font-family: \"Open Sans\", sans-serif;'> ".$data->namount."</label><br>
                    Deadline:<label style='font-family: \"Open Sans\", sans-serif;'> ".$data->hour." Hrs ".$data->minute." Mins (Tries : ".$data->tries.")</label><br>
                    </div>
                    <div class='col-sm-12' style='font-family: \"Open Sans\", sans-serif;'>".$data->description."</div> 
                    <div class='col-sm-12' >";
                     if($data->file)
                        echo "<a href='/members/".$data->file."' class='btn-danger' style='padding:5px;'>Download attachment</a>";
                    echo "</div>";
                    if($_SESSION['userType']=='S'||$_SESSION['userType']=='W')
                      echo "<div class='col-sm-4' style='float:right;'><br><a href='/members/jobs' class='btn btn-default'>Go back</a>&nbsp;&nbsp;  ";
                    else if(isset($backToJobs))
                      echo "<div class='col-sm-4' style='float:right;'><br><a href='/members/submitted-jobs' class='btn btn-default'>Submitted jobs</a>&nbsp;&nbsp;";
                    else
                      echo "<div class='col-sm-4' style='float:right;'><br><a href='/members/ViewJobs' class='btn btn-default'>Go back</a>&nbsp;&nbsp;  ";
                    if(isset($msg))
                    {
                        echo $Msg;
                        exit();
                    }
                    if($_SESSION['userType']=='S'||$_SESSION['userType']=='W')
                    {
                     if($Service->Prote()->DBI()->user()->common()->getCheckOutCount($jid,$_SESSION['userId'])==1)
                      { 
                        if($Service->Prote()->DBI()->user()->common()->alreadyApplied($jid,$_SESSION['userId']))
                        {
                          //check if submitted
                           if($Service->Prote()->DBI()->user()->common()->submitted($jid,$_SESSION['userId']))
                            echo "<label class='btn btn-warning'>Submitted</label>";
                           else 
                            echo "<label class='btn btn-info'>Applied</label>";
                        }
                       else
                        echo "<form method='post' action='/members/apply' style='display:inline;'>
                             <input type='hidden' name='jid' value='".$jid."'>
                             <input type='hidden' name='uid' value='".$_SESSION['userId']."'>
                             <button class='btn btn-success' type='Submit'>Apply for this job</button>";
                      }
                      else
                        echo "<br><br><b>Sorry, you have exhausted the maximum checkout limit."; 
                    }
                    echo "<br><br><br><br><br></div>"; 
 			        break;
     }
?> 