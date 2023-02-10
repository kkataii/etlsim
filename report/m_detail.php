<?php 
    $perpage=30;
    $startdate = date('Y-m-1');
    $enddate = date('Y-m-d');
    $txtSearch ='';
    $dochktype = '';
    $txtstatus_id='';
    $txtproduct_id='';



if (isset($_POST['BtnDetail'])) {
    $startdate = isset($_POST['startdate']) ? $_POST['startdate'] :'';
    $enddate = isset($_POST['enddate']) ? $_POST['enddate'] :'';
    $txtSearch = isset($_POST['txtSearch']) ? $_POST['txtSearch'] :'';
    $txtstatus_id = isset($_POST['txtstatus_id']) ? $_POST['txtstatus_id'] :'';
    $txtproduct_id = isset($_POST['txtproduct_id']) ? $_POST['txtproduct_id'] :'';
   }

if (isset($_GET['txtmonth_id']) && $_GET['txtmonth_id'] !='') {
        $txtmonth_id = base64_decode(urldecode($_GET['txtmonth_id']));

        $enddate = date("Y-m-t", strtotime($txtmonth_id));
        $startdate = date('Y-m-d',strtotime($txtmonth_id));

        //echo "enDate = ". $enddate;
        //echo "<br>StDate = ". $startdate;

    }

if (isset($_GET['txtproduct_id']) && $_GET['txtproduct_id'] !='') {
        $txtproduct_id = base64_decode(urldecode($_GET['txtproduct_id']));
    }

if (isset($_GET['txtstatus_id']) && $_GET['txtstatus_id'] !='') {
        $txtstatus_id = base64_decode(urldecode($_GET['txtstatus_id']));
    }

if (isset($_GET['txtSearch']) && $_GET['txtSearch'] !='') {
        $txtSearch = base64_decode(urldecode($_GET['txtSearch']));
    }

if (isset($_GET['startdate']) && $_GET['startdate'] !='') {
        $startdate = base64_decode(urldecode($_GET['startdate']));
    }
    
if (isset($_GET['enddate']) && $_GET['enddate'] !='') {
        $enddate = base64_decode(urldecode($_GET['enddate']));
    }
if (isset($_GET['chktype']) && $_GET['chktype'] !='') {
        $dochktype = base64_decode(urldecode($_GET['chktype']));
    }
    $whereclause = "";

    if ($dochktype=='ready') {
        $showChk = 'ເພີ່ມ';
        if ($txtstatus_id != "") $whereclause .= " status_order_id LIKE  '%".$txtstatus_id."%' AND";
        if ($startdate != "") $whereclause .= " date_add BETWEEN  ADDDATE('".$startdate."', INTERVAL 0 HOUR) AND ADDDATE('".$enddate."', INTERVAL '23:59' HOUR_MINUTE) AND";
        if ($whereclause != "") $whereclause = " WHERE " . substr($whereclause, 0, strlen($whereclause)-4);
    }elseif ($dochktype=='booked') {
        $showChk = 'ຈອງ';
        if ($txtstatus_id != "") $whereclause .= " status_order_id LIKE  '%".$txtstatus_id."%' AND";
        if ($startdate != "") $whereclause .= " date_book BETWEEN  ADDDATE('".$startdate."', INTERVAL 0 HOUR) AND ADDDATE('".$enddate."', INTERVAL '23:59' HOUR_MINUTE) AND";
        if ($whereclause != "") $whereclause = " WHERE " . substr($whereclause, 0, strlen($whereclause)-4);
    }elseif ($dochktype=='buy') {
        $showChk = 'ຊື່';
        if ($txtstatus_id != "") $whereclause .= " status_order_id LIKE  '%".$txtstatus_id."%' AND";
        if ($startdate != "") $whereclause .= " date_buy BETWEEN  ADDDATE('".$startdate."', INTERVAL 0 HOUR) AND ADDDATE('".$enddate."', INTERVAL '23:59' HOUR_MINUTE) AND";
        if ($whereclause != "") $whereclause = " WHERE " . substr($whereclause, 0, strlen($whereclause)-4);
    }elseif ($dochktype=='Success') {
        $showChk = 'ສໍາເລັດ';
        if ($txtstatus_id != "") $whereclause .= " status_order_id LIKE  '%".$txtstatus_id."%' AND";
        if ($startdate != "") $whereclause .= " date_success BETWEEN  ADDDATE('".$startdate."', INTERVAL 0 HOUR) AND ADDDATE('".$enddate."', INTERVAL '23:59' HOUR_MINUTE) AND";
        if ($whereclause != "") $whereclause = " WHERE " . substr($whereclause, 0, strlen($whereclause)-4);
    }
    else{
        $showChk = '';
        if ($txtSearch != "") $whereclause .= " product_name LIKE  '%".$txtSearch."%' AND";
        if ($txtstatus_id != "") $whereclause .= " status_order_id LIKE  '%".$txtstatus_id."%' AND";
        if ($startdate != "") $whereclause .= " date_add BETWEEN  ADDDATE('".$startdate."', INTERVAL 0 HOUR) AND ADDDATE('".$enddate."', INTERVAL '23:59' HOUR_MINUTE) AND";
        if ($whereclause != "") $whereclause = " WHERE " . substr($whereclause, 0, strlen($whereclause)-4);
    }

       //echo $whereclause

    // ------------------------------------- PAGE ------------------------------ //

 if(isset($_GET['pagei']) && $_GET['pagei'] !=''){
        $page = $_GET['pagei'];
    }else{
        $page = 1;
    }

    if (isset($_GET['start']) && $_GET['start'] !='') {
        $start      = $_GET['start'];
    }else{
        $start      = ceil($page-1)*$perpage;
    }
    $limitclause = " LIMIT ".$start.", ".$perpage;

    if (isset($_POST['BtnDetail'])) {
    $page  = 1;

    $url="?d=report/detail&startdate=".urlencode(base64_encode($startdate))."&enddate=".urlencode(base64_encode($enddate))."&txtproduct_id=".urlencode(base64_encode($txtproduct_id))."&txtstatus_id=".urlencode(base64_encode($txtstatus_id))."&txtSearch=".urlencode(base64_encode($txtSearch))."&pagei=1&start=0";
    header("location: $url");
   }

function detailinfo($dbh, $whereclause, $limitclause){

    $data = array();
    $sql = "SELECT * FROM v_detail_product_info ".$whereclause." ORDER BY status_name DESC ". $limitclause;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        $data[] = $row;
 
    }
    return $data;
   }

function totaldetail($dbh, $whereclause){
    $sql = "SELECT count(*) totalde
    FROM v_detail_product_info ".$whereclause;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['totalde'];

}
?>