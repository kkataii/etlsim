$(document).ready(function(){
$.ajaxSetup({ cache: false }); 


$("#saveupdatesim").click(function(e){
    if($("#frm_sim")[0].checkValidity()){
      e.preventDefault();
      Swal.fire({
        title: 'Do you want to save the changes ?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: 'Do not Save',
      }).then((result)=>{
        if (result.isConfirmed) {
          $.ajax({
            url:"function/function_sim.php",
            type:"POST",
            data:$("#frm_sim").serialize()+"&etlsim=Update_sim",
            success:function(response){
              //console.log(response);
              //let iconEdBR='';
              //let dataEdBR='';
                if(response > 0){
                  iconEdBR='success';
                  dataEdBR='Update Successfully Affected rows '+response;
                }else{
                  iconEdBR='error'; 
                  dataEdBR='failed to update Affected rows '+response;
                }
              Swal.fire({
                   title: "Result Response Update :",
                   text: dataEdBR,
                   icon: iconEdBR, 
                  //timer: 2000,
                 showCloseButton: true,
              })
            }
          });
        }else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info')
          $("#editModalsim").on('hidden.bs.modal', function(e){
            $(".modal-body").html("");
            $("#frm_sim")[0].reset();
          })            
          setTimeout(function() {
            location.reload();
          },2000);
        }
      });
      $("#editModalsim").on('hidden.bs.modal', function(e){
        $(".modal-body").html("");
        })
    }
  });

/*====================Select Edit sim ====================*/
 $("body").on("click",".btnEditsim", function(e){
  //console.log("working!");
    e.preventDefault();
    edit_sim = $(this).attr('id');
    $.ajaxSetup ({cache: false});
    $.ajax({
      url:"function/function_sim.php",
      type:"POST",
      data:{edit_sim:edit_sim},
      ache: true,
      success:function(response){

        data = JSON.parse(response);

        //console.log(data);
        $("#edit_product_id").val(data.product_id);
        $("#edit_product_name").val(data.product_name);
        $("#edit_price").val(data.price);
      }
    });
      /*$("#editModalsim").on('hidden.bs.modal', function(e){
      //$("#frm_sim")[0].reset();
    });*/
    });
/******************** END PART  ****************/
});
