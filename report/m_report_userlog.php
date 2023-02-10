<?php 
if(!isset($_SESSION["user_kyc_id"]) && !isset($_SESSION['actionlog'])) {
    header("location: ../authorize/");
    exit();
}else{ 

	$now = time();
	if ($now > $_SESSION['setexpire_kyc_in']) {
	    echo "<script>alert('Session time Expired !');window.location='../authorize/'</script>";
	}else{

   $perpage=50;

	if(isset($_GET['pagei']) && $_GET['pagei'] !=''){
	    $page = $_GET['pagei'];
	}else{
	    $page = 1;
	}

	if (isset($_GET['start']) && $_GET['start'] !='') {
		$start 		= $_GET['start'];
	}else{
		$start 		= ceil($page-1)*$perpage;
	}
	
	if(isset($_GET["pagei"])){
	    $page = ceil($_GET["pagei"]);
	}else{
	    $page  = 1;
	}

function getUsers($dbh, $start, $perpage)
{
	$data = array();
	$sql = "SELECT u.user_id,
		u.status_id,
		s.status_name,
		u.actionlog,
		u.date_time,
		u.role_id,
		m.role_name 
	FROM tb_user_log_info u 
	LEFT JOIN tb_status_info s ON u.status_id=s.status_id
	LEFT JOIN tb_sysrole m ON u.role_id=m.role_id
	ORDER BY date_time DESC LIMIT $start, $perpage ";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row){
		$data[] = $row;
	}
	return $data;
}

function getUsersTotal($dbh){
	$sql = "SELECT COUNT(*) totalRow FROM tb_user_log_info u
	LEFT JOIN tb_status_info s
    ON u.status_id = s.status_id";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	return $result['totalRow'];
}

}}

