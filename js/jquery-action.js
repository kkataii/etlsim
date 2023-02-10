$(document).ready(function(){
//$.ajaxSetup({ cache: false }); 
/****************** MonthPicker *********************/
 // Hide the icon and open the menu when you
 // click on the text field.
 $('#monthpicker').MonthPicker({ 
    MonthFormat: 'yy-mm',
    Button: false 
 });
$("#datepicker").datepicker({ 
  format: "yyyy-mm-dd",
  uiLibrary: 'bootstrap',
  iconsLibrary: 'fontawesome',
  showOn: "button"
    //buttonImage: "images/ui-icons_2e83ff_256x240.png",
    //buttonImageOnly: true,
    //showButtonPanel:true 
});
$("#startdate").datepicker({ 
  format: "yyyy-mm-dd",
  uiLibrary: 'bootstrap',
  iconsLibrary: 'fontawesome',
  showOn: "button"
    //buttonImage: "images/ui-icons_2e83ff_256x240.png",
    //buttonImageOnly: true,
    //showButtonPanel:true 
});

$('#enddate').datepicker({
  format: "yyyy-mm-dd",
    uiLibrary: 'bootstrap',
    iconsLibrary: 'fontawesome',
  showOn: "button"
    //buttonImage: "images/ui-icons_2e83ff_256x240.png",
    //buttonImageOnly: true,
    //showButtonPanel:true 
});
$('#txtaudit_birthday').datepicker({
  format: "yyyy-mm-dd",
    uiLibrary: 'bootstrap',
    iconsLibrary: 'fontawesome',
  showOn: "button"
    //buttonImage: "images/ui-icons_2e83ff_256x240.png",
    //buttonImageOnly: true,
    //showButtonPanel:true 
});
$('#editsub_birthday').datepicker({
  format: "yyyy-mm-dd",
    uiLibrary: 'bootstrap',
    iconsLibrary: 'fontawesome',
  showOn: "button"
    //buttonImage: "images/ui-icons_2e83ff_256x240.png",
    //buttonImageOnly: true,
    //showButtonPanel:true 
});

// modal auto close
    $(function() {
      var alert = $('div.alert[auto-close]');
      alert.each(function() {
        var that = $(this);
        var time_period = that.attr('auto-close');
        setTimeout(function() {
          that.alert('close');
        }, time_period);
      });
    });

// User Log Out Ajax request
  $("#logout").click(function(e){
    if($("#frm-logout")[0].checkValidity()){
      e.preventDefault();
      Swal.fire({
          title: 'ທ່ານແນ່ໃຈແລ້ວບໍ ?',
          text: 'ທີ່ຈະອອກຈາກລະບົບ ⚠',
          // icon: 'warning',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'ຍົກເລີກ',
          confirmButtonText: 'ຕົກລົງ'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url:"authorize/logout.php",
            type:"POST",
            data:$("#frm-logout").serialize()+"&action=getmeout",
            success:function(response){    
              //console.log(response);
               let iconLogout='success';
              Swal.fire(
                  'Your Are Log Out Successfully',
                  iconLogout
              )
              setTimeout(function() {
                //location.reload();
                window.location.replace("?d=index");
              },2000);
            }
          });
        }
      });
    }
  });

// Insert User ajax request
  $("#SaveUserInfo").click(function(e){
    if($("#frm-add-user")[0].checkValidity()){
      e.preventDefault();
      Swal.fire({
        title: 'Are You Sure ?',
        text: "These Infomation will Save to database",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: 'Do not Save'
      }).then((result)=>{
        if (result.isConfirmed) {
          $.ajax({
            url:"controllers/action_users.php",
            type:"POST",
            data:$("#frm-add-user").serialize()+"&action=insert_user",
            success:function(response){
              //data = JSON.parse(response);
              //console.log(response);
              let colorResInserU='';
              let mydata='';

                if(response==1){
                  colorResInserU='success';
                  mydata='Isert Successfully Affected row: '+response;
                }else if(response==3000){
                  colorResInserU='error'; 
                  mydata='Already Exists This User try anothoer user name, thank you';
                }else{
                  colorResInserU='error'; 
                  mydata='failed to insert into database: '+response;
                }
              Swal.fire(
                  'Result Response Insert:',
                  mydata, //'You Have Insert User One Record In Database',
                  colorResInserU
              )
              $("#addModalUser").on('hidden.bs.modal', function(e){
                //$(".modal-body").html("");
                $("#frm-add-user")[0].reset();
              });
              setTimeout(function() {
                location.reload();
              },2000);
              
            }
          });
        }else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info')
          $("#addModalUser").on('hidden.bs.modal', function(e){
            //$(".modal-body").html("");
            $("#frm-add-user")[0].reset();
          })          
          setTimeout(function() {
            //window.location.replace("?d=user_menu/user_web");
            location.reload();
          },2000);
        }
      });
    }
  });

