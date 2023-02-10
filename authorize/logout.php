<?php
include('../config/connect_db.php');

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

if (isset($_POST['action']) && $_POST['action']=='getmeout' || isset($_SESSION['user_id']) || $_GET['logout_id']) {

    $logClientIP= getRealIpAddr();
    $logaction  = "logout";
    $resltLogout= 0;

    try{

        if ($_POST['logout_id']) {

            $loguser_id     = $_POST['logout_id'];
            $logrole_id = isset($_SESSION['role_id']) ? $_SESSION['role_id'] :'';
            $logstatus_id = isset($_SESSION['status_id']) ? $_SESSION['status_id'] :'';

            $resltLogout =  syslogout($dbh, $loguser_id, $logrole_id, $logstatus_id, $logClientIP, $logaction);

        }elseif (isset($_GET['logout_id'])) {
            $loguser_id     = $_GET['logout_id'];
            $logrole_id = isset($_SESSION['role_id']) ? $_SESSION['role_id'] :'';
            $logstatus_id = isset($_SESSION['status_id']) ? $_SESSION['status_id'] :'';

            $resltLogout =  syslogout($dbh, $loguser_id, $logrole_id, $logstatus_id, $logClientIP, $logaction);
        }else{

            $loguser_id     = $_SESSION['user_id'];
            $logrole_id = isset($_SESSION['role_id']) ? $_SESSION['role_id'] :'';
            $logstatus_id = isset($_SESSION['status_id']) ? $_SESSION['status_id'] :'';
            
            $resltLogout =  syslogout($dbh, $loguser_id, $logrole_id, $logstatus_id, $logClientIP, $logaction);
        }
       

        if ($resltLogout >0) {
            session_set_cookie_params(0, $_SERVER['DOCUMENT_ROOT'].'/refillcard/');
            session_unset();
            unset($_SESSION['expire']);
            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_password']);
            unset($_SESSION['user_fullname']);
            unset($_SESSION['user_des']);
            unset($_SESSION['role_id']);
            unset($_SESSION['role_name']);
            unset($_SESSION['token']);
            unset($_SESSION['setexpire_in']);

            //unset all cookies 1h ago
            if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    setcookie($name, '', time()-3600);
                    setcookie($name, '', time()-3600, '/');
                }
            }
            session_destroy();

            header('location:../?d=index');
            
            die();
        }else{
            die( print_r( mysql_errors(), true));
        }
        
    } catch (PDOException $e) {
        echo "Connection failed: ".$e->getMessage();
    }
    
}else{
    
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-3600);
            setcookie($name, '', time()-3600, '/');
        }
    }
    session_destroy();
    header("location: ../?d=index");
}

function syslogout($dbh, $loguser_id, $logrole_id, $logstatus_id, $logClientIP, $logaction){
    $sqlogout = "INSERT INTO tb_user_log_info (user_id, role_id, status_id, ipaddress, actionlog, date_time) 
    VALUES (:loguser_id, :logrole_id, :logstatus_id, :logClientIP, :logaction, now())";
    $stmt = $dbh->prepare($sqlogout);
    $stmt->execute([
        ':loguser_id'  => $user_id,
        ':logrole_id'  => $txtRole_id,
        ':logstatus_id'=> $txtState_id,
        ':logClientIP' => $ClientIP,
        ':logaction'   => $action
    ]);
    
    return $stmt->rowCount();
}
$dbh= null;
?>