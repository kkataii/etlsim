<?php 
if(!isset($_SESSION["user_kyc_id"]) && !isset($_SESSION['user_kyc_name'])) {
    header("location: ../authorize/");
    exit();
}else{ 
	$now = time();
	if ($now > $_SESSION['setexpire_kyc_in']) {
	    echo "<script>alert('Session time Expired !');window.location='../authorize/'</script>";
	}else{

	htmltage('Change Password'); 
?>
<section>
	<h3 class="page-header text-center">
		<i class="fas fa-user-lock fa-lg " aria-hidden="true"></i>&nbsp;&nbsp;ປ່ຽນລະຫັດຜ່ານ | Change Password</h4>
 	<div class="card px-5">	
		<div class="col-12 mt-3">
			<?php 
			if(!empty($message)){ 
				echo $message; 			
			}; 
			?>
			<form action="" method="post" id="form-data" class="form-inline">
				<div class="form-group">
					ຊຶ່ຜູ້ໃຊ້ລະບົບ / UserName: <input type="text" name="username" class="form-control" value="<?=$_SESSION['user_kyc_name']?>" disabled>
				</div>
				<div class="form-group mt-3">
					ຢືນຢັນລະຫັດເກົ່າ / Confirm Old Password: <input type="password" name="old_pass" class="form-control" placeholder="ລະຫັດເກົ່າ, Confirm Old Password" required="">
				</div>
				<?php if (isset($countuser) && $countuser==0) { ?>
					<div class="alert alert-danger alert-dismissable" auto-close="5500">
						<i class="fa fa-exclamation-triangle fa-lg"></i>&nbsp;
						<strong>ລະຫັດຢືນຢັນຂອງທ່ານບໍ່ກົງກັບລະຫັດຜ່ານເກົ່າ, ລອງໃໝ່ອີກຄັ້ງ </strong>
					</div>
				<?php	} ?>
				<div class="form-group mt-3">
					ປ້ອນລະຫັດໃໝ່ / New Password: <input type="password" name="new_pass" class="form-control" id="new_pass" placeholder="ລະຫັດໃໝ່, New Password" onkeyup="getNewpass(this)">
				</div>
				<div class="form-group text-center mt-3 mb-3">
					<input type="hidden" name="user_id" value="<?= $_SESSION['user_kyc_id'] ?>">
					<input type="hidden" name="user_name" value="<?= $_SESSION['user_kyc_name'] ?>">
					<input type="submit" name="changepass" id="changepass" value="Change Password" class="btn btn-primary btn-inline-block" disabled>
				</div>
			</form>
		</div>
	</div>
</section>
<script>
	function getNewpass(new_pass) {
        var bt = document.getElementById('changepass');
        if (new_pass.value != '') {
            bt.disabled = false;
        }
        else {
            bt.disabled = true;
        }
    }
</script>

<?php }} ?>