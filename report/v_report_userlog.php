<?php 
if(!isset($_SESSION["user_kyc_id"]) && !isset($_SESSION['user_kyc_name'])) {
    header("location: ../authorize/");
    exit();
}else{ 
    $now = time();
    if ($now > $_SESSION['setexpire_kyc_in']) {
        echo "<script>alert('Session time Expired !');window.location='../authorize/'</script>";
    }else{
        htmltage('Manage Users'); 

    $resultUser = getUsers($dbh, $start, $perpage);
    $totalUserweb = getUsersTotal($dbh);
 //print_r($resultUser);
 ?>
<!DOCTYPE html>
    <html lang="en">
    <h3 style="text-align: center;"><i class="fa fa-sign-in"></i>&nbsp;User Login</h3>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>user_log</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="table-responsive">
        <div class="card-body">
            <div class="table-report">
             
                <table class="table table-striped table-sm table-bordered">
                
                   <thead class="table table-striped" style="text-align:center;">
                        <th scope="col">ລຳດັບ</th>
                        <th scope="col">ໄອດີ</th>
                        <th scope="col">ຜູ້ໃຊ້</th>
                        <th scope="col">ບັນທືກການເຂົ້າ-ອອກ</th>
                        <th scope="col">ສະຖານະ</th>
                        <th scope="col">ວັນທີ</th>          
                    </thead>
            </div>
        </div>
                    <tbody>
                         <?php $i=0; foreach ($resultUser as $row) { $i++;?>
                        <tr style="text-align:center;">
                            <td nowrap="nowrap"><?= $i ?></td>
                            <td nowrap="nowrap"><?= $row['user_id'] ?></td>
                            <td nowrap="nowrap"><?= $row['role_name'] ?></td>
                            <td nowrap="nowrap"><?= $row['actionlog'] ?></td>
                            <td nowrap="nowrap"><?= $row['status_name'] ?></td>
                            <td nowrap="nowrap"><?= $row['date_time'] ?></td>               
                        </tr>
                        <?php } ?>         
                    </tbody>
                </table>
                
        </div>
    </body>
        </html>
        <?php }} ?>