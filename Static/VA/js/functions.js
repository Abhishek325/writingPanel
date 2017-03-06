
function setVal(jobtype)
{  
  $.ajax({
    type:"GET",
    url:"/members/getJobTypeDetails?jobType="+jobtype,
    success:function(data){   
        var json = JSON.parse(data);
        if(json=="Error")
        {
          //alert("There are no pre set value(s) associated with this job.");
        }
        else
        {
          document.getElementById('epay').value=json[0]; 
          document.getElementById('desc').innerHTML=json[1];
          document.getElementById('words').value=json[2];
          document.getElementById('namount').value=json[3];
          document.getElementById('bamount').value=json[4];
          document.getElementById('tries').value=json[5];
          document.getElementById('jobname').value=json[6]; 
          document.getElementById('uploadFile').value='N';
          document.getElementById('predesc').value=json[1];
          document.getElementById('file').disabled="true";
          document.getElementById('file').value=json[7];
          document.getElementById('flabel').style.display="none";
          document.getElementById('desc').style.border="2px solid #eee";
          document.getElementById('desc').style.borderRadius="4px";
          document.getElementById('desc').style.margin="1px";
          document.getElementById('desc').style.padding="6px";
          document.getElementById('desc').style.maxHeight="135px";
          document.getElementById('desc').style.overflow="auto";
        }
      }  
  });  
}

function getWriterFields(writerLevel)
{ 
  $.ajax({
    type:"GET",
    url:"/members/getWriterFields?writerLevel="+writerLevel,
    success:function(data){   
        var json = JSON.parse(data);
        if(json=="Error")
        { 
        }
        else
        { 
          document.getElementById('words').value=json[0];
          document.getElementById('namount').value=json[1];
          document.getElementById('bamount').value=json[2];
          document.getElementById('tries').value=json[3]; 
        }
      }  
  }); 
  return false; 
} 