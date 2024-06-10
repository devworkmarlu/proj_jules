<?php 


class Session_Handler{

    public function __construct(){
        session_start();
    }


    public function isloggedIn(){
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
            header("Location: /proj_jules/screens/main_screen.php"); 
        }
        

    }

    public function isloggedOut(){
        
        if(!isset($_SESSION['logged_in'])){
            header("Location: /proj_jules/index.php");
        }

    }

    public function destorySession(){
        session_destroy();
    }

    public function userLogOut(){
        
        session_destroy();
        header("Location: /proj_jules/index.php");
        //session_destroy(); 
    }


    public function getSessionDetails(){

        $sessionContainer = array();
        $sessionContainer['username'] = $_SESSION['username'];
        $sessionContainer['user_type'] = $_SESSION['user_type'];
        $sessionContainer['faculty_type'] = $_SESSION['faculty_type'];
        $sessionContainer['full_name'] = $_SESSION['full_name'];
        $sessionContainer['logged_in'] = $_SESSION['logged_in'];
        return $sessionContainer;

    }


    public function setSessionDetails($sessionContainer,$entryType){
        
        if($entryType=="login"){
            $_SESSION['username'] = $sessionContainer[0]['username'];
            $_SESSION['user_type'] = $sessionContainer[0]['user_type'];
            $_SESSION['faculty_type'] = $sessionContainer[0]['faculty_type'];
            $_SESSION['full_name'] = $sessionContainer[0]['full_name'];
            $_SESSION['logged_in'] = true;
        }
    }

}

?>