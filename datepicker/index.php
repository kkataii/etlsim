<?php 
if(!isset($_SESSION["user_id"]) && !isset($_SESSION['user_name'])) {
    header("location: ../authorize/");
    exit();
}else{ 
	$now = time();
	if ($now > $_SESSION['expire']) {
	    echo "<script>alert('Session time Expired !');window.location='authorize/'</script>";
	}else{
		header("location: ../index.php");
	}
}
 ?>