// select  For Reset Password Ajax request
  $("body").on("click",".BtnResetpass", function(e){
    e.preventDefault();
    resetpass_id = $(this).attr('id');
    $.ajax({
      url:"controllers/action_users.php",
      type:"POST",
      //cache: false,
      data:{resetpass_id:resetpass_id},
      success:function(response){
        //console.log(response);
        data = JSON.parse(response);
        //console.log(data);

        $("#txtUser_id").val(data.user_id);
        $("#txtUser_name").val(data.user_name);
        $("#txtUserName").val(data.user_name);
        $("#txtfullName").val(data.first_name+' '+ data.last_name);
      }
    });
    $("#resetPassModal").on('hidden.bs.modal', function(e){
			$("#frm-reset-pass")[0].reset();
			/*setTimeout(function() {
			  location.reload();
			},2000);*/
		});
  });

// Update Reset Password ajax request
  $("#resetnewpwd").click(function(e){
    if($("#frm-reset-pass")[0].checkValidity()){
      e.preventDefault();
      $.ajax({
        url:"controllers/action_users.php",
        type:"POST",
        data:$("#frm-reset-pass").serialize()+"&action=resetpasswd",
        success:function(response){
          //data = JSON.parse(response);
          //console.log(data);
         var colorResetpass='';
			   var dataresetpass='';

				if(response>0){
					colorResetpass='success';
					dataresetpass='Reset Password Successfully, Affected rows '+ response;
				}else{
					colorResetpass='error'; 
					dataresetpass='Failed to Reset Password, Affected rows '+ response;
				}
          Swal.fire(
              'Your Action Result :',
              dataresetpass,
              colorResetpass
          )
          $("#resetPassModal").modal('hide');
          $("#frm-reset-pass")[0].reset();
          setTimeout(function() {
    			  location.reload();
    			},2000);
        }
      });
    }
  });
// Show User Info Modal ajax request
  $("body").on("click",".view_user", function(e){
    e.preventDefault();
    view_user_id = $(this).attr('id');
    $.ajax({
      url:"controllers/action_users.php",
      type:"POST",
      data:{view_user_id:view_user_id},
      success:function(response){
        //console.log(response);
        data = JSON.parse(response);
        //console.log(data);
        let UserstatusColor= '';
        if (data['status_id'] == 5) {
          UserstatusColor="#1E8449"; /*Display GREEN */
        }else{
          UserstatusColor="#F00";   // Display RED 
        }
        
        Swal.fire({

          title:'<h3>Detail Of User ID : '+data['user_id']+' </h3>',
          type:'info',
          icon:'info',
          width: 650,
          padding: '1em',
          html:
          '<table class="table table-striped" style="font-size:16px;"><tr align="left"><td style="font-weight:bold">User_id</td><td>'
          +data['user_id']+
          '</td></tr><tr align="left"><td style="font-weight:bold">Staff ID</td><td>'
          +data['staff_id']+
          '</td></tr><tr align="left"><td style="font-weight:bold">User Login</td><td>'
          +data['user_name']+
          '</td></tr><tr align="left"><td style="font-weight:bold">Full Name</td><td>'
          +data['first_name']+ ' '+ data['last_name']+
          '</td></tr><tr align="left"><td style="font-weight:bold">English Name</td><td>'
          +data['english_name']+
          '</td></tr><tr align="left"><td style="font-weight:bold">Gender</td><td>'
          +data['gender_name']+
          '</td></tr><tr align="left"><td style="font-weight:bold">Phone Number</td><td>'
          +data['phone_number']+
          '</td></tr><tr align="left"><td style="font-weight:bold">Division</td><td>'
          +data['division_name_la']+ ' | ' +data['division_name_en']+
          '</td></tr><tr align="left"><td style="font-weight:bold">description</td><td>'
          +data['user_des']+
          '</td></tr><tr align="left"><td style="font-weight:bold">role_name</td><td>'
          +data['role_name']+' | '+ data['role_desc']+
          '</td></tr><tr align="left"><td style="font-weight:bold">User Type</td><td>'
          +data['user_type_name']+
          '</td></tr><tr align="left"><td style="font-weight:bold">Province</td><td>'
          +data['prov_name_la']+ ' | '+data['prov_name_en']+
          '</td></tr><tr align="left"><td style="font-weight:bold">status</td><td style="color:'+UserstatusColor+'; font-weight:bold;">'
          +data['status_name']+
          '</td></tr><tr align="left"><td style="font-weight:bold">Create Date</td><td>'
          +data['date_add']+
          '</td></tr><tr align="left"><td style="font-weight:bold">Expire_date</td><td>'
          +data['expire_date']+
          '</td></tr><tr align="left"><td style="font-weight:bold">User Create</td><td>'
          +data['user_added']+
          '</td></tr><tr align="left"><td style="font-weight:bold">Date Edit</td><td>'
          +data['date_edit']+
          '</td></tr><tr align="left"><td style="font-weight:bold">User Edit</td><td>'
          +data['user_edited']+
          '</td></tr></table>',
          showCancelButton: false,
          showCloseButton: true,
          //allowOutsideClick: false,
          allowEscapeKey: false,

        });
        $("#ShowUserModal").modal('hide');
      }
    });
  });

