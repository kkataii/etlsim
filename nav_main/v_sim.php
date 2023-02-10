<?php
$product=product($dbh,$start, $perpage);
?>
<section>
	<header class="w3-container w3-padding-10 w3-center w3-text-blue" style="text-align:center">
    <p></p>
    <img src="etlSIM.jpg" width="100%">
     </header> <br>
<div class="table-responsive">
    <table class="table" style="text-align : center;">
        <thead class="table" id="mytable" style="text-align:center"> 
            <tr>
                <th>ລຳດັບ</th>
                <th>ເບີ</th>
                <th>ລາຄາ</th>
                <th>ສະຖານະ</th>
                <th>Option</th>

            </tr>
        </thead>
        <tbody>
            <?php
                $i = 1;
                foreach($product AS $row)
            ?>
            <tr>
                <td nowrap="nowrap"> <?php echo $i; ?> </td>
                <td nowrap="nowrap"><?php echo $row["product_name"]; ?> </td>
                <td nowrap="nowrap"><?php echo $row["price"]; ?> </td>
                <td nowrap="nowrap"><?php echo $row["status_name"]; ?> </td>
                <td nowrap="nowrap">
                    <button type="submit" class="btn btn-primary">Add to cart
                    <i class="fas fa-shopping-cart"></i></button>
                
                </td>
            </tr>
        </tbody>
    </table>
<!-- Add New Group Modal -->
<div class="modal fade" id="addModalTS">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                 </div>
                <h4 class="modal-title text-center">Add to cart</h4>
                <!-- Modal body -->
                <div class="modal-body px-4">
                    <form action="" method="post" id="frm_add_TS">
                        <div class="form-group">
                            <label>number</label>
                            <input type="text" name="txt_group_id" class="form-control"  placeholder="20" required="" >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
</section>
