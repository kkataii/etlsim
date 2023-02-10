<?php 
include "../config/connect_db.php";


//view info province 
   if(isset($_POST['view_prov'])){
    $view_prov = $_POST['view_prov'];
    $row = showProvInfo($dbh, $view_prov);
    echo json_encode($row);
    }
// show province
 function showProvInfo($dbh,$view_prov){
    $sql = "SELECT 
    p.province_id, 
    p.prov_name_la,
    p.prov_name_en,
    p.status_id,
    n.status_name
    FROM tb_province p 
    LEFT JOIN tb_status_info n ON p.status_id = n.status_id
    WHERE p.province_id = :view_prov";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':view_prov', $view_prov);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } 


if (isset($_POST['edit_prov'])) {

    $edit_prov = $_POST['edit_prov'];

    $row = selectProvEdit($dbh, $edit_prov);
    echo json_encode($row);
    }
function selectProvEdit($dbh,$edit_prov){
     $sql = " SELECT 
    p.province_id, 
    p.prov_name_la,
    p.prov_name_en
    FROM tb_province p WHERE p.province_id= :edit_prov ";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([':edit_prov'  => $edit_prov]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

//update edit prov

    if(isset($_POST['prov']) && $_POST['prov'] == "Update_prov"){
    $edit_name_la = isset($_POST['edit_name_la']) ? $_POST['edit_name_la'] : "";
    $edit_user_add = isset($_POST['edit_user_add']) ? $_POST['edit_user_add'] : "";
    $edit_name_en = isset($_POST['edit_name_en']) ? $_POST['edit_name_en'] : "";

    $row = Update_prov($dbh,$edit_name_la,$edit_name_en,$edit_user_add);
    echo json_encode($row);

     try{
        $dbh->beginTransaction();

        $rsaultUpdate = Update_prov($dbh,$edit_name_la,$edit_name_en,$edit_user_add);   
          
        echo json_encode($rsaultUpdate);

        $dbh->commit();
    }catch(Exception $e){
        $dbh->rollback();
        echo "Failed ". $e->getMessage();
    }
}
//update prov

    function Update_prov($dbh,$edit_name_la,$edit_name_en,$edit_user_add){
        $sql = "UPDATE tb_province SET  prov_name_la   = :edit_name_la,
                                        
                                        prov_name_en   = :edit_name_en
        WHERE   prov_name_la  =  :edit_name_la";

        $stmt = $dbh->prepare($sql);
        $stmt->execute([
        ':edit_name_la' => $edit_name_la,
        ':edit_user_add' => $edit_user_add,
        ':edit_name_en' => $edit_name_en

         ]);
        return $stmt->rowCount();
    }

//delete district
 if(isset($_POST['Delete_prov'])){
    $Delete_prov = $_POST['Delete_prov'];
    try{
    $dbh->beginTransaction();
        $rowAf = DeleteUserKycInfo($dbh, $Delete_prov);
        echo json_encode($rowAf);
    $dbh->commit();
    }catch(Exception $e){
        $dbh->rollback();
        echo "Failed ". $e->getMessage();
    }
    }
//delete prov
    function DeleteUserKycInfo($dbh, $Delete_prov){
    $sql = "DELETE FROM tb_province WHERE province_id= :Delete_prov";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':Delete_prov' => $Delete_prov));
    return $stmt->rowCount();
    }

//view district_info
    if(isset($_POST['view_dist_info'])){
    $view_dist_info = $_POST['view_dist_info'];
    $row = Showdistinfo($dbh, $view_dist_info);
    echo json_encode($row);
    }

//show district
    function Showdistinfo($dbh, $view_dist_info){
    $sql = "SELECT 
    p.province_id, 
    p.prov_name_la, 
    p.prov_name_en, 
    d.district_id, 
    d.dist_name_la, 
    d.dist_name_en 
    FROM tb_district d 
    LEFT JOIN tb_province p ON d.province_id=p.province_id
    WHERE d.district_id= :view_dist_info ";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':view_dist_info', $view_dist_info);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
    }

