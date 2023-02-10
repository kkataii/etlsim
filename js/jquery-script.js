$(document).ready(function(){
//$.ajaxSetup({ cache: false }); 
//view prov
    $("body").on("click",".view_province", function(e){
    e.preventDefault();
    view_prov = $(this).attr('id');
    $.ajax({
      url:"controllers/prov_info.php",
      type:"POST",
      data:{view_prov:view_prov},
      success:function(response){
        //console.log(response);
        data = JSON.parse(response);
        console.log(data);
        let UserstatusColor= '';
        if (data['status_id'] == 5) {
          UserstatusColor="#1E8449"; /*Display GREEN */
        }else{
          UserstatusColor="#F00";   // Display RED 
        }
        
        Swal.fire({

          title:'<h3>Detail Of province  : '+data['province_id']+' </h3>',
          type:'info',
          icon:'info',
          width: 650,
          padding: '1em',
          html:
           '<div class="table-responsive"><table class="table table-striped" style="font-size:16px;"><tr align="left"><td style="font-weight:bold">Province_info</td><td>'
           +data['province_id']+
          '</td></tr><tr align="left"><td style="font-weight:bold">ແຂວງ</td><td>'
           +data['prov_name_la']+
          '</td></tr><tr align="left"><td style="font-weight:bold">Province</td><td>'
          +data['prov_name_en']+
          '</td></tr><tr align="left"><td style="font-weight:bold">ສະຖານະ</td><td>'
          +data['status_name']+
          '</td></tr></table>',
          showCancelButton: false,
          showCloseButton: true,
          //allowOutsideClick: false,
          allowEscapeKey: false,

        });
        $("#ProvModal").modal('hide');
      }
    });
  });

//save province_info 
    $("#saveupdateprov").click(function(e){
    if($("#frm_prov")[0].checkValidity()){
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
            url:"controllers/prov_info.php",
            type:"POST",
            data:$("#frm_prov").serialize()+"&prov=Update_prov",
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
          $("#editModalprov_info").on('hidden.bs.modal', function(e){
            $(".modal-body").html("");
            $("#frm_prov")[0].reset();
          })            
          setTimeout(function() {
            location.reload();
          },2000);
        }
      });
    }
  });


// select Edit province_info
    $("body").on("click",".btnEditprov", function(e){
    //alert("working!");
    e.preventDefault();
    edit_prov = $(this).attr('id');
    //$.ajaxSetup ({cache: false});
    $.ajax({
      url:"controllers/prov_info.php",
      type:"POST",
      data:{edit_prov:edit_prov},
      //ache: true,
      success:function(response){

        data = JSON.parse(response);

        console.log(data);

        $("#edit_name_la").val(data.prov_name_la);
        $("#edit_name_en").val(data.prov_name_en);
      }
    });
      $("#editModalprov_info").on('hidden.bs.modal', function(e){
      //$("#frm_prov")[0].reset();
    });
    });
// Delete province
    $("body").on("click",".DeleteBtnprov", function(e){
    e.preventDefault();
    var tr = $(this).closest('tr');
    Delete_prov = $(this).attr('id');
    Swal.fire({
        title: 'ທ່ານແນ່ໃຈແລ້ວບໍ ?',
        text: "ທ່ານຈະບໍ່ສາມາດກູ້ຂໍ້ມູນທີ່ຖືກລົບກັບມາໄດ້ອີກ !",
        // icon: 'warning',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ຍົກເລີກ',
        confirmButtonText: 'ຕົກລົງ'
    }).then((result) => {
        if (result.value) {
          $.ajax({
            url:"controllers/prov_info.php",
            type:"POST",
            data:{Delete_prov:Delete_prov},
            success:function(response){
              data = JSON.parse(response);
              //console.log(data);
              tr.css('background-color','#ff6666');
              let colorResDelU='';
              let datadele='';
              if(data>0){
                colorResDelU='success';
                datadele='Delete Successfully Affected rows '+ data;
              }else{
                colorResDelU='error'; 
                datadele='failed to delete records '+ data;
              }
              Swal.fire(
                  'Your Action Result:',
                   datadele, //'ທ່ານໄດ້ລົບຈໍານວນໜຶ່ງທ່ານຜູ້ໃຊ້ລະບົບອອກຈາກຖານຂໍ້ມູນແລ້ວ.',
                   colorResDelU //'success'
              )
            //location.reload();
              setTimeout(function() {
              location.reload();
            },2000);
            }
          });
        }
    });
  });
