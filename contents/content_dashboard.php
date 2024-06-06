<?php 
?>
<div>
    <h3 class = "text-muted">Dashboard</h3>
    <div class = "content p-3 row">

        <div id="dashboard_card_users" class = "col-md m-2">
        <div class="card border-primary mb-3">
        <div class="card-header">Users</div>
        <div class="card-body text-primary">
            <h1 id="user_count" class="card-title">0</h1>
            
        </div>
        </div>
        </div>


        <div id="dashboard_card_teachers" class = "col-md m-2">
        <div class="card border-primary mb-3">
        <div class="card-header">Teachers</div>
        <div class="card-body text-primary">
            <h1 id="teacher_count" class="card-title">0</h1>
            
        </div>
        </div>
        </div>

        
        <div id="dashboard_card_students" class = "col-md m-2">
        <div class="card border-primary mb-3">
        <div class="card-header">Students</div>
        <div class="card-body text-primary">
            <h1 id="student_count" class="card-title">0</h1>
            
        </div>
        </div>
        </div>
    </div>
</div>
<script>
    var facultyUserType = $('#faculty_user_holder_container').text();
    console.log(facultyUserType);
    loadDashboardData();

    if(sessionData.faculty_type!='teacher' && facultyUserType!='STAFF/ADMIN'){
        //menu_subjects
        $('#menu_subjects').remove();
    }

    if(facultyUserType=="STAFF/USER"){
        //Dahsboards
        $('#dashboard_card_users').remove();
        $('#dashboard_card_students').remove();
        //Menu
        $('#menu_users').remove();
        $('#menu_students').remove();
       
    }

    if(facultyUserType=="TEACHER/ADMIN"){
        //Dashboard
        $('#dashboard_card_users').remove();

        //Menu
        $('#menu_users').remove();
    }

    if(facultyUserType=="TEACHER/USER"){
        //Dashboard
        $('#dashboard_card_users').remove();
        $('#dashboard_card_teachers').remove();

         //Menu
         $('#menu_users').remove();
         $('#menu_teachers').remove();
    }


    function loadDashboardData(){

        $.ajax({
        url:'../controller/maincontroller.php',
        type:'POST',
        data:{purpose:'dashboarddata',parameters:''}
        }).then(function(response){
        var res = JSON.parse(response);
        console.log(res);

        if(res.error==false){
            $('#student_count').text(res.total_students);
            $('#teacher_count').text(res.total_teachers);
            $('#user_count').text(res.total_users);
        }
    });

    }

    
    
</script>