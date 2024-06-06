<?php 

$classListHeader = '
<th scope="col">#</th>
<th scope="col">Subject Title</th>
<th scope="col">Subject Code</th>
<th scope="col">Student Count</th>
<th scope="col">Action</th>
';

?>
<div>
    <h3 class = "text-muted">Class List</h3>

        <div id="dashboard_card_students" class = "col-md m-2">
        <div class="card border-primary mb-3" style="max-width: 22rem;">
        <div class="card-header">My Classes</div>
        <div class="card-body text-primary">
            <h1 id="class_count" class="card-title">0</h1>
            
        </div>
        </div>
        </div>
        <div class = "p-3">
            <?php include '../screens/class_management.php';?>
        </div>
</div>

<div id = "student_logs_container">

</div>
<script>
    var foundClassList = [];
    var foundClassStudenList = [];
    var selectedClassStudent = [];
    var selectedClass = [];
    var selectedStudentDevice = "";
    loadClassListData();
    
    function loadClassListData(){

        var table = new DataTable('#class_list_table');
        table.destroy().draw();    

        $.ajax({
        url:'../controller/maincontroller.php',
        type:'POST',
        data:{purpose:'getclassdata',parameters:sessionData.username}
        }).then(function(response){
        var res = JSON.parse(response);
        console.log(res);
        if(res.error==false){
            $('#class_count').text(res.class_data.length);
            foundClassList = res.class_data;
            
            /* $('#teacher_count').text(res.total_teachers);
            $('#user_count').text(res.total_users); */
            var tempData = [];
            $.each(res.class_data,function(i,val){
                var count = (i+1);
                //data-toggle="modal" data-target="#exampleModal"
                foundClassStudenList[i] = val.student_list;
                var actionButtons = `<span>
                ${(val.student_list)?`<button class = "btn btn-sm btn-primary" onclick = "javascript:loadStudentClassList('${i}')" data-toggle="modal" data-target="#studentListModal" >View Students</button>`:''}
                <button onclick = "javascript: actionButton('removeclasslist',${i});" class = "btn btn-sm btn-danger">Remove</button>
                </span>`;
                tempData.push([count,val.subject_name.toUpperCase(),val.subject_code.toUpperCase(),0, actionButtons]);
            });


        }

        $('#class_list_table').DataTable( {
            data: tempData,
        } );


        });

        }


        function loadStudentClassList(index){

            var table = new DataTable('#class_students_table');
            table.destroy().draw();  
            selectedClass = foundClassList[index];
            //foundClassStudenList[index];
            if(foundClassStudenList[index]){
                console.log(foundClassStudenList[index]);
                
                var tempData = [];
                $.each(foundClassStudenList[index],function(i,val){
                var count = (i+1);
                //data-toggle="modal" data-target="#exampleModal"
                selectedClassStudent[i] = val;
                var actionButtons = `<span>
                <button onclick = "javascript: selectStudent(${i});" class = "btn btn-sm btn-primary" data-toggle="modal" data-target="#studentLogsModal">View Logs</button>
                <button onclick = "javascript: actionButton('removestudentclass',${i});" class = "btn btn-sm btn-danger">Remove</button>
                </span>`;
                tempData.push([count,val.full_name.toUpperCase(),val.grade_level,val.device_id, actionButtons]);
            });
            $('#class_students_table').DataTable( {
            data: tempData,
            } );


            }
        
        }

        function selectStudent(index){
            selectedStudentDevice = selectedClassStudent[index].device_id;
            getStudentLogs(selectedStudentDevice);
        }

    
</script>