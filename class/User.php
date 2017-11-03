<?php
class User extends PHPMailer{
    public $conn;
	function init() {
		$conn = new mysqli('localhost', 'root', '', 'test-project');
		if (!$conn) {
			 die('MySQL Connection Error (' . mysqli_connect_errno() . ') '
				 . mysqli_connect_error());
		}
		return $conn;
	}

	//**************************************************** register
    function register($post){
        if ($conn === null) {
            $conn = $this->init();
        }
        $password = base64_encode($post['password']);
        $actCode = $this->getActivationCode();
        $sqlL = "INSERT INTO `user` (`name`, `email`, `password`, `active`, `actCode`) VALUES 
		('".$post['name']."', '".$post['email']."', '".$password."', '0' , '".$actCode."' );";

        if ($conn->query($sqlL) === TRUE) {
            $uId = $conn->insert_id;
            $this->sendEmail($actCode,$uId,$post);
            return true;
        }
    }
    //**************************************************** send mail
    function sendEmail($actCode,$uId,$post){
        $mail                = new PHPMailer();
        $body = "Hello Dear ".$post['name']."<br> Thank you for signing up! <br><br> Please verify Your Email Address by clicking the link below.<br><br>";
        $body .= "<a href='http://localhost/test-project/index.php?id=".$uId."&actCode=".$actCode."' target='_blank' >Confirm your acount</a>";

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host          = "smtp.mailtrap.io";
        $mail->SMTPAuth      = true;                  // enable SMTP authentication
        $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
        $mail->Host          = "smtp.mailtrap.io"; // sets the SMTP server
        $mail->Port          = 2525;                    // set the SMTP port for the GMAIL server
        $mail->Username      = "7335824103782b"; // SMTP account username
        $mail->Password      = "f3c6b3d669e695";        // SMTP account password
        $mail->SetFrom('shirani.elahe@gmail.com', 'List manager');
        $mail->AddReplyTo('shirani.elahe@gmail.com', 'List manager');

        $mail->Subject       = "Activation code !";

        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        $mail->MsgHTML($body);
        $mail->AddAddress( $post['email'], $post['name']);

        if(!$mail->Send()) {
            echo "Mailer Error (" . str_replace("@", "&#64;", $post['email']) . ') ' . $mail->ErrorInfo . '<br />';
        } else {
            echo "Message sent to :" . $post['name'] . ' (' . str_replace("@", "&#64;", $post['email']) . ')<br />';
        }
        // Clear all addresses and attachments for next loop
        $mail->ClearAddresses();
        $mail->ClearAttachments();
    }

    //**************************************************** activation code
    function getActivationCode(){
        $activationCode = base64_encode(microtime());
        return $activationCode;
    }
    //**************************************************** check act code
    function checkActivationCode($actCode,$uId){
        if ($conn === null) {
            $conn = $this->init();
        }
        $sql1= "select actCode from user where id = '$uId' and actCode = '$actCode' " ;
        $result = $conn->query($sql1);
        if($result->num_rows > 0){
            $sql2 = "UPDATE user SET active='1' WHERE id='$uId'";
            if ($conn->query($sql2) === TRUE) {
                $isOk = 1;
                $msg = 'Your account has been activated successfully. You can now login.';
            } else {
                $isOk = 0;
                $msg = 'Activating your acount have problem fix it.';
            }
            return array($isOk,$msg);

        }
        else
            return false;
    }