// function_edit
    if (isset($_POST['edit_dist'])) {

    $edit_dist = $_POST['edit_dist'];

    $row = selectdist($dbh, $edit_dist);
    echo json_encode($row);
    }
    function selectdist($dbh,$edit_dist){
        $sql = " SELECT 
        p.province_id, 
        p.prov_name_la, 
        p.prov_name_en, 
        d.district_id, 
        d.dist_name_la,
        d.dist_name_en,
        s.status_name 
    FROM tb_district d 
        LEFT JOIN tb_province p ON d.province_id=p.province_id
        LEFT JOIN tb_status_info s ON s.status_id=d.status_id
        WHERE d.district_id = :edit_dist ";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([':edit_dist'  => $edit_dist]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

//update edit District

     if(isset($_POST['dist']) && $_POST['dist'] == "Update_dist"){
    $edit_prov_id = isset($_POST['edit_prov_id']) ? $_POST['edit_prov_id'] : "";    
    $edit_name_lao = isset($_POST['edit_name_lao']) ? $_POST['edit_name_lao'] : "";
    $edit_name_eng = isset($_POST['edit_name_eng']) ? $_POST['edit_name_eng'] : "";
    $edit_dist_id = isset($_POST['edit_dist_id']) ? $_POST['edit_dist_id'] : "";
    $edit_dist_la = isset($_POST['edit_dist_la']) ? $_POST['edit_dist_la'] : "";
    $edit_dist_en = isset($_POST['edit_dist_en']) ? $_POST['edit_dist_en'] : "";

    $row = Update_dist($dbh,$edit_prov_id,$edit_name_lao,$edit_name_eng,$edit_dist_id,$edit_dist_la,$edit_dist_en);
    echo json_encode($row);
    }

//update dist

     function Update_dist($dbh,$edit_prov_id,$edit_name_lao,$edit_name_eng,$edit_dist_id,$edit_dist_la,$edit_dist_en){
        $sql = "UPDATE tb_district SET  province_id    = :edit_prov_id,
                                        district_id    = :edit_dist_id,
                                        dist_name_la   = :edit_dist_la,
                                        dist_name_en   = :edit_dist_en
                WHERE province_id  =  :edit_prov_id";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
        ':edit_prov_id'  => $edit_prov_id,    
        ':edit_name_lao' => $edit_name_lao,
        ':edit_name_eng' => $edit_name_eng,
        ':edit_dist_id'  => $edit_dist_id,
        ':edit_dist_la'  => $edit_dist_la,
        ':edit_dist_en'  => $edit_dist_en
         ]);
        return $stmt->rowCount();
    }

// delete dist 

    if(isset($_POST['Delete_dist'])){
        $Delete_dist = $_POST['Delete_dist'];
      try{
    $dbh->beginTransaction();
        $rowAf = DeletedistcInfo($dbh, $Delete_dist);
        echo json_encode($rowAf);
    $dbh->commit();
    }catch(Exception $e){
        $dbh->rollback();
        echo "Failed ". $e->getMessage();
    }
    }
//delete prov
    function DeletedistcInfo($dbh, $Delete_dist){
    $sql = "DELETE FROM tb_district WHERE province_id= :Delete_dist";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':Delete_dist' => $Delete_dist));
    return $stmt->rowCount();
    }


//view Village info 
   if(isset($_POST['view_vill'])){
    $view_vill = $_POST['view_vill'];
    $row = showvillInfo($dbh, $view_vill);
    echo json_encode($row);
    }
// show Village info
 function showvillInfo($dbh,$view_vill){
    $sql = "SELECT 
        v.village_id, 
        v.vill_name_en,
        v.vill_name_la,
        v.status_id,
        v.district_id,
        v.province_id,
        s.status_name,
        p.prov_name_la,
        p.prov_name_en,
        d.dist_name_la,
        d.dist_name_en
    FROM tb_village v
        LEFT JOIN tb_status_info s  ON v.status_id   = s.status_id
        LEFT JOIN tb_district d     ON v.district_id = d.district_id
        LEFT JOIN tb_province p     ON v.province_id = p.province_id
    WHERE v.village_id = :view_vill";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':view_vill', $view_vill);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } 



//add district

if(isset($_POST['district']) && $_POST['district'] == "add_new_dist"){
    $txtDistLa = isset($_POST['txtDistLa']) ? $_POST['txtDistLa'] : "";
    $txtDistEn = isset($_POST['txtDistEn']) ? $_POST['txtDistEn'] : "";
    $row = insertNewDist($dbh,$txtDistLa,$txtDistEn);
    echo json_encode($row);
    }

 function insertNewDist($dbh,$txtDistLa,$txtDistEn){
        $sql = "INSERT INTO tb_district (dist_name_la,dist_name_en) 
        VALUES (:txtDistLa, :txtDistEn)";
         $stmt = $dbh->prepare($sql);
         $dbh->query('SeT foreign_key_checks=0');
         $stmt->execute([
        ':txtDistLa'        => $txtDistLa,
        ':txtDistEn'        => $txtDistEn,
        
          ]);
          $dbh->query('SeT foreign_key_checks=1');
          return $stmt->rowCount();
    } 