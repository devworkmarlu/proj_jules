<?php 
?>
<div>
    <h3 class = "text-muted">Subjects</h3>

        <div id="dashboard_card_subjects" class = "col-md m-2">
        <div class="card border-primary mb-3" style="max-width: 22rem;">
        <div class="card-header">Registered Subjects</div>
        <div class="card-body text-primary">
            <h1 id="subject_count" class="card-title">0</h1>
            
        </div>
        </div>
        </div>

        <div class = "p-3">
            <?php include '../screens/subject_management.php';?>
        </div>
</div>
<script>
        var foundSubjects = [];
        loadUserData();

        function loadUserData(){

        $.ajax({
        url:'../controller/maincontroller.php',
        type:'POST',
        data:{purpose:'getsubjectdata',parameters:''}
        }).then(function(response){
        var res = JSON.parse(response);
        console.log(res);

        if(res.error==false){
            //$('#student_count').text(res.total_students);
            //$('#teacher_count').text(res.total_teachers);
            foundSubjects = res.subject_data;
            $('#subject_count').text(res.subject_data.length);
        }


        });

        }
    
</script>