    //**************************************************** check email
    function checkRegisterEmail($email){
        if ($conn === null) {
            $conn = $this->init();
        }
        $query = "select email from user where email = '$email'" ;
        $result = $conn->query($query);
        if($result->num_rows > 0)
            return true;
        else
            return false;
    }
    //**************************************************** check login user
    function checkLoginUser($post){
        if ($conn === null) {
        $conn = $this->init();
        }
        $password = base64_encode($post['password']);
        $query = "select * from user where email = '".$post['email']."' and password = '".$password."'" ;
        $result = $conn->query($query);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) {
                if($row["active"]=='1'){
                    $_SESSION['userId'] = $row["id"];
                    header('Location: http://localhost/test-project/dashboard.php');
                }
                else{
                    $isOk = 0;
                    $msg = 'Please activate your account to start using our services!!';
                    return array($isOk,$msg);
                }
            }
        }
        else{
            $isOk = 0;
            $msg = 'Please register first !!';
            return array($isOk,$msg);
        }

    }
    //****************************************************
    function getTodolists($userId){
        if ($conn === null) {
            $conn = $this->init();
        }
        $query = "SELECT * FROM `todolist` where userId = '$userId' ORDER By Id" ;

        $result = $conn->query($query);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) {
                $allRows[] = $row;
            }
            return $allRows;
        }
    }
    //****************************************************
    function checkHaveTask($tId){
        if ($conn === null) {
            $conn = $this->init();
        }
        $query = "SELECT id FROM `task` where parentId='".$tId."'" ;
        $result = $conn->query($query);
        if($result->num_rows > 0)
            return true;
        else
            return false;
    }
    //****************************************************
    function checkAllTaskStatus($tId,$statusCheck){
        if ($conn === null) {
            $conn = $this->init();
        }
        $query = "SELECT status FROM `task` where parentId='".$tId."'" ;
        $result = $conn->query($query);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) {
                if($row['status']!=$statusCheck)
                    return false;
            }
            if($statusCheck==2)
                return "Done";
            else
                return "Cancel";
        }
        else
            return "nothing";
    }
    //****************************************************
    function getstatus($status){
        if($status==1)
            $text = 'New' ;
        if($status==2)
            $text = 'Done' ;
        if($status==3)
            $text = 'Cancel' ;
        return $text;
    }

    //**************************************************** delete to do
    function deleteTodo($tId){
        if ($conn === null) {
            $conn = $this->init();
        }
        $sql = "DELETE FROM todolist WHERE id='".$tId."'";
        if ($conn->query($sql) === TRUE)
            $resAct= array(1,'Your todolist deleted successfully .');
         else
            $resAct= array(0,'delete todolist have problem !!');

         return $resAct;
    }
    //****************************************************
    function getTasks($tId){
        if ($conn === null) {
            $conn = $this->init();
        }
        $query = "SELECT * FROM `task` where parentId = '".$tId."'" ;
        $result = $conn->query($query);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) {
                $allRows[] = $row;
            }
            return $allRows;
        }
    }
    //**************************************************** delete task
    function deleteTask($taskId){
        if ($conn === null) {
            $conn = $this->init();
        }
        $sql = "DELETE FROM task WHERE id='".$taskId."'";
        if ($conn->query($sql) === TRUE) {
            $resAct= array(1,'Your task deleted successfully . ');
        } else {
            $resAct= array(0,'delete task have problem !!');
        }
        return $resAct;
    }
    //**************************************************** edit task
    function editTask($taskId,$status){
        if ($conn === null) {
            $conn = $this->init();
        }
        $sql = "UPDATE task SET status='$status' WHERE id='$taskId'";
        if ($conn->query($sql) === TRUE) {
            $resAct= array(1,'Your task edited successfully . ');
        } else {
            $resAct= array(0,'edit task have problem !!');
        }
        return $resAct;
    }
    //**************************************************** method result
    function resMethod($isOk,$msg){
        if($isOk==1)
            echo '<div class="alert alert-success" role="alert">'.$msg.'</div>';
        else if($isOk==0)
            echo '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
    }

    //************************************************* validation register
    function validationRegister($name,$email,$password){
        if($name=='' || $email=='' || $password=='')
            $resAct= array(0,'Filling all field is requiered !');
        else{
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                $resAct= array(0,'Invalid email format !');
            else{
                $resEmail = $this->checkRegisterEmail($email);
                if($resEmail)
                    $resAct= array(0,'Your Email registered befor !!');
                else{
                    $res = $this->register($_POST);
                    if($res)
                        $resAct= array(1,'your info registered successfully . please check your email address to activate your acount.');
                    else
                        $resAct= array(0,'register user have problem !!');
                }
            }
        }
        return $resAct;
    }
    //************************************************* validation login
    function validationLogin(){
        if($_POST['email']=='' || $_POST['password']=='')
            $resAct= array(0,'Filling all field is requiered !');
        else {
            $email = $_POST["email"];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $resAct= array(0,'Invalid email format !');
            } else {
                $resAct = $this->checkLoginUser($_POST);
            }
        }
        return $resAct;
    }

    //*************************************************
    function getTodolistStatus($todo){
        $todoStatus = $this->checkAllTaskStatus($todo['id'],2);
        if($todoStatus!="Done"){
            $todoStatus = $this->checkAllTaskStatus($todo['id'],3);
            if($todoStatus!="Cancel")
                $txtstatus = $this->getstatus($todo['status']);
            else
                $txtstatus = $todoStatus;
        }
        else
            $txtstatus = $todoStatus;

        return $txtstatus;
    }







} 
?>