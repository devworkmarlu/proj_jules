<?php 
require_once 'include/session_handler.php';
$sessionHandler = new Session_Handler();
$sessionHandler->isloggedIn();

$root = "/proj";
?>
<!DOCTYPE html>

<html lang="en">
<script src="<?php echo $root;?>/plugs/js/jquery.min.js" ></script>
<script src="<?php echo $root;?>/plugs/js/jquery-ui.min.js" ></script>
<script src="<?php echo $root;?>/plugs/js/jquery.base64.js" ></script>
<script src="<?php echo $root;?>/plugs/js/swal2.min.js" ></script>
<script src="<?php echo $root;?>/plugs/js/queryj.min.js" ></script>
<?php include 'components/site_header.php';?>

<body>
<?php include 'components/main_nav.php';?>
<div class="container p-3">
  <div class="card text-center">
  <div class="card-header">
    <img src="<?php echo $root?>/plugs/images/logo/pin_map.png" width="60" height="60" alt="">
    <span class = "text-primary"><?php echo $projectName[0]."-".$projectName[1];?></span>
  </div>
  <div class="card-body">
    <h5 class="card-title">Login Form</h5>

    

    <center>
    <div style="max-width: 60%;" class = "row text-center">

<div class = "col-md p-3">
    <div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Username</span>
    </div>
    <input id = "input_username" type="text" class="form-control" placeholder="username" aria-label="username" aria-describedby="basic-addon1">
    </div>
</div>

 <div class = "col-md p-3">
    <div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Password</span>
    </div>
    <input id = "input_password" type="password" class="form-control" placeholder="password" aria-label="password" aria-describedby="basic-addon1">
    </div>
</div>
</div>
    </center>
    <a href="#" onclick="javascript:loginUser();" class="btn btn-primary">Hook Me Up</a>
  </div>
  <div class="card-footer text-muted">
    
  </div>
</div>
</div>
</body>
</html>
<script>
    function loginUser(){

        var username_input = $('#input_username').val();
        var password_input = $('#input_password').val();

        if(username_input.length==0 || password_input.length==0){
            Swal.fire({
                title:'Cant Leave Empty Handed',
                icon:'error'
            });

            return;
            
        }

        var loginParam = {
            username:username_input.replace("'",""),
            password:password_input.replace("'","")
        }
        console.log(loginParam);
        
        $.ajax({
            url:'./controller/maincontroller.php',
            type:'POST',
            data:{purpose:'loginuser',parameters:loginParam}
        }).then(function(response){
            var res = JSON.parse(response);
            console.log(res);
            if(res.error==true){
                $('#input_username').val('');
                $('#input_password').val('');
                Swal.fire({
                    title:res.msg,
                    icon:'warning'
                });
            }else{
                
                window.location.replace("./screens/main_screen.php");
            }
        });

    }
</script>


