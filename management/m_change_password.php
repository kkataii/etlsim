<?php 
if(!isset($_SESSION["user_kyc_id"]) && !isset($_SESSION['user_kyc_name'])) {
    header("location: ../authorize/");
    exit();
}else{ 
	$now = time();
	if ($now > $_SESSION['setexpire_kyc_in']) {
	    echo "<script>alert('Session time Expired !');window.location='../authorize/'</script>";
	}else{
		if(isset($_POST['changepass'])){	

			$getUserID  = $_POST["user_id"];
			$txtusername= $_POST["user_name"];
			$getOldpass = $_POST["old_pass"];
			$getNewpass = $_POST['new_pass'];

			$newHashpass= $txtusername."".$getNewpass;
    		$chngpwdhash = hash("sha256", $newHashpass);

    		$chkOldHashpasswd = $txtusername."".$getOldpass;
    		$chkOldpasswd = hash("sha256", $chkOldHashpasswd);

			$sqlchk = "SELECT user_id, user_password FROM tb_user_info
			WHERE user_id= :getUserID AND user_password= :chkOldpasswd ";
			$stmt = $dbh->prepare($sqlchk);
			$stmt->bindParam(':getUserID', $getUserID);
			$stmt->bindParam(':chkOldpasswd', $chkOldpasswd);
			$stmt->execute();
			//$rowuser = $stmt->fetch(PDO::FETCH_ASSOC);
			$countuser = $stmt->rowCount();

			//echo '<br />test user login :'. $userID .'--> '.$userType. 'count :'. $countuser;
			
			if ($countuser ==1) {

				$sqlupdate = "UPDATE tb_user_info SET user_password= :chngpwdhash 
				WHERE user_id= :getUserID";
				$stmt = $dbh->prepare($sqlupdate);
				$stmt->bindParam(':chngpwdhash', $chngpwdhash);
				$stmt->bindParam(':getUserID', $getUserID);
				$result = $stmt->execute();

				if ($stmt->rowCount() >0) {
					$message = '<div class="alert alert-success alert-dismissable" role="alert" auto-close="4500" id="alert_success">
						<i class="fa fa-smile-o fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;ທ່ານໄດ້ປ່ຽນລະຫັດຜ່ານສໍາເລັດຮຽບຮ້ອຍແລ້ວ</div>'; 
				?>

					<script>
						setTimeout(function(){window.location.replace("authorize/logout.php");}, 4500);
					</script>	
			<?php				
				 }else{
					
					$message = '
					<div class="alert alert-danger alert-dismissable" role="alert" auto-close="4500">
						<i class="fa fa-smile-o fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;ປ່ຽນລະຫັດຜ່ານຫຼົ້ນແຫຼວ, ແນະນໍາໃຫ້ໃສ່ລະຫັດຜ່ານໃໝ່ເລື້ອຍໆ
					</div>';			
				}
			}
		}
	}
}
 ?>