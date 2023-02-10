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

    if (isset($_POST['btnProduct'])) {
    $page  = 1;
}

function import_sim($dbh,$start, $perpage){
    $data = array();
    $sql = "SELECT p.product_name,
                    p.price,
                    p.status_order_id,
                    s.status_name,
                    s.status_name_en
                    FROM tb_product_info p
                    LEFT JOIN
                    tb_status_order s
                    ON 
                    p.status_order_id = s.status_order_id AND
                    p.status_order_id = s.status_order_id order by product_name ASC";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        $data[] = $row;
    }
    return $data;
}

function getTotal($dbh)
{
    $sql = "SELECT COUNT(*) totalRow FROM tb_product_info p
    LEFT JOIN tb_status_order s
    ON p.status_order_id = s.status_order_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['totalRow'];
}
?>