<?php 
$tableHeader = '
<th scope="col">#</th>
<th scope="col">Full Name</th>
<th scope="col">Device ID</th>
<th scope="col">Username</th>
<th scope="col">Password</th>
<th scope="col">User Type</th>
<th scope="col">Faculty Type</th>
<th scope="col">Action</th>
';
?>

<div class = "p-3" id = "operations_container">
    <span><button class = "btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Users</button></span>
</div>

<div class = "p-3 table-responsive" id = "dt_user_container">
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p class = "font-weight-bold">User Type</p>
            <div class = "row">
                <div class = "col-md p-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="selected_usertype">User Type</label>
                    </div>
                    <select class="custom-select" id="selected_usertype">
                        
                        <option value="user" selected>User</option>
                        <option id="user_type_admin_option" value="admin">Admin</option>
                        
                    </select>
                    </div>
                </div>

                <div class = "col-md p-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="selected_facultytype">Faculty Type</label>
                    </div>
                    <select onchange="determineFacultyType()" class="custom-select" id="selected_facultytype">
                        
                        <option value="teacher" selected>Teacher</option>
                        <option value="student">Student</option>
                        <option value="staff">Staff</option>
                        
                    </select>
                    </div>
                </div>

            </div>

            <hr>

                    <p class = "font-weight-bold">Personal-Information</p>
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Full-Name</span>
                    </div>
                    <input id = "input_fullname" type="text" class="form-control" placeholder="Full-Name" aria-label="Full-Name" aria-describedby="basic-addon1">
                    </div>

                    <div id="main_device_id_container" class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Device Unique ID</span>
                    </div>
                    <input id = "input_device_id" type="text" class="form-control" placeholder="Device Unique ID" aria-label="Device Unique ID" aria-describedby="basic-addon1">
                    </div>

                    <div class = "row">
                        <div class="col-md p-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">ID-Number</span>
                            </div>
                            <input id = "input_idnumber" type="text" class="form-control" placeholder="ID-Number" aria-label="ID-Number" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="col-md p-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="selected_gradelevel">Year/Grade Level</label>
                            </div>
                            <select class="custom-select" id="selected_gradelevel">
                                <option value="n/a" selected>N/A</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            </div>
                        </div>

                    </div>
            <hr>
            <p class = "font-weight-bold">User Credentials</p>
            <div class = "row" id = "add_user_form">
                <div class = "col-md p-3">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Username</span>
                    </div>
                    <input id = "input_username" type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>

                <div class = "col-md p-3">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Password</span>
                    </div>
                    <input id = "input_password" type="text" class="form-control" placeholder="password" aria-label="password" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
       
            
      </div>
      <div class="modal-footer">
        <button id="dismiss_add_user" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button onclick = "javascript:actionButton('adduser');" type="button" class="btn btn-primary">Add User</button>
      </div>
    </div>
  </div>
</div>
<script>
    var foundUsers = [];
    var controrllerAddress = '../controller/maincontroller.php';
    loadData();
    function loadData(){

        //$("#user_table_body> tr").remove();
        
        $.ajax({
        url:controrllerAddress,
        type:'POST',
        data:{purpose:'getallusers',parameters:''}
    }).then(function(response){

        var res = JSON.parse(response);
        console.log(res);
        let tempData = [];
        if(res.error==false){

            foundUsers = res.user_data;

            $.each(res.user_data,function(i,val){
                var count = (i+1);
                 // Generate an MD5 hash
                const hash = CryptoJS.MD5(val.password).toString(); // Convert to a string
                var actionButtons = `<span><button onclick = "" class = "btn btn-sm btn-warning m-1">Edit</button><button onclick = "javascript: actionButton('remove',${i});" class = "btn btn-sm btn-danger">Remove</button></span>`;
                tempData.push([count,val.full_name,val.device_id,val.username,hash,val.user_type,val.faculty_type, actionButtons]);
            });
        
        }
        determineFacultyType();
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
            if(action=='adduser'){
                addUser();
            }

            if(action=='remove'){
                removeUser(index);
            }
            
        } 
        });

    }


    function removeUser(index){

        var selectedRecordid = foundUsers[index].table_record_id;
        console.log(selectedRecordid);

        $.ajax({
            url:'../controller/maincontroller.php',
            type:'POST',
            data:{purpose:'removeuser',parameters:selectedRecordid}
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
        var isStudent = determineFacultyType();
        var username_input = $('#input_username').val();
        var password_input = $('#input_password').val();
        var usertype_select = $('#selected_usertype').val();
        var facultytype_select = $('#selected_facultytype').val();
        var fullname_input = $('#input_fullname').val();
        var idnumber_input = $('#input_idnumber').val();
        var deviceid_input = $('#input_device_id').val();
        var grade_select = $('#selected_gradelevel').val();
    

        if(username_input.length==0 || password_input.length==0 || fullname_input.length==0){

            if(username_input.length==0){
                $('#input_username').focus();
            }

            if(password_input.length==0){
                $('#input_password').focus();
            }

            Swal.fire(
                {
                    title:'Cant leave empty',
                    icon: "error",
                }
            )

            return;

        }

            if(isStudent==true){
                if(deviceid_input.length==0){
                    Swal.fire(
                        {
                            title:'Cant leave empty',
                            icon: "error",
                        }
                    );

                    return;
                }
            }

        var param = {
            username:username_input.replace("'",""),
            password:password_input.replace("'",""),
            usertype:usertype_select,
            facultytype:facultytype_select,
            fullname:fullname_input.replace("'",""),
            idnumber:idnumber_input.replace("'",""),
            gradelevel:grade_select,
            deviceid:deviceid_input.replace("'",""),
            added_by:sessionData.username
        };

        $.ajax({
            url:controrllerAddress,
            type:'POST',
            data:{purpose:'adduser',parameters:param}
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

    function determineFacultyType(){
        var facultytype_select = $('#selected_facultytype').val();
        var isStudent = false;
        if(facultytype_select=="student"){
            $("#input_device_id").prop('disabled', false);
            $('#main_device_id_container').show();
            //user_type_admin_option
            $("#user_type_admin_option").prop('disabled', true);
            isStudent = true;
            //$("input").prop('disabled', false);
        }else{
            $('#input_device_id').val('');
            $("#input_device_id").prop('disabled', true);
            $("#user_type_admin_option").prop('disabled', false);
            $('#main_device_id_container').hide();
        }

        return isStudent;
    }

    function resetDataTable(){
        $('#input_username').val('');
        $('#input_password').val('');
        $('#input_fullname').val('');
        $('#input_idnumber').val('');
        $('#input_device_id').val('');
        var table = new DataTable('#users_table');
        table.destroy().draw();
        loadUserData();
        loadData();
        //openContent('users');
    }

    

</script>