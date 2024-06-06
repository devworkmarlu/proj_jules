
<?php


class DB_Functions {

    private $conn;
    private $serverip;


    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
        $this->serverip=$db->getglobalip();
    }

    // destructor
    function __destruct() {

    }

    public function checkConnection(){
        $response = array();
        if ($this->conn) {
            $response["status"]= "OK";
           return $response;
        }else{
           return false;
        }
    }

    


        public function getglobalip(){
        
        $globalip = $this->serverip;

        return $globalip;

        }



        public function getStudentLogs($parameter){
            $responseContainer = array();
            $result = $this->DynamicGetData("SELECT * FROM student_location WHERE device_id = '$parameter'", $this->conn);
            return $result;
        }

        public function RegisterMobileStudent($parameters){
            $deviceid = $parameters["device_id"];
            $fullname = $parameters["full_name"];
            $idnumber = $parameters["id_number"];
            $gradelevel = $parameters["grade_level"];
            $responseContainer = array();
            $duplicateCheck = $this->DynamicGetData("SELECT full_name FROM users WHERE device_id = '$deviceid'", $this->conn);
            if($duplicateCheck){
                $responseContainer["status"]= false;
                $responseContainer["msg"]= "This Device is registered to".$duplicateCheck[0]['full_name'];
                return $responseContainer;
            }



            $duplicateCheck = $this->DynamicGetData("SELECT full_name FROM users WHERE full_name = '$fullname' or id_number = '$idnumber'", $this->conn);
            if($duplicateCheck){
                $responseContainer["status"]= false;
                $responseContainer["msg"]= "Student Name or ID Number is already taken, please verify.";
                return $responseContainer;
            }

            $uniqueUsername = uniqid();
            $uniquePassword = uniqid();
            $this->conn->query('START TRANSACTION');
            $this->conn->query("INSERT INTO users (username,password,user_type,faculty_type,full_name,id_number,grade_level,device_id,added_by)VALUES('$uniqueUsername','$uniquePassword','user','student','$fullname','$idnumber','$gradelevel','$deviceid','mobile_reg')");
            
            if($this->conn->affected_rows > 0){
                $this->conn->query('COMMIT');
                $responseContainer["status"]= true;
                $responseContainer['msg'] = "You have Successfull Registered.";
            }else{
                $this->conn->query('ROLLBACK');
                $responseContainer["status"]= false;
                $responseContainer['msg'] = "You have Successfull Registered.";
            }


            return $responseContainer;



        }

        public function logStudentLocation($parameters){
            $responseContainer = array();
            $deviceid = $parameters["deviceid"];
            $location = $parameters["location"];
            $logtype = $parameters["logtype"];


            $checkRegisteredDevice = $this->DynamicDataCounter("SELECT table_record_id FROM users WHERE device_id = '$deviceid'", $this->conn);
            if($checkRegisteredDevice==0){
                $responseContainer['status'] = FALSE;
                $responseContainer['msg'] = 'Device is not yet registered.';
                return $responseContainer;
            }


            $this->conn->query("START TRANSACTION");
            $this->conn->query("INSERT INTO student_location (device_id,location,log_type)VALUE('$deviceid','$location','$logtype')");

            if($this->conn->affected_rows > 0){
                $this->conn->query("COMMIT");
                $responseContainer['status'] = TRUE;
                $responseContainer['msg'] = 'Location Successfully Tagged.';
            }else{
                $this->conn->query("ROLLBACK");
                $responseContainer['status'] = FALSE;
                $responseContainer['msg'] = 'Location Successfully Tagged.';
            }


            return $responseContainer;


        }

        public function removeStudentfromClass($parameters){
            $responseContainer = array();
            $username = $parameters['username'];
            $class_record_id = $parameters['class_record_id'];
            $student_record_id = $parameters['student_record_id'];
            $teacher_id =  ($this->DynamicGetData("SELECT table_record_id from users WHERE UPPER(username) = UPPER('$username')", $this->conn))[0]['table_record_id'];

            $this->conn->query("START TRANSACTION");
            $this->conn->query("DELETE FROM student_list WHERE student_id = '$student_record_id' AND class_id = '$class_record_id' and teacher_id = '$teacher_id'");

            if($this->conn->affected_rows > 0){
                $this->conn->query("COMMIT");
                $responseContainer["status"]= TRUE;
                $responseContainer["msg"]= "Student Successfully Removed from Class.";
            }else{
                $this->conn->query("ROLLBACK");
                $responseContainer["status"]= FALSE;
                $responseContainer["msg"]= "Student Successfully Failed Remove from Class.";
            }

            return $responseContainer;


        }

        public function addStudentList($parameters){
            $responseContainer = array();
            $username = $parameters['username'];
            $class_record_id = $parameters['class_record_id'];
            $student_record_id = $parameters['student_record_id'];
            $teacher_id =  ($this->DynamicGetData("SELECT table_record_id from users WHERE UPPER(username) = UPPER('$username')", $this->conn))[0]['table_record_id'];

            $duplicateCheck = $this->DynamicDataCounter("SELECT table_record_id FROM student_list WHERE student_id = '$student_record_id' AND class_id = '$class_record_id' AND teacher_id = '$teacher_id'", $this->conn);
            if($duplicateCheck > 0){
                $responseContainer['status'] = FALSE;
                $responseContainer['msg'] = "Student already existed in Class.";
                return $responseContainer;
            }
            $this->conn->query("START TRANSACTION");
            $this->conn->query("INSERT INTO student_list (student_id,class_id,teacher_id)VALUES('$student_record_id','$class_record_id','$teacher_id')");
            if($this->conn->affected_rows > 0){
                $this->conn->query("COMMIT");
                $responseContainer['status'] = TRUE;
                $responseContainer['msg'] = "Student Successfully Added to Class.";
            }else{
                $this->conn->query("ROLLBACK");
                $responseContainer['status'] = FALSE;
                $responseContainer['msg'] = "Student Successfully Failed to Add in Class.";
            }

            return $responseContainer;
        }

        public function getClassData($parameters){
            $teacherid = ($this->DynamicGetData("SELECT table_record_id from users WHERE UPPER(username) = UPPER('$parameters')", $this->conn))[0]['table_record_id'];
            $responseContainer = array();

            $classResult = $this->DynamicGetData("SELECT a.*, b.subject_name, b.subject_code FROM class_list as a left join subject as b on a.subject_id = b.table_record_id WHERE a.teacher_id = '$teacherid'", $this->conn);
            
            foreach ($classResult as $x => $val) {
                $tempArray = array();

                $foundClassID = $val['table_record_id'];

                $tempArray['date_added'] = $val['date_added'];
                $tempArray['subject_id'] = $val['subject_id'];
                $tempArray['subject_name'] = $val['subject_name'];
                $tempArray['subject_code'] = $val['subject_code'];
                $tempArray['class_id'] = $foundClassID;
                $tempArray['teacher_id'] = $val['teacher_id'];
                $tempArray['class_record_id'] = $val['table_record_id'];
                $studentList = $this->DynamicGetData("SELECT b.* FROM student_list as a left join users as b on a.student_id = b.table_record_id  WHERE a.class_id = '$foundClassID' AND a.teacher_id = '$teacherid'", $this->conn);
                $tempArray['student_list'] = $studentList;
                $responseContainer[$x] = $tempArray;
                //$tempArray[$x] = $val;
              }


              return $responseContainer;

        }


        public function removeToClassList($parameters){
            $responseContainer = array();
            $username = $parameters['username'];
            $subject_id = $parameters['subject_id'];
            $classrecordid = $parameters['class_record_id'];
            $teacher_id =  ($this->DynamicGetData("SELECT table_record_id from users WHERE UPPER(username) = UPPER('$username')", $this->conn))[0]['table_record_id'];
            $this->conn->query("START TRANSACTION");
            $this->conn->query("DELETE FROM class_list WHERE teacher_id = '$teacher_id' and subject_id = '$subject_id' and table_record_id = '$classrecordid'");
            if($this->conn->affected_rows > 0){
                $this->conn->query("COMMIT");
                $responseContainer['status'] = TRUE;
                $responseContainer['msg'] = "Class Successfully Removed.";
            }else{
                $this->conn->query("ROLLBACK");
                $responseContainer['status'] = FALSE;
                $responseContainer['msg'] = "Class Successfully Failed to Remove.";
            }


            return $responseContainer;


        }


        public function addClassList($parameters){
            $responseContainer = array();
            $username = $parameters['username'];
            $subject_id = $parameters['subject_id'];
            $teacher_id =  ($this->DynamicGetData("SELECT table_record_id from users WHERE UPPER(username) = UPPER('$username')", $this->conn))[0]['table_record_id'];
            

            $duplicateCheck = $this->DynamicDataCounter("SELECT table_record_id FROM class_list WHERE subject_id = '$subject_id' and teacher_id = '$teacher_id'", $this->conn);
            
            if($duplicateCheck >0){

                $responseContainer['status'] = false;
                $responseContainer['msg'] = 'Subject Already Added.';

                return $responseContainer;
            }

            
            $this->conn->query('START TRANSACTION');
            $this->conn->query("INSERT INTO class_list (teacher_id,subject_id)VALUES('$teacher_id','$subject_id')");
            if($this->conn->affected_rows > 0){
                $responseContainer['status'] = true;
                $responseContainer['msg'] = 'Subject Successfully Added to Class list.';
                $this->conn->query('COMMIT');
            }else{
                $responseContainer['status'] = false;
                $responseContainer['msg'] = 'Subject Successfully Failed to Add in List.';
                $this->conn->query('ROLLBACK');
            }


            return $responseContainer;


        }


        public function getAllFaculty($parameter){
            $result = $this->DynamicGetData("SELECT * FROM users $parameter", $this->conn);
            return $result;
        }


        public function addSubject($title,$code,$added_by){
            $responseContainer = array();
            
        
            $dupliCheck = $this->DynamicDataCounter("SELECT table_record_id from `subject` WHERE UPPER(subject_name) = '$title' OR UPPER(subject_code) = '$code'", $this->conn);
            if($dupliCheck >0){
                $responseContainer['status'] = FALSE;
                $responseContainer['msg'] = 'Subject Title or Subject Code Already Taken.';

                return $responseContainer;
            }
            $this->conn->query("START TRANSACTION");
            $this->conn->query("INSERT INTO `subject` (subject_name,subject_code,added_by)VALUES('$title','$code','$added_by')");
            if($this->conn->affected_rows > 0){
                $this->conn->query("COMMIT");
                $responseContainer['status'] = TRUE;
                $responseContainer['msg'] = 'Subject Successfully Added!.';
            }else{
                $this->conn->query("ROLLBACK");
                $responseContainer['status'] = FALSE;
                $responseContainer['msg'] = 'Unable to add Subject, please try-again.';

            }

            return $responseContainer;
        }

        public function removeSubject($record_id,$title,$code){
            $responseContainer = array();
            $this->conn->query("START TRANSACTION");
            $result = $this->conn->query("DELETE FROM subject WHERE table_record_id = '$record_id' AND subject_name = '$title' AND subject_code = '$code'");
            if($this->conn->affected_rows > 0){
                $responseContainer['status'] = TRUE;
                $responseContainer['msg'] = 'Subject Successfully Removed.';
                $this->conn->query("COMMIT");
            }else{
                $responseContainer['status'] = FALSE;
                $responseContainer['msg'] = 'Subject Successfully Failed to Remove.';
                $this->conn->query("ROLLBACK");
            }

            return $responseContainer;

        }
        
        public function getSubjectCount(){
            $result = $this->DynamicDataCounter("SELECT table_record_id FROM subject", $this->conn);
            return $result;
        }
      
        public function getAllSubjects(){
            $responseContainer = array();
            $result = $this->DynamicGetData("SELECT * FROM subject", $this->conn);
            return $result;
        }

        public function getNumberofData($parameter){
            $result = $this->DynamicDataCounter("SELECT table_record_id FROM users $parameter", $this->conn);
            return $result;
        }

        public function getAllUsers(){

            $allUsers = $this->DynamicGetData("SELECT * FROM users", $this->conn);
            if($allUsers){
                return $allUsers;
            }else{
                return false;
            }

        }


        public function loginUser($username,$password){
            $responseContainer = array();
            $loginResult = $this->conn->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
            $counter = 0;
            while ($row = $loginResult->fetch_assoc()) {
                
                $responseContainer[$counter] = $row;
                $counter++;
             }
             if($counter>0){
                return $responseContainer;
             }else{
                return false;
             }
        }


        public function removeUser($parameter){

            $this->conn->query("START TRANSACTION");
            $this->conn->query("DELETE FROM users WHERE table_record_id = '$parameter'");
            if($this->conn->affected_rows > 0){
                $this->conn->query("COMMIT");
                return true;

            }else{
                $this->conn->query("ROLLBACK");
                return false;
            }

        }

        public function addUser($parameters){
            $responseContainer = array();

            $duplicateCheck = $this->DynamicDataCounter("SELECT * FROM users WHERE username = '".$parameters['username']."'", $this->conn);
            if($duplicateCheck > 0){
                $responseContainer["status"]= false;
                $responseContainer["msg"] = "Username Already Taken, Please Try-Again";

                return $responseContainer;
            }

            $this->conn->query("START TRANSACTION");
            $qry = "INSERT INTO users (username,password,user_type,faculty_type,full_name,id_number,grade_level,device_id,added_by)VALUES('".$parameters['username']."','".$parameters['password']."', '".$parameters['usertype']."','".$parameters['facultytype']."','".$parameters['fullname']."','".$parameters['idnumber']."','".$parameters['gradelevel']."','".$parameters['deviceid']."','".$parameters['added_by']."')";
            $this->conn->query($qry);
            if($this->conn->affected_rows > 0){
                $this->conn->query("COMMIT");
                $responseContainer["status"] = true;
                $responseContainer["msg"]= "User Successfully Added.";
            }else{  
                $this->conn->query("ROLLBACK");
                $responseContainer["status"] = false;
                $responseContainer["msg"]= "User Successfully Failed to add.";
            }

            return $responseContainer;

        }


        public function DynamicDataCounter($qry,$conn){
            $qry = $conn->query($qry);
            return $qry->num_rows;
        }

        function DynamicGetData($qry, $conn){
            $responseContainer = array();
            $result = $conn->query($qry);
            $counter = 0;
            while($resRow = $result->fetch_assoc()){
                $responseContainer[$counter] = $resRow;
                $counter++;
            }

            if($counter>0){
                return $responseContainer;
            }else{
                return false;
            }

        }

    public function writeLogs($towrite){
        $writecontainer = array();
        $fp = fopen('logs/logs', 'a');//opens file in append mode 
        $writetofile = fwrite($fp, $towrite);  
        fclose($fp);

        $myfile = fopen("logs/logs", "r") or die("Unable to open file!");
        $read =  fread($myfile,filesize("logs/logs"));
        fclose($myfile);
        

        if ($writetofile) {
          $writecontainer["writestatus"] = "OK";
          $writecontainer["readlogs"] = $read;
        }
        else{
            return NULL;
        }

        return $writecontainer;

        }


}

?>
