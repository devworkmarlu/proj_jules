<?php 

error_reporting(0);
require_once '../include/DB_Functions.php';
require_once '../include/session_handler.php';
$db = new DB_Functions();
$sessionHandler = new Session_Handler();


// json response array
$response = array("error" => FALSE);

if (isset($_POST['purpose']) && isset($_POST['parameters'])) {

    $purpose = $_POST['purpose'];
    $parameters = $_POST['parameters'];


    if($purpose=="testapi"){
        $response['error'] = false;
        $response['msg'] = 'Successfully Connected to API';
    }

    if($purpose=="getstudentlogs"){
        $studentLogs = $db->getStudentLogs($parameters);
        if($studentLogs){
            $response["error"] = false;
            $response["data_logs"] = $studentLogs;
        }else{
            $response["error"] = false;
            $response["msg"] = 'No Data Found.';
        }
    }

    if($purpose=="registerstudentmobile"){

        $mobileRegistrationResult = $db->RegisterMobileStudent($parameters);
        if($mobileRegistrationResult['status']==true){
            $response['error'] = FALSE;
        }else{
            $response['error'] = TRUE;
        }
        $response['msg'] = $mobileRegistrationResult['msg'];
    }

    if($purpose=="logstudent"){
        //$param = http_build_query(array('deviceid' => $parameters['deviceid'],'location' => $parameters['location'],'logtype' => $parameters['logtype']));
        $logResult = $db->logStudentLocation($parameters);
        if($logResult['status']==true){
            $response['error'] = FALSE;
            
        }else{
            $response['error'] = TRUE;
        }
        $response['msg'] = $logResult['msg'];
    }

    if($purpose=="removestudentclass"){
        $removeResult = $db->removeStudentfromClass($parameterss);
        if($removeResult['status']==TRUE){
            $response["error"] = FALSE;
        }else{
            $response["error"] = TRUE;
        }
        $response["msg"] = $removeResult['msg'];
    }


    if($purpose=="addtostudentlist"){

        $addResult = $db->addStudentList($parameters);
        if($addResult['status']==true){
            $response['error'] = FALSE;
            
        }else{
            $response['error'] = TRUE;
        }
        $response['msg'] = $addResult['msg'];
    }


    if($purpose=="removetoclasslist"){
        $removeResult = $db->removeToClassList($parameters);
        if($removeResult['status']==TRUE){
            $response["error"] = FALSE;
        }else{
            $response["error"] = TRUE;
        }
        $response["msg"] = $removeResult['msg'];
    }

    if($purpose=="addtoclasslist"){
        $addResult = $db->addClassList($parameters);
        if($addResult['status']==TRUE){
            $response["error"] = FALSE;
        }else{
            $response["error"] = TRUE;
        }
        $response["msg"] = $addResult['msg'];
    }


    if($purpose=="getclassdata"){

        $classData = $db->getClassData($parameters);
        $response['class_data'] = $classData;

    }


    if($purpose=="crudsubject"){

        $todo =  $parameters['todo'];
        if($todo=="add"){

            $title = $parameters['subject_title'];
            $code = $parameters['subject_code'];
            $addedby = $parameters['added_by'];

            $result = $db->addSubject($title,$code,$addedby);
            if($result['status']==true){
                $response['error'] = FALSE;
                $response['msg'] = $result['msg'];
            }else{
                $response['error'] = TRUE;
                $response['msg'] = $result['msg'];
            }
            


        }
        if($todo=="remove"){
            $record_id = $parameters['table_record_id'];
            $title = $parameters['subject_title'];
            $code = $parameters['subject_code'];
            $result = $db->removeSubject($record_id,$title,$code);
            if($result['status']==true){
                $response['error'] = FALSE;
                $response['msg'] = $result['msg'];
            }else{
                $response['error'] = TRUE;
                $response['msg'] = $result['msg'];
            }
            

        }

    }


    if($purpose=="getsubjectdata"){
        $subjecResult = $db->getAllSubjects();
        if($subjecResult){
            $response['error'] = false;
            $response['subject_data'] = $subjecResult;
        }else{
            $response['error'] = true;
            $response['msg'] = 'No Data Found';
        }
    }


    if($purpose=="loadsessiondetails"){
        $response["session_data"] = $sessionHandler->getSessionDetails();
    }

    if($purpose=="usersdata"){
        $totalUsers = $db->getNumberofData('');
        $response['total_users'] = $totalUsers;
    }

    if($purpose=="studentdata"){
        $totalStudents = $db->getNumberofData("WHERE faculty_type = 'student'");
        $response['total_students'] = $totalStudents;
    }

    if($purpose=="teacherdata"){
        $totalTeachers = $db->getNumberofData("WHERE faculty_type = 'teacher'");
        $response['total_teachers'] = $totalTeachers;
    }

    if($purpose=="dashboarddata"){

        $totalUsers = $db->getNumberofData('');
        $totalStudents = $db->getNumberofData("WHERE faculty_type = 'student'");
        $totalTeachers = $db->getNumberofData("WHERE faculty_type = 'teacher'");
        $response['total_users'] = $totalUsers;
        $response['total_students'] = $totalStudents;
        $response['total_teachers'] = $totalTeachers;

    }


    if($purpose=="logoutuser"){
        $sessionHandler->userLogOut();
    }

    if($purpose=="loginuser"){
        
        $username = $parameters['username'];
        $password = $parameters['password'];
        $loginResult = $db->loginUser($username,$password);
        if($loginResult){
            if($loginResult[0]['faculty_type']=="student"){

                $response['error'] = TRUE;
                $response['msg'] = 'No Students Allowed!';

            }else{
                $response['error'] = FALSE;
                $response['user_details'] = $loginResult;
                $sessionHandler->setSessionDetails($loginResult,'login');
            }
        }else{
            $response['error'] = TRUE;
            $response['msg'] = 'Error Login, Please Try-again.';
        }
    }

    if($purpose=="removeuser"){

        $removeResult = $db->removeUser($parameters);
        if($removeResult){
            $response["error"] = FALSE;
            $response["msg"] = "User Successfully Removed!";
        }else{
            $response["error"] = TRUE;
            $response["msg"] = "User Successfully Failed to Remove.";
        }

    }

    if($purpose=="adduser"){

        $addResult = $db->addUser($parameters);
        if($addResult['status']==true){
            $response['error'] = false;
            $response['msg'] = $addResult['msg'];
        }else{
            $response['error'] = true;
            $response['msg'] = $addResult['msg'];
        }

    }

    if($purpose=="getallfaculty"){

        $addedQry = "WHERE faculty_type = '$parameters'";

        $studentsList = $db->getAllFaculty($addedQry);
        if($studentsList){
            $response['error'] = false;
            $response['user_data'] = $studentsList;

        }else{
            $response['error'] = true;
            $response['msg'] = 'No Data Found Yet';
        }
    }

    if($purpose=="getallusers"){


        $userList = $db->getAllUsers();
        if($userList){
            $response['error'] = false;
            $response['user_data'] = $userList;

        }else{
            $response['error'] = true;
            $response['msg'] = 'No Data Found Yet';
        }
    }


    if($purpose=="checkconnection"){

        $connectionStatus = $db->checkConnection();
        if($connectionStatus){
            $globalIP = $db->getglobalip();
            $response['error'] = false;
            $response['connection_status'] = $connectionStatus['status'];
            $response['ip'] = $globalIP;

        }else{
            $response['error'] = true;
            $response['msg'] = 'Unable to connect to database';
        }

        
    }

    echo json_encode($response);

    if($purpose=="getallusers"){
        $userlist = $db->checkConnection();
    }



}else{

    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters!";
    echo json_encode($response);
    

}

?>