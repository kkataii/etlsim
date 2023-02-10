<?php 
include "../config/connect_db.php";


if (isset($_POST['edit_sim'])) {

    $edit_sim = $_POST['edit_sim'];

    $row = selectsimEdit($dbh, $edit_sim);
    echo json_encode($row);
    }
function selectsimEdit($dbh,$edit_sim){
     $sql = " SELECT 
    p.product_id,
    p.product_name,
    p.price
    FROM tb_product_info p WHERE p.product_name= :edit_sim ";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([':edit_sim'  => $edit_sim]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

/*====================Edit Sim ====================*/
 if(isset($_POST['etlsim']) && $_POST['etlsim'] == "Update_sim"){
    $edit_product_id = isset($_POST['edit_product_id']) ? $_POST['edit_product_id'] : "";
    $edit_product_name = isset($_POST['edit_product_name']) ? $_POST['edit_product_name'] : "";
    $edit_price = isset($_POST['edit_price']) ? $_POST['edit_price'] : "";
    
    $row = Update_import_sim($dbh,$edit_product_id,$edit_product_name,$edit_price);
    echo json_encode($row);    
}

/*====================update Sim ====================*/
  function Update_import_sim($dbh,$edit_product_id,$edit_product_name,$edit_price){
        $sql = "UPDATE tb_product_info SET  product_id   = :edit_product_id,
                                            product_name   = :edit_product_name,
                                            price = :edit_price
                                            WHERE product_name=:edit_product_name";

        $stmt = $dbh->prepare($sql);
        $stmt->execute([':edit_product_id' => $edit_product_id,
                        ':edit_product_name' => $edit_product_name,
                        ':edit_price' => $edit_price]);
        return $stmt->rowCount();
    }

//*====================cart====================*/
 if(isset($_GET["cartItem"]) && isset($_GET["cartItem"])=="cart_item") {     
    $select_stmt=$db->prepare("SELECT * FROM tb_product_info");     
    $select_stmt->execute();    
    $row=$select_stmt->rowCount();  
    echo $row;}




/*====================Delete sim====================*/
 if(isset($_POST['Delete_sim'])){
    $Delete_sim = $_POST['Delete_sim'];
    try{
    $dbh->beginTransaction();
        $rowAf = DeleteUserKycInfo($dbh, $Delete_sim);
        echo json_encode($rowAf);
    $dbh->commit();
    }catch(Exception $e){
        $dbh->rollback();
        echo "Failed ". $e->getMessage();
    }
    }
//Delete sim
    function DeleteUserKycInfo($dbh, $Delete_sim){
    $sql = "DELETE FROM tb_product_info WHERE product_name= :Delete_sim";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':Delete_sim' => $Delete_sim));
    return $stmt->rowCount();
    }






 ?>