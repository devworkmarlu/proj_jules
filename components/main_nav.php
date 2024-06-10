<?php 
require_once './include/Config.php';
$root = "/proj_jules"; 
$projectName = explode(":",GLOBAL_PROJECT_NAME);
?>

<nav class="navbar navbar-primary bg-primary">
  <a class="navbar-brand text-white" href="#">
  <img onclick="" src="<?php echo $root?>/plugs/images/logo/pin_map.png" width="30" height="30" alt="">
    <?php echo $projectName[0];?>
  </a>
</nav>