// select  user for edit Ajax request
  $("body").on("click",".edit_user", function(e){
    e.preventDefault();
    select_userID = $(this).attr('id');
    $.ajax({
      url:"controllers/action_users.php",
      type:"POST",
      //cache: false,
      data:{select_userID:select_userID},
      success:function(response){
        //console.log(response);
        data = JSON.parse(response);
        
        //console.log(data);

        $("#txtEd_UserId").val(data.user_id);
        $("#txtEd_staffID").val(data.staff_id);
        $("#txtEd_User").val(data.user_name);
        $("#txtEd_Fname").val(data.first_name);
        $("#txtEd_Lname").val(data.last_name);
        $("#txtEd_Ename").val(data.english_name);
        $("#txtEd_phone").val(data.phone_number);
        $("#txtEd_Gender").val(data.gender_id);
        $("#txtEd_role_id").val(data.role_id);
        $("#txtEd_div_id").val(data.division_id);
        $("#txtEd_province").val(data.province_id);
        $("#txtEd_Des").val(data.user_des);
        $("#txtEd_State").val(data.status_id);
        $("#txtEd_type_id").val(data.user_type_id);
        $("#datepicker").val(data.expire_date);
      }
    });
    $("#EditUserModal").on('hidden.bs.modal', function(e){
      $("#frm-edit-user")[0].reset();
    });
  });

// Update Edit User ajax request
  $("#SaveEditUserInfo").click(function(e){
    if($("#frm-edit-user")[0].checkValidity()){
      e.preventDefault();
      $.ajax({
        url:"controllers/action_users.php",
        type:"POST",
        data:$("#frm-edit-user").serialize()+"&action=UpdateUserInfo",
        success:function(response){
            //data = JSON.parse(response);
            //console.log(data);
         let icon='';
         let resltRSP='';

        if(response>0){
          icon='success';
          resltRSP='Update User Successfully, Affected rows '+ response;
        }else{
          icon='error'; 
          resltRSP='Failed to Update User, Affected rows '+ response;
        }
          Swal.fire(
              'Your Action Result :',
              resltRSP,
              icon
          )
          $("#EditUserModal").modal('hide');
          $("#frm-edit-user")[0].reset();
          setTimeout(function() {
        location.reload();
      },2000);
        }
      });
    }
  });
