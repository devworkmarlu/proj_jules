<?php 
?>
<div>
    <h3 class = "text-muted">Students</h3>

        <div id="dashboard_card_students" class = "col-md m-2">
        <div class="card border-primary mb-3" style="max-width: 22rem;">
        <div class="card-header">Students</div>
        <div class="card-body text-primary">
            <h1 id="student_count" class="card-title">0</h1>
            
        </div>
        </div>
        </div>
        <div class = "p-3">
            <?php include '../screens/student_management.php';?>
        </div>
</div>
<div id = "student_logs_container">
    
</div>
<script>

loadStudentData();

    function loadStudentData(){
        $("student_logs_container > div").remove();
        $.ajax({
        url:'../controller/maincontroller.php',
        type:'POST',
        data:{purpose:'studentdata',parameters:''}
        }).then(function(response){
        var res = JSON.parse(response);
        console.log(res);

        if(res.error==false){
            $('#student_count').text(res.total_students);
          
        }

        $("#student_logs_container").load('../contents/student_logs_content.php');

        });

        }
    
</script>