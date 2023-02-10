<?php 
    $perpage=30;
    $search_product = '';
    $monthpicker = '';

   if (isset($_POST['btnOrder'])) {
    $search_product = isset($_POST['search_product']) ? $_POST['search_product'] :'';
    $monthpicker = isset($_POST['monthpicker']) ? $_POST['monthpicker'] :'';
    }
     if (isset($_GET['search_product']) && $_GET['search_product'] !='') {
        $search_product = base64_decode(urldecode($_GET['search_product']));
    }
    if (isset($_GET['monthpicker']) && $_GET['monthpicker'] !='') {
        $monthpicker = base64_decode(urldecode($_GET['monthpicker']));
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

    if (isset($_POST['btnProduct'])) {
    $page  = 1;

    $url="?d=report/sum_product&search_product=".urlencode(base64_encode($search_product))."&monthpicker=".urlencode(base64_encode($monthpicker))."&pagei=1&start=0";
    header("location: $url");
   }

function product_DT($dbh,$search_product,$monthpicker,$start, $perpage){
    $data = array();
    $sql = "SELECT * FROM v_sum_product_info v   
        WHERE v.status_name LIKE :search_product
        AND v.monthly LIKE :monthpicker";
    $stmt = $dbh->prepare($sql);
    $txtValm = '%'. $monthpicker .'%';
    $txtu = '%'. $search_product .'%';
    $stmt->execute([':search_product' =>$txtu, 
                    ':monthpicker'=>$txtValm ]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        $data[] = $row;
    }
    return $data;
    }

function totalaProduct($dbh,$search_product,$monthpicker){
    $sql = "SELECT COUNT(*) totalPD FROM v_sum_product_info v 
        WHERE v.status_name LIKE :search_product
        AND v.monthly LIKE :monthpicker";
    $stmt = $dbh->prepare($sql);
    $txtValm = '%'. $monthpicker .'%';
    $txtu = '%'. $search_product .'%';
    $stmt->execute([':search_product' =>$txtu, 
                    ':monthpicker'=>$txtValm]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['totalPD'];

}
    