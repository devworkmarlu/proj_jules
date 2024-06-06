<?php 
$tableHeader = '
<th scope="col">#</th>
<th scope="col">Subject Title</th>
<th scope="col">Subject Code</th>
<th scope="col">Action</th>
';

$tableStudentsHeader = '
<th scope="col">#</th>
<th scope="col">Full Name</th>
<th scope="col">Year Level</th>
<th scope="col">Device ID</th>
<th scope="col">Action</th>
';

$pageTitle = "Subjects";
?>

<div class = "p-3" id = "operations_container">
    <span><button onclick = "javascript:loadData();" class = "btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Subjects</button></span>
</div>

<div class = "p-3 table-responsive" id = "dt_user_container">

                 <table id="class_list_table" class="table table-hover dataTable m-3 w-100">
                    <thead>
                    <tr>
                        <?php echo $classListHeader?>
                    </tr>
                    </thead>
                    <tbody id = "">
                    
                    </tbody>
                </table>
    
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Subject to Class List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">             
            <p class = "font-weight-bold">Subject Details</p>
              <div id = "mini_subject_table">

                <table id="users_table" class="table table-hover dataTable m-3 w-100">
                    <thead>
                    <tr>
                        <?php echo $tableHeader?>
                    </tr>
                    </thead>
                    <tbody id = "user_table_body">
                    
                    </tbody>
                </table>

              </div>          
       
            
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="studentListModal" tabindex="-1" aria-labelledby="studentListModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="studentListModalLabel">List of Students</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">             
            <p class = "font-weight-bold">Student Details</p>
              <div id = "mini_student_table">

                <table id="class_students_table" class="table table-hover dataTable m-3 w-100">
                    <thead>
                    <tr>
                        <?php echo $tableStudentsHeader?>
                    </tr>
                    </thead>
                    <tbody id = "user_table_body">
                    
                    </tbody>
                </table>

              </div>          
       
            
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<div id = "student_logs_container">

