<?php 
$studentLogsTable = '
<th scope="col">#</th>
<th scope="col">Location</th>
<th scope="col">Type</th>
<th scope="col">Date</th>
';

?>


<div class="modal fade" id="studentLogsModal" tabindex="-1" aria-labelledby="studentLogsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="studentLogsModalLabel">Student Log</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">             
            <p class = "font-weight-bold">Log Details</p>
              <div id = "mini_subject_table">

                <table id="student_logs_table" class="table table-hover dataTable m-3 w-100">
                    <thead>
                    <tr>
                        <?php echo $studentLogsTable?>
                    </tr>
                    </thead>
                    <tbody id = "">
                    
                    </tbody>
                </table>

              </div>          
       
            
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>

<script>

    var controllerAddress = '../controller/maincontroller.php';

    function getStudentLogs(deviceid){
        var studentDeviceID = deviceid;
        console.log("SELECTED DEVICE ID:"+studentDeviceID);
        $.ajax({
            url:controllerAddress,
            type:'POST',
            data:{purpose:'getstudentlogs',parameters:studentDeviceID}
        }).then(function(response){
            var res = JSON.parse(response);
            console.log(res);

            if(res.error==false){

                var table = new DataTable('#student_logs_table');
                table.destroy().draw();  
                var tempData = [];
                $.each(res.data_logs,function(i,val){
                var count = (i+1);
                //data-toggle="modal" data-target="#exampleModal"
                var actionButtons = `<span>
                <button onclick = "javascript: getStudentLogs(${i});" class = "btn btn-sm btn-primary">View Logs</button>
                <button onclick = "javascript: actionButton('removestudentclass',${i});" class = "btn btn-sm btn-danger">Remove</button>
                </span>`;
                var redirectLocationtoMap = `<a type = "button" href="http://www.google.com/maps/place/${val.location}" target="_blank">Search in Google Streets </a>`;
                tempData.push([count,redirectLocationtoMap,val.log_type, val.date_added]);
                });
            }


            $('#student_logs_table').DataTable( {
            data: tempData,
            } );


        });
    }
</script>