// Show dist Info 
    $("body").on("click",".view_dist", function(e){
    e.preventDefault();
    view_dist_info = $(this).attr('id');
    $.ajax({
      url:"controllers/prov_info.php",
      type:"POST",
      data:{view_dist_info:view_dist_info},
      success:function(response){
        //console.log(response);
        data = JSON.parse(response);
        //console.log(data[0].district_id);

        let UserstatusColor= '';
        if (data['status_id'] == 5) {
          UserstatusColor="#1E8449"; /*Display GREEN */
        }else{
          UserstatusColor="#F00";   // Display RED 
        }
        
        Swal.fire({

          title:'<h3>Detail Of district  : '+data['province_id']+' </h3>',
          type:'info',
          icon:'info',
          width: 650,
          padding: '1em',
          html:
          '<table class="table table-striped" style="font-size:16px;"><tr align="left"><td style="font-weight:bold">ລະຫັດແຂວງ</td><td>'
          +data['province_id']+
          '</td></tr><tr align="left"><td style="font-weight:bold">ແຂວງ</td><td>'
          +data['prov_name_la']+
          '</td></tr><tr align="left"><td style="font-weight:bold">province</td><td>'
          +data['prov_name_en']+
          '</td></tr><tr align="left"><td style="font-weight:bold">ລະຫັດເມືອງ</td><td>'
          +data['district_id']+ 
          '</td></tr><tr align="left"><td style="font-weight:bold">ເມືອງ</td><td>'
          +data['dist_name_la']+
          '</td></tr><tr align="left"><td style="font-weight:bold">district</td><td>'
          +data['dist_name_en']+
          '</td></tr></table>',
          showCancelButton: false,
          showCloseButton: true,
          //allowOutsideClick: false,
          allowEscapeKey: false,

        });
        $("#ShowdistModal").modal('hide');
      }
    });
  });

//Edit district_info 

    $("#Save_district").click(function(e){
    if($("frm_dist")[0].checkValidity()){
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
            url:"controllers/prov_info.php",
            type:"POST",
            data:$("#frm_dist").serialize()+"&dist=Update_dist",
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
          $("#EditdistModal").on('hidden.bs.modal', function(e){
            $(".modal-body").html("");
            $("frm_dist")[0].reset();
          }) 
            $("#EditdistModal").on('hidden.bs.modal', function(e){
            $(".modal-body").html("");
            })         
          setTimeout(function() {
            location.reload();
          },2000);
        }
      });
    }
  });

// select Edit district_info 

    $("body").on("click",".btnEditdist", function(e){
    e.preventDefault();
    edit_dist = $(this).attr('id');
    $.ajax({
      url:"controllers/prov_info.php",
      type:"POST",
      //cache: false,
      data:{edit_dist:edit_dist},
      success:function(response){
        //console.log(response);
        data = JSON.parse(response);
        
        console.log(data);

        $("#edit_prov_id").val(data.province_id);
        $("#edit_prov_lao").val(data.prov_name_la);
        $("#edit_prov_eng").val(data.prov_name_en);
        $("#edit_dist_id").val(data.district_id);
        $("#edit_dist_la").val(data.dist_name_la);
        $("#dist_name_en").val(data.dist_name_en); 
      }
    });
    $("#EditdistModal").on('hidden.bs.modal', function(e){
      //$("#frm-edit-dist")[0].reset();
    });
  });

