<?php 
?>
<div>
    <h3 class = "text-muted">Teachers</h3>

        <div id="dashboard_card_teachers" class = "col-md m-2">
        <div class="card border-primary mb-3" style="max-width: 22rem;">
        <div class="card-header">Teachers</div>
        <div class="card-body text-primary">
            <h1 id="teacher_count" class="card-title">0</h1>
            
        </div>
        </div>
        </div>

        <div class = "p-3">
            <?php include '../screens/teacher_management.php';?>
        </div>
</div>
<script>

        loadTeacherData();

        function loadTeacherData(){

        $.ajax({
        url:'../controller/maincontroller.php',
        type:'POST',
        data:{purpose:'teacherdata',parameters:''}
        }).then(function(response){
        var res = JSON.parse(response);
        console.log(res);

        if(res.error==false){
            //$('#student_count').text(res.total_students);
            $('#teacher_count').text(res.total_teachers);
            //$('#user_count').text(res.total_users);
        }


        });

        }
    
</script>