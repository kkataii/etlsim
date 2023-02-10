<?php 
if(!isset($_SESSION["user_kyc_id"]) && !isset($_SESSION['user_kyc_name'])) {
    header("location: ../authorize/");
    exit();
}else{ 
	$now = time();
	if ($now > $_SESSION['setexpire_kyc_in']) {
	    echo "<script>alert('Session time Expired !');window.location='authorize/'</script>";
	}else{
		header("location: ../index.php");
	}
}
 ?>