// Delete province
    $("body").on("click",".DeleteDist", function(e){
    e.preventDefault();
    var tr = $(this).closest('tr');
    Delete_dist = $(this).attr('id');
    Swal.fire({
        title: 'ທ່ານແນ່ໃຈແລ້ວບໍ ?',
        text: "ທ່ານຈະບໍ່ສາມາດກູ້ຂໍ້ມູນທີ່ຖືກລົບກັບມາໄດ້ອີກ !",
        // icon: 'warning',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ຍົກເລີກ',
        confirmButtonText: 'ຕົກລົງ'
    }).then((result) => {
        if (result.value) {
          $.ajax({
            url:"controllers/prov_info.php",
            type:"POST",
            data:{Delete_dist:Delete_dist},
            success:function(response){
              data = JSON.parse(response);
              //console.log(data);
              tr.css('background-color','#ff6666');
              let colorResDelU='';
              let datadele='';
              if(data>0){
                colorResDelU='success';
                datadele='Delete Successfully Affected rows '+ data;
              }else{
                colorResDelU='error'; 
                datadele='failed to delete records '+ data;
              }
              Swal.fire(
                  'Your Action Result:',
                   datadele, //'ທ່ານໄດ້ລົບຈໍານວນໜຶ່ງທ່ານຜູ້ໃຊ້ລະບົບອອກຈາກຖານຂໍ້ມູນແລ້ວ.',
                   colorResDelU //'success'
              )
            //location.reload();
              setTimeout(function() {
              location.reload();
            },2000);
            }
          });
        }
    });
  });

// Show village Info 
    $("body").on("click",".view_village", function(e){
    e.preventDefault();
    view_vill = $(this).attr('id');
    $.ajax({
      url:"controllers/prov_info.php",
      type:"POST",
      data:{view_vill:view_vill},
      success:function(response){
        //console.log(response);
        data = JSON.parse(response);
        //console.log(data[0].village_id);
        let UserstatusColor= '';
        if (data['status_id'] == 5) {
          UserstatusColor="#1E8449"; /*Display GREEN */
        }else{
          UserstatusColor="#F00";   // Display RED 
        }
        Swal.fire({
          title:'<h3>Detail Of Village : '+data['village_id']+' </h3>',
          type:'info',
          icon:'info',
          width: 700,
          padding: '1em',
          html:
          '<table class="table table-striped" style="font-size:16px;"><tr align="left"><td style="font-weight:bold">ລະຫັດບ້ານ</td><td>'
          +data['village_id']+
          '</td></tr><tr align="left"><td style="font-weight:bold">ບ້ານ</td><td>'
          +data['vill_name_la']+
          '</td></tr><tr align="left"><td style="font-weight:bold">Village</td><td>'
          +data['vill_name_en']+
          '</td></tr><tr align="left"><td style="font-weight:bold">ເມືອງ</td><td>'
          +data['dist_name_la']+
          '</td></tr><tr align="left"><td style="font-weight:bold">District</td><td>'
          +data['dist_name_en']+
          '</td></tr><tr align="left"><td style="font-weight:bold">ແຂວງ</td><td>'
          +data['prov_name_la']+ 
          '</td></tr><tr align="left"><td style="font-weight:bold">Province</td><td>'
          +data['prov_name_en']+
          '</td></tr></table>',
          showCancelButton: false,
          showCloseButton: true,
          //allowOutsideClick: false,
          allowEscapeKey: false,
        });
        $("#ShowvillModal").modal('hide');
      }
    });
  });

//Add district
  $("#btninsertD").click(function(e){
    if($("#frm_add_dist")[0].checkValidity()){
      e.preventDefault();
      Swal.fire({
        title: 'Are You Sure ?',
        text: "Information will Save to database",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: 'Do not Save'
      }).then((result)=>{
        if (result.isConfirmed) {
          $.ajax({
            url:"controllers/prov_info.php",
            type:"POST",
            data:$("#frm_add_dist").serialize()+"&district=add_new_dist",
            success:function(response){
              //data = JSON.parse(response);
              //console.log(response);
              let iConAddBR='';
              let dataAddBR='';

                if(response==1){
                  iConAddBR='success';
                  dataAddBR='Isert Successfully Affected row: '+response;
                }else{
                  iConAddBR='error'; 
                  dataAddBR='failed to insert into database: '+response;
                }
              Swal.fire(
                  'Result Response Insert:',
                  dataAddBR, //'You Have Insert User One Record In Database',
                  iConAddBR
              )
              $("#addDist").on('hidden.bs.modal', function(e){
                //$(".modal-body").html("");
                $("#frm_add_dist")[0].reset();
              });
              setTimeout(function() {
                location.reload();
              },2000);
              
            }
          });
        }else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info')
          $("#addDist").on('hidden.bs.modal', function(e){
            //$(".modal-body").html("");
            $("#frm_add_dist")[0].reset();
          })          
          setTimeout(function() {
            //window.location.replace("?d=user_menu/user_web");
            location.reload();
          },2000);
        }
      });
    }
  });










































});