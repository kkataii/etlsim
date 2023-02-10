<?php
 $detailinfo = detailinfo($dbh, $whereclause, $limitclause); 
$totaldetail=totaldetail($dbh, $whereclause);
//print_r($detailinfo);
//echo $txtstatus_id;
?>
<section>
<tbody>
	<h3 style="text-align: center;"><i class="fa fa-book"></i>&nbsp;ລາຍລະອຽດ&nbsp;<i class="fa fa-book"></i></h3>
<div class="container">
    <div class="col col-sm-12">
            <div class="panel-body">
                <form action="?d=report/detail" method="post" class="form-inline" id="validateForm">
                    <div class="row g-3">
                        
                        <div class="col-4 form-group">
                            <input type="text" placeholder="ເບີ" name="txtSearch" id="txtSearch" class="form-control" value="<?php 
                            if(isset($_POST['txtSearch'])){ echo $_POST['txtSearch']; 
                            }elseif(isset($_GET['txtSearch'])){ echo base64_decode(urldecode($_GET['txtSearch'])); 
                            }else{ echo $txtSearch; } ?>" >
                        </div>
                        <div class="col-4 form-group">
                            <input type="text" name="startdate" id="startdate" class="form-control" placeholder="Start Date" value="<?php 
                            if(isset($_POST['startdate'])){ echo $_POST['startdate']; 
                            }elseif(isset($_GET['startdate'])){echo base64_decode(urldecode($_GET['startdate']));
                            }else{ echo $startdate;} ?>">
                        </div>
                        <div class="col-4 form-group">
                            <input type="text" name="enddate" id="enddate" class="form-control" placeholder="End Date" value="<?php 
                            if(isset($_POST['enddate'])){ echo $_POST['enddate']; 
                            }elseif(isset($_GET['enddate'])){echo base64_decode(urldecode($_GET['enddate']));
                            }else{ echo $enddate;} ?>">
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-4" align="right">
                            <input type="submit" name="BtnDetail" value="ຄົ້ນຫາ" class="btn btn-primary right mx-12">
                        </div>
                        <div class="col-4" align="center">
                            <button type="reset" class="btn btn-danger center mx-12" onclick="document.location='?d=report/detail'">Refresh
                            </button>
                        </div>
                    
                </form>
                <?php if($totaldetail>0){  ?>
                <div class="col-4" align="left">
                        <form action="excel_report/excel_detail.php" method="post" target="_blank"> 
                            <input type="hidden" name="txtSearch" value="<?php if(isset($_POST['txtSearch'])){ echo urlencode(base64_encode($_POST['txtSearch'])); }elseif(isset($_GET['txtSearch'])){echo $_GET['txtSearch']; }else{ echo urlencode(base64_encode($txtSearch));} ?>">

                            <input type="hidden" name="startdate" value="<?php if(isset($_POST['startdate'])){ echo urlencode(base64_encode($_POST['startdate'])); }elseif(isset($_GET['startdate'])){echo $_GET['startdate']; }else{ echo urlencode(base64_encode($startdate));} ?>">

                            <input type="hidden" name="enddate" value="<?php if(isset($_POST['enddate'])){ echo urlencode(base64_encode($_POST['enddate'])); }elseif(isset($_GET['enddate'])){echo $_GET['enddate']; }else{ echo urlencode(base64_encode($enddate));} ?>">

                            <input type="hidden" name="chktype" id="chktype" value="<?php if(isset($_POST['chktype'])){ echo urlencode(base64_encode($_POST['chktype'])); }elseif(isset($_GET['chktype'])){echo $_GET['chktype']; }else{ echo urlencode(base64_encode($chktype));} ?>">

                            <input type="submit"  name="btsExcel" class="btn btn-success left mx-10"  value="ດາວໂຫລດ" >
                        </form>
                </div>
            </div>
                 <?php } ?>
            </div>
        </div>
    </div><br>
<div class="table-responsive">
<table class="table table-striped table-sm table-bordered" style="text-align : center;">
     <thead class="table table-hover" style="text-align:center;">
                    <th>ລຳດັບ</th>
                    <th>ເບີ</th>
                    <th>ປະເພດເບີ</th>
                    <th>ລາຄາ</th>
                    <th>ຊື່ສະຖານະ</th>
                    <?php 
                        if (isset($txtstatus_id) && $txtstatus_id==1) {
                            echo "<th> ວັນທີ ".$showChk ."</th>";
                        }elseif (isset($txtstatus_id) && $txtstatus_id==2) {
                            echo "<th> ວັນທີ ".$showChk . "</th>";
                        }elseif (isset($txtstatus_id) && $txtstatus_id==3) {
                            echo "<th> ວັນທີ ".$showChk . "</th>";
                        }elseif (isset($txtstatus_id) && $txtstatus_id==4) {
                            echo "<th> ວັນທີ ".$showChk . "</th>";
                        }else{ ?>

                        <th>ວັນທີ ເພີ່ມ</th>
                        <th>ວັນທີ ຈອງ</th>
                        <th>ວັນທີ ຊື້</th>
                        <th>ວັນທີ ສໍາເລັດ</th>
                    <?php
                        }
                    ?> 
                </thead> 
        <tbody> 
            <?php $i=0; foreach ($detailinfo as $row) { $i++;?>
                        <tr>
                           <td nowrap="nowrap"> <?php echo $i; ?> </td>
                        <td nowrap="nowrap"><?php echo $row["product_name"]; ?> </td>
                        <td nowrap="nowrap"><?php echo $row["type_name"]; ?> </td>
                        <td nowrap="nowrap"><?php echo $row["price"]; ?> </td>
                        <td nowrap="nowrap"><?php echo $row["status_name"]; ?> </td>
                        
                            <?php 
                            if (isset($txtstatus_id) && $txtstatus_id==1) {
                                echo "<td nowrap='nowrap'>".$row['date_add'] ."</td>";
                            }elseif (isset($txtstatus_id) && $txtstatus_id==2) {
                                echo "<td nowrap='nowrap'>".$row['date_book'] . "</td>";
                            }elseif (isset($txtstatus_id) && $txtstatus_id==3) {
                                echo "<td nowrap='nowrap'>".$row['date_buy'] . "</td>";
                            }elseif (isset($txtstatus_id) && $txtstatus_id==4) {
                                echo "<td nowrap='nowrap'>".$row['date_success'] . "</td>";
                            }else{ ?>

                            <td><?php echo $row["date_add"]; ?></td>
                            <td><?php echo $row["date_book"]; ?></td>
                            <td><?php echo $row["date_buy"]; ?></td>
                            <td><?php echo $row["date_success"]; ?></td>
                            <?php
                            }
                            ?> 
                        
                        </tr>
                         <?php  } ?>
                </tbody>

</table>
<?php 
            include('phppagination.php');
                $url="report/detail&startdate=".urlencode(base64_encode($startdate))."&enddate=".urlencode(base64_encode($enddate))."&txtproduct_id=".urlencode(base64_encode($txtproduct_id))."&txtstatus_id=".urlencode(base64_encode($txtstatus_id))."&txtSearch=".urlencode(base64_encode($txtSearch))."&";

                $pagei = (int) (!isset($_POST["pagei"]) ? 1 : $_POST["pagei"]);
                    echo pagination($totaldetail, $perpage ,$page, $url);
                
        ?>
</div>