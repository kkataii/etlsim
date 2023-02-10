 <?php 
    $product_DT=product_DT($dbh,$search_product,$monthpicker,$start, $perpage);
    $totalaProduct=totalaProduct($dbh,$search_product,$monthpicker);
    //print_r($product_DT);
 ?>
 <head> 
        <meta charset="utf-8">
        <title>Report</title>    
    </head> 
                    
<section>
    <h3 style="text-align" class="page-header"><i class="fa fa-signal fa-lg"></i>&nbsp;&nbsp;Report order&nbsp; </h3>

                   
       <div class="panel panel-default">
            <div class="panel-body">
                <form action="?d=report/sum_product" method="post" class="form-inline" id="validateForm" >
                    <div class="row g-4 mt-2">
                        <div class="col-3 mt-2">   
                            <input type="text" class="form-control" name="search_product" placeholder="ຊື່ສະຖານະ" value="<?php if(isset($_POST['search_product'])){ echo $_POST['search_product']; }elseif(isset($_GET['search_product'])){ echo base64_decode(urldecode($_GET['search_product'])); }else{ echo $search_product; } ?>" >                
                        </div>
                        <div class="col-3 mt-2" >
                            <input type="text" name="monthpicker" id="monthpicker" class="form-control" value="<?php 
                                if(isset($_POST['monthpicker'])){
                                    echo $_POST['monthpicker'];
                                }elseif(isset($_GET['monthpicker'])){ 
                                    echo base64_decode(urldecode($_GET['monthpicker'])); 
                                }else{ echo $monthpicker;}?>" />
                        </div>
                        <div class="col-3 mt-2" >
                            <button type="submit" name="btnOrder" class="btn btn-primary right mx-12">ຄົ້ນຫາ</button>&nbsp;
                        </div>
                        <div class="col-3 mt-2" align="left">
                            <button type="reset" class="btn btn-danger center mx-10" onclick="document.location='?d=report/sum_product'">Refresh</button>
                        </div>
                    </div>
                </form>
                <?php if($totalaProduct>0){  ?>
                <div class="col-3 mt-2" align="center">
                        <form action="excel_report/excel_sum_product.php" method="post" target="_blank"> 
                            <input type="hidden" name="search_product" value="<?php if(isset($_POST['search_product'])){ echo urlencode(base64_encode($_POST['search_product'])); }elseif(isset($_GET['search_product'])){echo $_GET['search_product']; }else{ echo urlencode(base64_encode($search_product));} ?>">
                            <input type="hidden" name="monthpicker" value="<?php if(isset($_POST['monthpicker'])){ echo urlencode(base64_encode($_POST['monthpicker'])); }elseif(isset($_GET['monthpicker'])){echo $_GET['monthpicker']; }else{ echo urlencode(base64_encode($monthpicker));} ?>">
                            <input type="submit"  name="btnPD" class="btn btn-success left mx-10"  value="ດາວໂຫລດ" >
                        </form>
                </div>
                 <?php } ?>
            </div>
        </div>

        <div class="table-responsive">
             <?php if(isset($totalaProduct) && $totalaProduct > 0){ ?>
            <table class="table" style="text-align : center;">
                <caption style="caption-side: top"> 
                    <?php      
                        if(isset($totalaProduct) && $totalaProduct>($perpage*$page)){
                            $endperpage=$perpage*$page;
                        }else{
                            $endperpage=$totalaProduct;
                            }
                        ?>
                        ລວມທັງໝົດມີ 
                        <?= number_format($totalaProduct) ?>
                        ລາຍການ, ສະແດງລາຍການທີ
                        <?= number_format($start+1) ?>
                        ຫາ 
                        <?= number_format($endperpage) ?>
                </caption>
                <thead class="table" style="text-align:center"> 
                    <tr>
                        <th>ລຳດັບ</th>
                        <th>ຊື່ສະຖານະ</th>
                        <th>ປະເພດເບີ</th>
                        <th>ພ້ອມຂາຍ</th>
                        <th>ຈອງ</th>
                        <th>ຊື້</th>
                        <th>ສຳເລັດການຂາຍ</th>
                    </tr>
                </thead>
                <tbody style="text-align:center">
                    <?php
                        $i = 1;
                        foreach($product_DT AS $row){
                    ?>
                    <tr>
                        <td nowrap="nowrap"> <?php echo $i++; ?> </td>
                        <td nowrap="nowrap"><?php echo $row["status_name"]; ?> </td>
                        <td nowrap="nowrap"><?php echo $row["type_name"]; ?> </td> 
                        <td nowrap="nowrap">
                            <?php
                                if(isset($row['ready_to_sell']) && $row['ready_to_sell'] >0){ ?>
                                <a  href='?d=report/detail&txtstatus_id=<?php echo urlencode(base64_encode(1));?>&txtmonth_id=<?php echo urlencode(base64_encode($row['monthly'])); ?>&chktype=<?php echo urlencode(base64_encode('ready')); ?>'><?php echo $row['ready_to_sell']; ?>
                                </a>
                                <?php }else{
                            echo $row['ready_to_sell'];
                            }
                            ?>

                        </td>
                        <td nowrap="nowrap">
                            <?php
                                if(isset($row['booked']) && $row['booked'] >0){ ?>
                                <a  href='?d=report/detail&txtstatus_id=<?php echo urlencode(base64_encode(2));?>&txtmonth_id=<?php echo urlencode(base64_encode($row['monthly'])); ?>&chktype=<?php echo urlencode(base64_encode('booked')); ?>'><?php echo $row['booked']; ?>
                                </a>
                                <?php }else{
                            echo $row['booked'];
                            }
                            ?>  

                        </td>
                        <td nowrap="nowrap">
                            <?php
                                if(isset($row['saled']) && $row['saled'] >0){ ?>
                                <a  href='?d=report/detail&txtstatus_id=<?php echo urlencode(base64_encode(3));?>&txtmonth_id=<?php echo urlencode(base64_encode($row['monthly'])); ?>&chktype=<?php echo urlencode(base64_encode('buy')); ?>'><?php echo $row['saled']; ?>
                                </a>
                                <?php }else{
                            echo $row['saled'];
                            }
                            ?>                      

                        </td>
                        <td nowrap="nowrap">
                            <?php
                                if(isset($row['Success']) && $row['Success'] >0){ ?>
                                <a  href='?d=report/detail&txtstatus_id=<?php echo urlencode(base64_encode(4));?>&txtmonth_id=<?php echo urlencode(base64_encode($row['monthly'])); ?>&chktype=<?php echo urlencode(base64_encode('Success')); ?>'><?php echo $row['Success']; ?>
                                </a>
                                <?php }else{
                            echo $row['Success'];
                            }
                            ?>

                        </td>
                    </tr>
                    <?php } ?> 
            </tbody>
    </table>
    <?php 
            include('phppagination.php');
            $url="?d=report/sum_product&search_product=".urlencode(base64_encode($search_product))."&monthpicker=".urlencode(base64_encode($monthpicker))."&";
            $pagei = (int) (!isset($_POST["pagei"]) ? 1 : $_POST["pagei"]);
            echo pagination($totalaProduct, $perpage ,$page, $url);
                 }else{
                        echo '<h3 class="text-center text-secondary mt-5">:( Not found any information here !</h3>';
                       }
               ?>  
   
        </div>
</section>