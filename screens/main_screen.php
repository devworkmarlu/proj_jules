<?php 
//include("../include/session_handler.php");
require_once '../include/Config.php';
require_once '../include/session_handler.php';
$projectName = explode(":",GLOBAL_PROJECT_NAME);
$sessionHandler = new Session_Handler();
$sessionHandler->isloggedOut();
?>

<html lang="en">
<?php include '../components/plugin_header.php';?>
<?php include '../components/site_header.php';?>
<body>
<div class = "">
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav(null)">&times;</a>
  <div class = "p-3">
    <img style="border-radius: 50%;"  class="bg-white" src="<?php echo $root?>/plugs/images/logo/pin_map.png" width="60" height="60" alt=""><br>
    <span id="username_holder_container" class = "text-white font-weight-bold"></span>
    <br>
    <span id="faculty_user_holder_container" class = "text-white"></span>
    
  </div>
  <div id = "menu_container">
  
  </div>
</div>

<div id="main">
<nav class="navbar navbar-primary bg-primary">
  <a class="navbar-brand text-white" href="#">
  <img onclick="javascript:openNav();" src="<?php echo $root?>/plugs/images/logo/pin_map.png" width="30" height="30" alt="">
    <?php echo $projectName[0];?>
  </a>
  <div class = "row p-3">
  <span class="m-1 text-white font-weight-bold btn">Notifications</span>
  <span class="m-1 text-white font-weight-bold btn">New Request</span>
  
  </div>

</nav>
  <div id="content_container" class = "p-3">
    <div>
    <h2>Sidenav Push Example</h2>
    <p>Click on the element below to open the side navigation menu, and push this content to the right.</p>
    </div>
  </div>
  
</div>
</div>
    
</body>
</html>
<script>
    var currentMenuOpened = "";
    var sessionData = [];
    loadSession();
    function loadSession(){
        $.ajax({
            url:'../controller/maincontroller.php',
            type:'POST',
            data:{purpose:'loadsessiondetails',parameters:''}
        }).then(function(response){
            var res = JSON.parse(response);
            //console.log(res);
            if(res.error==false){
                sessionData = res.session_data;
                var facultyUserType = (res.session_data.faculty_type.toUpperCase()) + "/" + (res.session_data.user_type.toUpperCase());
                $('#username_holder_container').text(res.session_data.full_name.toUpperCase());
                $('#faculty_user_holder_container').text(facultyUserType);
                $("#menu_container").load('../contents/menu_file.php');
                //$("#content_container").load('../contents/content_dashboard.php');
                //currentMenuOpened = ""
                //faculty_user_holder_container
                openContent('dashboard');

            }
        });
    }

    
    

    //menu_container
    function openNav() {
    document.getElementById("mySidenav").style.width = "200px";
    document.getElementById("main").style.marginLeft = "200px";
    }

function closeNav(content) {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
    if(content!=null){
        openContent(content);
    }
}


function openContent(content){
    console.log(content);
    if(content!="logout"){
        $("#content_container> div").remove();
    }
    if(content=='dashboard'){
        $("#content_container").load('../contents/content_dashboard.php');
    }

    if(content=='students'){
        $("#content_container").load('../contents/content_student.php');
    }

    if(content=='teachers'){
        $("#content_container").load('../contents/content_teacher.php');
    }

    if(content=='users'){
        $("#content_container").load('../contents/content_users.php');
    }

    if(content=='subjects'){
        $("#content_container").load('../contents/content_subjects.php');
    }

    if(content=='class'){
        $("#content_container").load('../contents/content_class.php');
    }

    if(content=='logout'){
        Swal.fire({
        title: "Are you sure you want to logout?",
        showCancelButton: true,
        confirmButtonText: "Im out!",
        }).then((result) => {
        
        if (result.isConfirmed) {
            
            $.ajax({
                url:'../controller/maincontroller.php',
                type:'POST',
                data:{purpose:'logoutuser',parameters:''}
            }).then(function(){
                window.location.replace("../index.php");
            });
        }
        });
    }

    
}
</script>