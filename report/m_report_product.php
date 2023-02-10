<?php 
    $perpage=30;
    $txtSearchPD ='';

    if (isset($_POST['btnproduct'])) {
    $txtSearchPD = isset($_POST['txtSearchPD']) ? $_POST['txtSearchPD'] :'';
    }
    if (isset($_GET['txtSearchPD']) && $_GET['txtSearchPD'] !='') {
        $txtSearchPD = base64_decode(urldecode($_GET['txtSearchPD']));
    }

if(isset($_GET["pagei"])){
        $page = ceil($_GET["pagei"]);
    }else{
        $page  = 1;
    }

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

function product_info($dbh,$txtSearchPD,$start, $perpage){
    $data = array();
    $sql = "SELECT * FROM v_detail_product_info v   
        WHERE v.status_name LIKE :txtSearchPD";
    $stmt = $dbh->prepare($sql);
    $txtu = '%'. $txtSearchPD .'%';
    $stmt->execute([':txtSearchPD' =>$txtu]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        $data[] = $row;
    }
    return $data;
    }
?>

