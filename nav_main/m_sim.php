<?php 
    $perpage=30;

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

function product($dbh,$start, $perpage){
    $data = array();
    $sql = "SELECT p.ids,
    p.product_name,
    p.price,
    p.status_order_id,
    s.status_name
FROM tb_product_info p
    LEFT JOIN
    tb_status_info s
ON 
    p.status_order_id = s.status_id AND
p.status_order_id = s.status_id order by date_add ASC";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['']);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        $data[] = $row;
    }
    return $data;
    }
?>