</div>
<script>
    
    var controrllerAddress = '../controller/maincontroller.php';

    loadData();
    
    function loadData(){

        //$("#user_table_body> tr").remove();
        $("student_logs_containerstudent_logs_container > div").remove();
        var table = new DataTable('#users_table');
        table.destroy().draw();
        $.ajax({
        url:controrllerAddress,
        type:'POST',
        data:{purpose:'getsubjectdata',parameters:''}
    }).then(function(response){

        var res = JSON.parse(response);
        console.log(res);
        let tempData = [];
        if(res.error==false){

            foundSubjects = res.subject_data;
            
            $.each(res.subject_data,function(i,val){
                var count = (i+1);
                
                var actionButtons = `<span>
                ${(sessionData.faculty_type=='teacher')?`<button onclick = "avascript: actionButton('addclasslist',${i});" class = "btn btn-sm btn-primary m-1">Add to class list</button>`:''}
                <button onclick = "" class = "btn btn-sm btn-warning m-1">Edit</button>
                <button onclick = "javascript: actionButton('remove',${i});" class = "btn btn-sm btn-danger">Remove</button>
                </span>`;
                tempData.push([count,val.subject_name.toUpperCase(),val.subject_code.toUpperCase(), actionButtons]);
            });
            
            $("#student_logs_container").load('../contents/student_logs_content.php');
        }
        
        $('#users_table').DataTable( {
            data: tempData,
        } );

        

    });
    }



    function actionButton(action,index){

        Swal.fire({
        title: "Do you want to save the changes?",
        showCancelButton: true,
        confirmButtonText: "Save",
        denyButtonText: `Don't save`
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

            if(action=='removestudentclass'){
                removeStudetFromClass(index);
            }

            if(action=='removeclasslist'){
                removeClassList(index);
            }

            if(action=='addclasslist'){
                addClassList(index);
            }

            if(action=='adduser'){
                addUser();
            }

            if(action=='remove'){
                removeUser(index);
            }
            
        } 
        });

    }


    function removeClassList(index){
        
        let removeParam = {
            username:sessionData.username,
            subject_id:foundClassList[index].subject_id,
            class_record_id:foundClassList[index].class_record_id
        }

        console.log(removeParam);

        $.ajax({
            url:controrllerAddress,
            type:'POST',
            data:{purpose:'removetoclasslist', parameters:removeParam}
        }).then(function(response){
            var res = JSON.parse(response);
            if(res.error==false){
                Swal.fire({
                    title:res.msg,
                    icon:'success'
                });

                resetDataTable();

            }else{

                Swal.fire({
                    title:res.msg,
                    icon:'warning'
                });

            }

            
        });

    }

    function removeStudetFromClass(index){

        let removeClassParam = {
            username:sessionData.username,
            class_record_id:selectedClass.class_record_id,
            student_record_id:selectedClassStudent[index].table_record_id
        }


        console.log("REMOVE PARAMETERS:");
        console.log(removeClassParam);

        $.ajax({
            url:controrllerAddress,
            type:'POST',
            data:{purpose:'removestudentclass', parameters:removeClassParam}
        }).then(function(response){
            var res = JSON.parse(response);
            if(res.error==false){
                Swal.fire({
                    title:res.msg,
                    icon:'success'
                });

                resetDataTable();

            }else{

                Swal.fire({
                    title:res.msg,
                    icon:'warning'
                });

            }

            
        });

        }


    function addClassList(index){

        let param ={
            username:sessionData.username,
            subject_id:foundSubjects[index].table_record_id
        }

        console.log(param);
        $.ajax({
            url:controrllerAddress,
            type:'POST',
            data:{purpose:'addtoclasslist', parameters:param}
        }).then(function(response){
            var res = JSON.parse(response);
            if(res.error==false){
                Swal.fire({
                    title:res.msg,
                    icon:'success'
                });

                resetDataTable();

            }else{

                Swal.fire({
                    title:res.msg,
                    icon:'warning'
                });

            }

            
        });

    }

    function removeUser(index){

        var selectedRecordid = foundSubjects[index].table_record_id;
        var title = foundSubjects[index].subject_name;
        var code = foundSubjects[index].subject_code;


        var param = {
            todo:'remove',
            table_record_id:selectedRecordid,
            subject_title:title,
            subject_code:code
            
        }
        
        $.ajax({
            url:controrllerAddress,
            type:'POST',
            data:{purpose:'crudsubject',parameters:param}
        }).then(function(response){
            var res = JSON.parse(response);
            if(res.error==false){
                Swal.fire({
                    title:res.msg,
                    icon:'success'
                });

                resetDataTable();

            }else{
                Swal.fire({
                    title:res.msg,
                    icon:'error'
                });
            }

            

        });


    }

    function addUser(){
       
        var title_input = $('#input_title').val();
        var code_input = $('#input_code').val();

        if(title_input.length==0 || code_input.length==0){

            if(title_input.length==0){
                $('#input_title').focus();
            }

            if(code_input.length==0){
                $('#input_code').focus();
            }

            Swal.fire(
                {
                    title:'Cant leave empty',
                    icon: "error",
                }
            )

            return;

        }

         

        var param = {
            todo:'add',
            subject_title:title_input.replace("'","").toUpperCase(),
            subject_code:code_input.replace("'","").toUpperCase(),
            added_by:sessionData.username
            
        };

        $.ajax({
            url:controrllerAddress,
            type:'POST',
            data:{purpose:'crudsubject',parameters:param}
        }).then(function(response){
            var res =JSON.parse(response);
            console.log(res);
            if(res.error==false){
                $('#dismiss_add_user').click();
                resetDataTable();
            }else{
                Swal.fire({
                    title:res.msg,
                    icon:'error'
                });
            }

        });
        


    }

    

    function resetDataTable(){
        $('#input_username').val('');
        $('#input_password').val('');
        var table = new DataTable('#users_table');
        table.destroy().draw();
        loadClassListData();
        loadData();
        //openContent('users');
    }

    

</script>