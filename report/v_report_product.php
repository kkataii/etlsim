<?php
$product_info=product_info($dbh,$txtSearchPD,$start, $perpage);
?>

<section>
<tbody>
	<h3 style="text-align: center;"><i class="fa fa-book"></i>&nbsp;ລາຍງານສິນຄ້າ&nbsp;<i class="fa fa-book"></i></h3><br>
<div class="container">
    <div class="col col-sm-12">
            <div class="panel-body">
                <form action="?d=report/detail" method="post" class="form-inline" id="validateForm">
                    <div class="row g-4">
                        <div class="col-3 form-group">
                            <input type="text" placeholder="ເບີ" name="txtSearchPD" id="txtSearchPD" class="form-control" value="<?php 
                            if(isset($_POST['txtSearchPD'])){ echo $_POST['txtSearchPD']; 
                            }elseif(isset($_GET['txtSearchPD'])){ echo base64_decode(urldecode($_GET['txtSearchPD'])); 
                            }else{ echo $txtSearchPD; } ?>" >
                        </div>
                        <div class="col-3 form-group">
                            <button type="submit" name="btnproduct" class="btn btn-primary right mx-12">ຄົ້ນຫາ</button>&nbsp;
                        </div>
                        <div class="col-3 form-group" align="left">
                            <button type="reset" class="btn btn-danger center mx-10" onclick="document.location='?d=report/report_product'">Refresh</button>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div><br>
<div class="table-responsive">
    <table class="table" style="text-align : center;">
        <thead class="table" style="text-align:center"> 
            <tr>
                <th>ລຳດັບ</th>
                <th>ປະເພດເບີ</th>
                <th>ເບີ</th>
                <th>ລາຄາ</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 1;
                foreach($product_info AS $row)
            ?>
            <tr>
                <td nowrap="nowrap"> <?php echo $i; ?> </td>
                <td nowrap="nowrap"><?php echo $row["type_name"]; ?> </td>
                <td nowrap="nowrap"><?php echo $row["product_name"]; ?> </td>
                <td nowrap="nowrap"><?php echo $row["price"]; ?> </td>
            </tr>
        </tbody>
    </table>
</div>