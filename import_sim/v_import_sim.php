<?php
$import_sim=import_sim($dbh,$start, $perpage);
$getTotal=getTotal($dbh);

 ?>
<div class="panel panel-default">
    <div class="panel-body">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="row g-12 justify-end">
          		<div class="col-sm-6" align="center">
						<input type="file" name="excel" required="" align="center" class="form-control float-left mx-3" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
					</div>
					<div class="col-sm-6">
						<input type="submit" name="import" value="import" class="btn btn-primary dropdown-toggle"  >
					</div>
					<!-- <div class="col-sm-3">
 						<a href="v_mycart.php" class="btn btn-outline-success">my cart</a>
 						
					</div> -->
				</div>
			</form>
		</div>
	</div>
		<hr>

	<div class="card-body">
		 <table class="table table-hover" style="font-size: 1rem; ">
        <thead class="table" style="text-align:center"> 
					<tr>
						<td>No</td>
						<td>number</td>
						<td>pice</td>
						<td>status</td>
						<td>Edit</td>
				
					</tr>
				</thead>
	</div>	
			<tbody style="text-align:center">
				<?php $i=0; foreach ($import_sim as $row) { $i++;?>
				<tr>
				
					<td> <?php echo $i; ?> </td>
					<td> <?php echo $row["product_name"]; ?> </td>
					<td> <?php echo $row["price"]; ?> </td>
					<td> <?php echo $row["status_name_en"]; ?> </td>
					<td>
						<button type="button" class="btn btn-outline-primary btnEditsim"  data-bs-toggle="modal" 
							data-bs-target="#editModalsim" id="<?=$row['product_name']?>">
            				<i class="fas fa-edit fa-lg"></i>
            			</button>


					</td>
				</tr>
				 <?php } ?>
			</tbody>
		</table>

		<?php
		if(isset($_POST["import"])){
			$filenumber = $_FILES["excel"]["name"];
			$fileExtension = explode('.', $filenumber);
      		$fileExtension = strtolower(end($fileExtension));
			$newfilenumber= date("Y.m.d")."." . $fileExtension;

			$targetDirectory = "uploads/" . $newfilenumber;
			move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

			error_reporting(0);
			ini_set('display_errors', 0);

			require 'excel/excel_reader2.php';
			require 'excel/SpreadsheetReader.php';

			$data_import = new SpreadsheetReader($targetDirectory);
			foreach($data_import as $key => $row){
				$product_name = $row[0];
				$price = (int)$row[1];
				$status_id = $row[2];
				
				$sql = "INSERT INTO tb_product_info (product_name,price,status_order_id) VALUES (:product_name, :price, :status_id)";
				$stmt = $dbh->prepare($sql);
				$stmt->execute([':product_name'=>$product_name, ':price'=>$price, ':status_id'=>$status_id]);
			}
			
			echo
			"
			<script>
			alert('Succesfully Imported');
			document.location.href = '';
			</script>
			";
		}
		?>

<!-- Edit sim Modal -->
<div class="modal fade" id="editModalsim">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            	<h4 class="modal-title text-center" >ແກ້ໄຂເບີ</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="border:none;background: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body px-4">
                <form action="" method="post" id="frm_sim">
                    <div class="form-group mt-3">
                        <label class="col-md-6 control-label">ແກ້ໄຂເບີ</label>
                        <input type="text" name="edit_product_name" id="edit_product_name" value="" class="form-control" placeholder="ເບີ" required="">
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-md-6 control-label">ແກ້ໄຂລາຄາ</label>
                        <input type="text"  name="edit_price" id="edit_price" value="" class="form-control" placeholder="ລາຄາ" required="">
                    </div>
                    <div class="row g-12 mt-3">    
                    <div class="col-6" align="right">
                        <input type="submit"name="saveupdatesim" id="saveupdatesim" value="Save" class="btn btn-primary" style="width:40%;"  
                        >   
                    </div>
                    <div class="col-6" align="left">
				     		<button type="button" class="btn btn-warning" data-bs-dismiss="modal" style="width:40%;">Close</button>
				       	</div>
                </div>
                </form>
            </div>
        </div>
	</div>
</div>