// Delete User Ajax request
  $("body").on("click",".DeleteBtnUser", function(e){
    e.preventDefault();
    var tr = $(this).closest('tr');
    user_del_id = $(this).attr('id');
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
            url:"controllers/action_users.php",
            type:"POST",
            data:{user_del_id:user_del_id},
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
// Function On Change Province, District, Village ( For Audit Check)
  $('#txtaudit_prov_id').on('change',function(){
      let provinceID = $(this).val();
      if(provinceID){
          $.ajax({
              type:'POST',
              url:'controllers/auto_selected.php',
              data:'province_id='+provinceID,
              success:function(html){
                  $('#txtaudit_district').html(html);
                  $('#txtaudit_village').html('<option value="">ກະລຸນາເລືອກເມືອງກ່ອນ</option>');
              }
          });
      }else{
          $('#txtaudit_district').html('<option value="">ກະລຸນາເລືອກແຂວງກ່ອນ</option>');
          $('#txtaudit_village').html('<option value="">ກະລຸນາເລືອກເມືອງກ່ອນ</option>');
      }
  });
  $('#txtaudit_district').on('change',function(){
      let districtID = $(this).val();
      if(districtID){
          $.ajax({
              type:'POST',
              url:'controllers/auto_selected.php',
              data:'district_id='+districtID,
              success:function(html){
                  $('#txtaudit_village').html(html);
              }
          });
      }else{
          $('#txtaudit_village').html('<option value="">ກະລຸນາເລືອກເມືອງກ່ອນ</option>');
      }
  });

// Show  Subscriber by Id Ajax request
  $("body").on("click",".viewSubInfo", function(e){
    e.preventDefault();
    let view_subinfo_by_id = $(this).attr('id');
    $.ajax({
      url:"management/show_subscriber_info.php",
      type:"POST",
      //cache: false,
      data:{view_subinfo_by_id:view_subinfo_by_id},
      success:function(data){
        
        //console.log(data);
        
        $('#ShowSubscriberinfo').html(data);
        $('#showSubscriberModal').modal("show");
      }
    });
  });
  
// Update Audit Check SubscriberInfo ajax request
  $("#SaveAuditCheck").click(function(e){
    if($("#frm-audit-check")[0].checkValidity()){
      e.preventDefault();
      Swal.fire({
        title: 'ທ່ານແນ່ໃຈແລ້ວບໍ ?',
        text: "ທີ່ຈະຢືນຢັນຂໍ້ມູນການຂື້ນທະບຽນໝາຍເລກນີ້",
        showDenyButton: true,
        confirmButtonText: 'ຢືນຢັນ',
        denyButtonText: 'ຍົກເລີກ'
      }).then((result)=>{
        if (result.isConfirmed) {
          $.ajax({
            url:"controllers/audit_check.php",
            type:"POST",
            data:$("#frm-audit-check").serialize()+"&action=formAuditCheck",
            success:function(response){
              //data = JSON.parse(response);
              //console.log(response);
              let iconRestAudit='';
              let dataRestAudit='';

                if(response==1){
                  iconRestAudit='success';
                  dataRestAudit='ທ່ານໄດ້ຢືນຢັນການຂື້ນທະບຽນສໍາເລັດຮຽບຮ້ອຍແລ້ວ';
                }else{
                  iconRestAudit='error'; 
                  dataRestAudit='ເກີດຂໍ້ຜິດພາດໃນລະບົບ ບໍ່ສາມາດ Update !';
                }

                Swal.fire(
                    'Result Response Insert:',
                    dataRestAudit, //'You Have Insert User One Record In Database',
                    iconRestAudit
                )
                $("#auditCheckModal").on('hidden.bs.modal', function(e){
                  $("#frm-audit-check")[0].reset();
                });
                setTimeout(function() {
                  //location.reload();
                  window.location.replace("?d=management/manage_register");
                },2000);
              }
          });
        }else if (result.isDenied) {
          Swal.fire('ທ່ານໄດ້ຍົກເລີກການຢືນຢັນແລ້ວ', '', 'info')
          $("#auditCheckModal").on('hidden.bs.modal', function(e){
            $("#frm-audit-check")[0].reset();
          })          
          setTimeout(function() {
            location.reload();
          },2000);
        }
      });
    }
  });

// Function On Change Province, District, Village ( For Edit Subscriber info)
  $('#editsub_prov_id').on('change',function(){
      let provinceID = $(this).val();
      if(provinceID){
          $.ajax({
              type:'POST',
              url:'controllers/auto_selected.php',
              data:'province_id='+provinceID,
              success:function(html){
                  $('#editsub_district').html(html);
                  $('#editsub_village').html('<option value="">ກະລຸນາເລືອກເມືອງກ່ອນ</option>');
              }
          });
      }else{
          $('#editsub_district').html('<option value="">ກະລຸນາເລືອກແຂວງກ່ອນ</option>');
          $('#editsub_village').html('<option value="">ກະລຸນາເລືອກເມືອງກ່ອນ</option>');
      }
  });
  $('#editsub_district').on('change',function(){
      let districtID = $(this).val();
      if(districtID){
          $.ajax({
              type:'POST',
              url:'controllers/auto_selected.php',
              data:'district_id='+districtID,
              success:function(html){
                  $('#editsub_village').html(html);
              }
          });
      }else{
          $('#editsub_village').html('<option value="">ກະລຸນາເລືອກເມືອງກ່ອນ</option>');
      }
  });

// select  Subscriber for edit Ajax request
  $("body").on("click",".edit_subscriber_ifo", function(e){
    e.preventDefault();
    let edit_subscriber_id = $(this).attr('id');
    $.ajax({
      url:"controllers/function_subscriber.php",
      type:"POST",
      //cache: false,
      data:{edit_subscriber_id:edit_subscriber_id},
      success:function(response){
        
        //console.log(response);

        data = JSON.parse(response);
        
        //console.log(data);

        let imgperson = 'https://manage.etllao.com:8988/etlkycsimregisterapi/v1/displayimage?filename='+data.img_person_path+'&keyid=303ad702c386b05417a69426f1228ad3';
        let imgdoc = 'https://manage.etllao.com:8988/etlkycsimregisterapi/v1/displayimage?filename='+data.img_doc_path+'&keyid=303ad702c386b05417a69426f1228ad3';
        let imgsim = 'https://manage.etllao.com:8988/etlkycsimregisterapi/v1/displayimage?filename='+data.img_sim_path+'&keyid=303ad702c386b05417a69426f1228ad3';

        //console.log(imgperson);

        $('#editSubscriberModal').modal({backdrop: 'static', keyboard: false}); 
        $("#editsub_id").val(data.ids);
        $("#editsub_msisdn").val(data.msisdn);
        $("#showEditmsisdn").html(data.msisdn);
        $("#editsub_fname").val(data.fname);
        $("#editsub_lname").val(data.lname);
        $("#editsub_gender").val(data.gender_id);
        $("#editsub_birthday").val(data.birthday);
        $("#editsub_docttype").val(data.document_id);
        $("#editsub_docno").val(data.document_no);
        $("#editsub_job").val(data.occupation);
        $("#editsub_email").val(data.email);
        $("#editsub_simtype_id").val(data.simtype_id);
        $("#editsub_prov_id").val(data.province_id);
        $("#editsub_address_reg").val(data.address_reg);
        $("#editsub_user_reg").val(data.user_name);
        $("#editsub_imgperson").attr("src", imgperson);
        $("#editsub_imgdoc").attr("src", imgdoc);
        $("#editsub_imgsim").attr("src", imgsim);
        $("#editsub_status_id").val(data.status_id);
        $("#editsub_subtype_id").val(data.sub_type_id);
        $("#editsub_remark").val(data.remark);
        $("#editsub_channel_id").val(data.channel_id);
        $('#editsub_district').html('<option value="'+data.district_id+'">'+data.dist_name_la+'</option>');
        $('#editsub_village').html('<option value="'+data.village_id+'">'+data.vill_name_la+'</option>');
      }
    });
    $("#editSubscriberModal").on('hidden.bs.modal', function(e){
      $("#frm-edit-subscriber")[0].reset();
    });
  });

// Update Edit SubscriberInfo ajax request
  $("#SaveEditSubinfo").click(function(e){
    if($("#frm-edit-subscriber")[0].checkValidity()){
      e.preventDefault();
      Swal.fire({
        title: 'ທ່ານແນ່ໃຈແລ້ວບໍ ?',
        text: "ທີ່ຈະແກ້ໄຂຂໍ້ມູນການຂື້ນທະບຽນໝາຍເລກນີ້",
        showDenyButton: true,
        confirmButtonText: 'ຢືນຢັນ',
        denyButtonText: 'ຍົກເລີກ'
      }).then((result)=>{
        if (result.isConfirmed) {
          $.ajax({
            url:"controllers/function_subscriber.php",
            type:"POST",
            data:$("#frm-edit-subscriber").serialize()+"&action=upDateSubinfo",
            success:function(response){
              //data = JSON.parse(response);
              //console.log(response);
              let iconRestEdSubdit='';
              let dataRestEdSubdit='';

                if(response==1){
                  iconRestEdSubdit='success';
                  dataRestEdSubdit='ບັນທືກແກ້ໄຂຂໍ້ມູນສໍາເລັດຮຽບຮ້ອຍແລ້ວ';
                }else{
                  iconRestEdSubdit='error'; 
                  dataRestEdSubdit='ເກີດຂໍ້ຜິດພາດໃນລະບົບ ບໍ່ສາມາດ Update !';
                }

                Swal.fire(
                    'Result Response Update: ',
                    dataRestEdSubdit, //'You Have Insert User One Record In Database',
                    iconRestEdSubdit
                )
                $("#editSubscriberModal").on('hidden.bs.modal', function(e){
                  $("#frm-edit-subscriber")[0].reset();
                });
                setTimeout(function() {
                  //location.reload();
                  window.location.replace("?d=management/manage_register");
                },2000);
              }
          });
        }else if (result.isDenied) {
          Swal.fire('ທ່ານໄດ້ຍົກເລີກບັນທືກແລ້ວ', '', 'info')
          $("#editSubscriberModal").on('hidden.bs.modal', function(e){
            $("#frm-edit-subscriber")[0].reset();
          })          
          setTimeout(function() {
            location.reload();
          },2000);
        }
      });
    }
  });


});
