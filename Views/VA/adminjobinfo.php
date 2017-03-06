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
                      echo "<div  style='float:left;'><br>
                      &nbsp;&nbsp;<a href='#' class='btn btn-primary' data-toggle='modal' data-target='#chat' style='font-size:14px;float: right;'>Reply message</a>";
                    if(isset($msg))
                    {
                        echo $Msg;
                        exit();
                    } 
                    echo "<br><br><br><br><br></div>"; 
 			        break;
     }
     echo "<div class='modal fade' id='chat' role='dialog'>
            <div class='modal-dialog'> 
            <div class='modal-content'>
            <div class='modal-header'>
              <button type='button' class='close' data-dismiss='modal'>&times;</button>
              <h4 class='modal-title'>Message </h4>
            </div>
                <div class='modal-body' style='height:300px;overflow:hidden;padding:0;'>  
                    <iframe src='/members/chat' style='height:100%;width:100%;border:1px solid #ccc ;'></iframe>
                    </div> 
                  </form>   
                </div>
             </div>
        </div>";
?> 