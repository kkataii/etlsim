<?php 
require_once('../config/connect_db.php');

function getRealIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) // CHECK IP FROM SHARE INTERNET
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  //  TO  CHECK IP IS PASS FROM PROXY
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$txtusername ='';
if(isset($_POST['btnLogin'])){

    
    $message = "";
    $txtusername = isset($_POST['txtusername']) ? trim($_POST['txtusername']) : "";
    $txtpassword = isset($_POST['password']) ? trim($_POST['password']) : "";
    $UserKey = isset($_POST['UserKeyWord']) ? $_POST['UserKeyWord'] : "";
    
        $KeyWord = $_SESSION['captcha_code'];
            // $KeyWord = $_SESSION['code'];
            //Addslashes to user input and create variable from it
        $UserKeyWord = addslashes($_POST['UserKeyWord']);
            //Check User Input Against KeyWord Picked
        if(strcmp($UserKeyWord, $KeyWord) == 0)
        {

            $newHashpass= $txtusername."".$txtpassword;
            $pwdhash = hash("sha256", $newHashpass);


            $qry = "SELECT u.user_id, u.user_name, u.user_password, u.first_name, 
            u.last_name,u.user_des, u.status_id, u.role_id, s.role_name 
            FROM tb_user_info u 
            INNER JOIN tb_sysrole s ON s.role_id = u.role_id 
            WHERE 1=1 AND u.status_id=1
            AND u.role_id IN (1,2)
            AND u.expire_date >= now()
            AND u.user_name = :user_name 
            AND u.user_password = :user_password ";
            //echo $qry;
            $stmt = $dbh->prepare($qry);
            $res = $stmt->execute([':user_name' => $txtusername, ':user_password' => $pwdhash]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
            if($count > 0)
            {

                $_SESSION['setexpire_kyc_in']  = time()+3600;  // 3600= 1 hours
                $_SESSION['user_kyc_id']    = $row['user_id'];
                $_SESSION['user_kyc_name']  = $row['user_name'];
                $_SESSION['user_kyc_password'] = $row['user_password'];
                $_SESSION['user_kyc_fullname'] = $row['first_name']." ".$row['last_name'];
                $_SESSION['user_kyc_des']   = $row['user_des'];
                $_SESSION['role_kyc_id']    = $row['role_id'];
                $_SESSION['role_kyc_name']  = $row['role_name'];
                $_SESSION['status_kyc_id']   = $row['status_id'];
                /*------- add to user log-----------*/
                $ClientIP= getRealIpAddr();
                $action  = 'login';
                //session_write_close();

                $SQLlog = "INSERT INTO tb_user_log_info (user_id, role_id, status_id, ipaddress, actionlog, date_time) 
                VALUES(:loguser_id, :logrole_id, :logstatus_id, :logClientIP, :logaction, now())";
                $stmtlg = $dbh->prepare($SQLlog);
                $stmtlg->execute(array(
                    ':loguser_id'  => $_SESSION['user_kyc_id'],
                    ':logrole_id'  => $_SESSION['role_kyc_id'],
                    ':logstatus_id'=> $_SESSION['status_kyc_id'],
                    ':logClientIP' => $ClientIP,
                    ':logaction'   => $action
                ));
                if($stmtlg->rowCount()>0){
                    header('location: ../?d=index');       
                    exit(); 
                }
                
            }
            else
            {
                $message = '<div class="alert alert-danger alert-dismissable" role="alert" auto-close="4500" id="alert_danger">
                &nbsp;<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>
                 Username, password, expired, No permision 
                </div>';
            }
        }
        else
        {
            $message = '<div class="alert alert-danger alert-dismissable" role="alert" auto-close="4500" id="alert_danger">
            &nbsp;&nbsp;<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i> >>> &nbsp;&nbsp;
            Captcha is incorrect 
            </div>';
        }
}elseif (isset($_SESSION['setexpire_kyc_in']) && $_SESSION['setexpire_kyc_in'] > time()) {
    header('location: ../?d=index');       
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN SHOPPING ONLINE</title>
    <link rel="stylesheet" href="./assets/css/style-with-prefix.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <style>
        .logo{
          background-image:url("assets/images/logo.png");
          background-repeat: no-repeat;
          width:140px;
          height:69px;
          margin: auto;
          padding: 20px;
          margin-bottom: 20px;
        }
        h3{margin: 0 auto; padding-bottom: 20px;}
        .alert-danger{
            font-size: 1em;
            padding: 2px;
        }
  </style>
</head>
<body>
    <div class="main-container" style="height: 100vh;">
        <div class="form-container">
            <div class="form-body">
                <?php if(!empty($message)){ echo $message; } ?>
                <div class="logo"></div>
                <h3 align="center">SHOPPING</h3>
                <form action="" method="post" class="the-form">
                    <label for="txtusername">User Name</label>
                    <input type="text" name="txtusername" id="txtusername" placeholder="Enter your User Name" required value="<?php if (isset($_POST['txtusername'])){echo $_POST['txtusername'];}elseif(isset($_GET['txtusername'])){echo $_GET['txtusername']; }else{echo "";} ?>" autofocus>
                    <label for="id_password">Password</label>
                    <input type="password" name="password" id="id_password" placeholder="Enter your password" autocomplete="on" required autofocus>
                    <i class="far fa-eye" id="togglePassword"></i>
                    <div class="social-login">
                        <ul>
                            <li class="captcha">
                                <img src="captcha/captcha.php?rand=<?php echo rand(); ?>" id='captcha_image'>
                            </li>
                            <li class="freshcaptcha">
                                <a  href='javascript: refreshCaptcha();'>Refresh</a>
                            </li>
                        </ul>
                    </div>
                    <input type="text" name="UserKeyWord" placeholder="Enter Captcha" required="" autofocus>
                    <input type="submit" name="btnLogin" value="SIGN IN" class="sign-up">
                </form>
            </div><!-- FORM BODY-->
        </div><!-- FORM CONTAINER -->
    </div>
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
$(document).ready(function(){
// modal auto close
    $(function() {
      var alert = $('div.alert[auto-close]');
      alert.each(function() {
        var that = $(this);
        var time_period = that.attr('auto-close');
        setTimeout(function() {
          that.alert('close');
        }, time_period);
      });
    });
});
//Refresh Captcha
function refreshCaptcha(){
    var img = document.images['captcha_image'];
    img.src = img.src.substring(
        0,img.src.lastIndexOf("?")
        )+"?rand="+Math.random()*1000;
}
const showPassword = document.querySelector('#togglePassword');
const passwordField = document.querySelector('#id_password');

    showPassword.addEventListener('click', function (e) {
        
        // toggle the type attribute
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
});
</script>