
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>

  var option=null;  
  var isMutationOrigin=false;
  var isMutationPromotion=false;
  var isMutationLateral=false;
  var isMutationCrossfunc=false;
  var isEmployeeSelected=false;
  var isClusterNotEmpty=true;
  var isGroupSelected=false;
  var org=null;
  var pos=null;
  var emp_id=null;
  var upk_type=null;
  var new_org=null;
  var new_pos=null;
  var approvers=[];
  var spv_pos_id=null;
  var spv_name=null;
  var isRejected = null;

  $(document).ready(function() {
    $('#org_unit_val').select2().on('change', function(){
      org = $(this).val();      
      $.ajax({
        url : "<?php echo base_url()?>hrd/personaldevelopment/loadPositionsValue",
        method : "POST",
        data : {id: org}, 
        dataType : 'json',
        success: function(response){
          $('#position_val').find('option').not(':first').remove();
          $('#employee_val').find('option').not(':first').remove();
          resetHiddenData();
          resetEmployeePosition();
          setEmployeeClusterInfo('*Pegawai belum dipilih',0);
          $.each(response,function(index,data){
           $('#position_val').select2().append('<option value="'+data['id']+'">'+data['position']+'</option>');
         });
        }
      });
    });

    $('#position_val').select2().on('change', function(){
      pos = $(this).val();
      $.ajax({
        url : "<?php echo base_url()?>hrd/personaldevelopment/loadEmployeesValue",
        method : "POST",
        data : {id: pos}, 
        dataType : 'json',
        success: function(response){
          $('#employee_val').find('option').not(':first').remove();
          resetHiddenData();          
          resetEmployeePosition();
          setEmployeeClusterInfo('*Pegawai belum dipilih',0);
          if (response.length==0) {
            $('#employee_message').text('*Pekerja tidak ditemukan');
            $('#employee_message').removeAttr('hidden');            
          } else {            
            $.each(response,function(index,data){             
             $('#employee_val').select2().append('<option value="'+data['id']+'">'+data['name']+'</option>');
           });            
          }
        }
      });      
    });

    $('#employee_val').select2().on('change', function(){
      var id = $(this).val();      
      emp_id = id;
      resetEmployeePosition();
      if (id==0) {
        setEmployeeClusterInfo('*Pegawai belum dipilih',0);
        resetHiddenData();        
      } else {        
        $.ajax({            
          url : "<?php echo base_url()?>hrd/personaldevelopment/loadEmployeeData",
          method : "POST",
          data : {id: pos}, 
          dataType : 'json',
          success: function(response){
            // emp_id = response[0].id;            
            // getEmployeeOtherPositions(id);
            getApprover(id);
            var spv_id = response[0].spv_id;
            $('#employee_nip').val(response[0].nip);
            isEmployeeSelected = true;
            if (response[0].pos_id == 1) {
              $('#employee_spv').val('-');
            } else {
              $.ajax({
                url : "<?php echo base_url()?>hrd/personaldevelopment/loadEmployeeData",
                method : "POST",
                data : {id: spv_id},
                dataType : 'json',
                success: function(response2){                
                  if (response2.length==0) {
                    $('#supervisor_message').text('*Atasan tidak ditemukan');
                    $('#supervisor_message').removeAttr('hidden');                                     
                  } else {                    
                    spv_pos_id = response2[0].pos_id;                    
                    spv_name = response2[0].name;
                    $('#employee_spv').val(response2[0].name);
                    $('#supervisor_nip').val(response2[0].nip);
                  }              
                }
              });
            }            
            $.ajax({
              url : "<?php echo base_url()?>hrd/personaldevelopment/loadEmployeeCluster",
              method : "POST",
              data : {id: id},
              dataType : 'json',
              success: function(response3){
                if (response3.length==0) {
                  setEmployeeClusterInfo('Data golongan kosong',0);                  
                } else {
                  isClusterNotEmpty = true;
                  $('#employee_gol').removeClass('text-danger');
                  $('#employee_gol').removeClass('text-message');
                  $('#employee_gol').removeClass('font-italic');
                  $('#employee_gol').text(response3[0].ctr_name + ' - ' + response3[0].ctr_rank);
                }              
              }
            });
          }          
        }); 
      }
    });

    $('input:radio[name="mutation"]').change(function() {
      if ($(this).val() == 'origin') {
        //Disabled
        $("#promotion").attr('disabled',true);
        $("#lateral").attr('disabled',true);
        $("#crossfunc").attr('disabled',true);
        //Reset
        $("#promotion").select2("val","0");
        $("#lateral").select2("val","0");
        $("#crossfunc").select2("val","0");
        isMutationOrigin = true;
        isMutationPromotion = false;
        isMutationLateral = false;
        isMutationCrossfunc = false;
        upk_type = 1;
      }
      else if ($(this).val() == 'promotion') {
        //Disabled
        $("#promotion").removeAttr('disabled');
        $("#lateral").attr('disabled',true);
        $("#crossfunc").attr('disabled',true);
        //Reset        
        $("#lateral").select2("val","0");
        $("#crossfunc").select2("val","0");
        upk_type = 2;
        resetMutationValue();
      }
      else if ($(this).val() == 'lateral') {
        //Disabled
        $("#promotion").attr('disabled',true);
        $("#lateral").removeAttr('disabled');
        $("#crossfunc").attr('disabled',true);
        //Reset        
        $("#promotion").select2("val","0");
        $("#crossfunc").select2("val","0");
        upk_type = 3;
        resetMutationValue();
      }
      else if ($(this).val() == 'crossfunc') {
        //Disabled
        $("#promotion").attr('disabled',true);
        $("#lateral").attr('disabled',true);
        $("#crossfunc").removeAttr('disabled');
        //Reset        
        $("#promotion").select2("val","0");
        $("#lateral").select2("val","0");
        upk_type = 4;
        resetMutationValue();
      }      
    });

    $('#promotion').select2().on('change', function() {
      var id = $(this).val();
      if (id!=0) {
        isMutationPromotion=true;
        new_pos = id;
      } else {
        isMutationPromotion=false;
      }
    });

    $('#lateral').select2().on('change', function() {
      var id = $(this).val();
      if (id!=0) {
        isMutationLateral=true;
        new_pos = id;
      } else {
        isMutationLateral=false;
      }
    });

    $('#crossfunc').select2().on('change', function() {
      var id = $(this).val();
      if (id!=0) {
        isMutationCrossfunc=true;
        new_org = id;
        $('#cf_position').attr('hidden',false);
        $.ajax({
          url : "<?php echo base_url()?>hrd/personaldevelopment/loadPositionsValue",
          method : "POST",
          data : {id: id}, 
          dataType : 'json',
          success: function(response){                        
            $('#cf_position_val').find('option').not(':first').remove();
            $.each(response,function(index,data){
             $('#cf_position_val').select2().append('<option value="'+data['id']+'">'+data['position']+'</option>');
           });
          }
        });

      } else {
        isMutationCrossfunc=false;
        $('#cf_position').attr('hidden',true);
        $("#cf_position_val").select2("val","0");
      }
    });

    $('#group').select2().on('change', function() {
      var id = $(this).val();
      if (id!=0) {
        isGroupSelected=true;
      } else {
        isGroupSelected=false;
      }
    });

  });

function setOption(value) {
  option = value;
  resetFormOption();
}

function resetFormOption() {
  $('input:radio[name="mutation"]').prop('checked',false);
  $("#promotion").attr('disabled',true);
  $("#lateral").attr('disabled',true);
  $("#crossfunc").attr('disabled',true);
  $("#promotion").select2("val","0");
  $("#lateral").select2("val","0");
  $("#crossfunc").select2("val","0");
  $("#cf_position_val").select2("val","0");
  $("#group").select2("val","0");  
  $("#sdm_note_upk").val("");
  $("#sdm_note_ukg").val("");
}

function resetMutationValue() {
  isMutationOrigin = false;
  isMutationPromotion = false;
  isMutationLateral = false;
  isMutationCrossfunc = false;
}

function resetHiddenData() {  
  $('#employee_nip').val('');
  $('#employee_spv').val(''); 
  $('#employee_message').attr('hidden',true);
  $('#supervisor_message').attr('hidden',true);
}

function resetEmployeePosition() {
  $('#employee_positions').attr('hidden',true);
  $('#position_data').empty();
}

function setEmployeeClusterInfo(message, val) {
  $('#employee_gol').text(message);
  $('#employee_gol').addClass('text-danger');
  $('#employee_gol').addClass('font-italic');
  $('#employee_gol').addClass('text-message');  
  isClusterNotEmpty = val;
}

function getEmployeeOtherPositions(eid) {
  $.ajax({
    url : "<?php echo base_url()?>hrd/personaldevelopment/loadEmployeePositions",
    method : "POST",
    data : {id: eid},
    dataType : 'json',
    success: function(response){      
      approvers = response;
      // console.log(approvers);
      /*if (response.length > 1 ) {
        $('#employee_positions').attr('hidden',false)
        $.each(response,function(index,data){
          $('#position_data').append(
            '<tr>'+
            '<td>'+ (index+1) +'</td>'+
            '<td>'+ data['position'] +'</td>'+
            '<td>'+ data['org_unit'] +'</td>'+
            '<td>'+ data['spv_name'] +'</td>'+
            '</tr>'
            );
        });
      }*/
    }
  });
}

function getApprover(id) {
  var emp_pos_id = null;  
  var avp = [];
  var avp2 = [];
  approvers= [];

  $.ajax({
    url : "<?php echo base_url()?>hrd/personaldevelopment/loadEmployeePositions",
    method : "POST",
    data : {id: id},
    dataType : 'json',
    success: function(response){
      $.each(response,function(a,b) {
        $.ajax({
          url : "<?php echo base_url()?>hrd/personaldevelopment/loadApprover",
          method : "POST",
          data : {id: b.pos_id},
          dataType : 'json',
          success: function(response2){          
            $.each(response2,function(i,e) {
              avp = [];
              avp = {
                'level': 1,
                // 'emp_position_id': e.eid,
                'spv_name': e.name,
                // 'spv_position': e.position,
                // 'spv_parent_id': e.parent_id,
                'spv_position_id': e.id,
                'child': 0,
              };
              approvers.push(avp);
              $.ajax({
                url : "<?php echo base_url()?>hrd/personaldevelopment/loadApprover",
                method : "POST",
                data : {id: e.id},
                dataType : 'json',
                success: function(response3){          
                  $.each(response3,function(j,f) {
                    avp = [];
                    avp = {
                      'level': 2,
                      // 'emp_position_id': f.eid,
                      'spv_name': f.name,
                      // 'spv_position': f.position,
                      // 'spv_parent_id': f.parent_id,
                      'spv_position_id': f.id,
                      'child': f.eid,
                    };
                    approvers.push(avp);
                  });                          
                }
              });  
            });         
          }
        });         
      });      
    }
  });

  // Approver Lvl 3 
  avp = [];  
  $.ajax({
    url : "<?php echo base_url()?>hrd/personaldevelopment/loadEmployeeData",
    method : "POST",
    data : {id: 51},
    dataType : 'json',
    success: function(response){
      avp = {
        'level': 3,
        'spv_name': response[0].name,
        'spv_position_id': 51,
        'child': 0,
      };
      approvers.push(avp);    
    }
  });  

  // Approver Lvl 4 
  avp = [];
  $.ajax({
    url : "<?php echo base_url()?>hrd/personaldevelopment/loadEmployeeData",
    method : "POST",
    data : {id: 5},
    dataType : 'json',
    success: function(response){
      avp = {
        'level': 4,
        'spv_name': response[0].name,
        'spv_position_id': 5,
        'child': 0,
      };
      approvers.push(avp);    
    }
  });
}

function submitData() {
  if (option=='UPK') {
    if ((isMutationOrigin || isMutationPromotion || isMutationLateral || isMutationCrossfunc) && isEmployeeSelected && ($.trim($("#sdm_note_upk").val())) && ($("#par_value").val())) {
      $(".modalMessageContent").text("Anda yakin akan membuat pengajuan UPK?");
      $("#modalConfirm").modal({backdrop: 'static', keyboard: false}) 
    } else {
      $(".modalMessageContent").text("Data UPK belum lengkap.");
      $("#modalMessage").modal({backdrop: 'static', keyboard: false}) 
    }
  } else {
    if (isEmployeeSelected && isGroupSelected && isClusterNotEmpty && ($.trim($("#sdm_note_ukg").val())) && ($("#par_value").val())) {
      $(".modalMessageContent").text("Anda yakin akan membuat pengajuan UKG?");
      $("#modalConfirm").modal({backdrop: 'static', keyboard: false}) 
    } else {
      $(".modalMessageContent").text("Data UKG belum lengkap.");
      $("#modalMessage").modal({backdrop: 'static', keyboard: false}) 
    }
  }
}

function confirmedRequest() {
  $("#modalConfirm").modal('hide');  
  var par = $('#par_value').val();  
  var sdm_note; 
  if (option=='UPK') {
    sdm_note = $('#sdm_note_upk').val();
    if (upk_type==4) {
      new_pos = $('#cf_position_val').val();
    }
    $.ajax({
      url : "<?php echo base_url()?>hrd/personaldevelopment/createRequestUPK",
      method : "POST",
      data : {
        emp_id: emp_id,
        par: par,
        org: org,
        pos: pos,
        dev_type: option,
        upk_type: upk_type,
        new_org: new_org,
        new_pos: new_pos,
        sdm_note: sdm_note,
        spv_pos_id: spv_pos_id,
        spv_name: spv_name,
      }, 
      dataType : 'json',
      success: function(response){      
        if (response==1) {
          $(".modalMessageContent").text('Pengajuan ' + option + ' berhasil dibuat.');  
          $("#modalSaved").modal({backdrop: 'static', keyboard: false});
          window.location.href = "<?php echo base_url(); ?>hrd/personaldevelopment/cluster";
        }
      }
    }); 
  } else {    
    var ctr = $('#group').val();
    var tmt = $('#tmt').val();
    // var date = jQuery('#datepicker').datepicker('getDate');
    sdm_note = $('#sdm_note_ukg').val();
    $.ajax({
      url : "<?php echo base_url()?>hrd/personaldevelopment/createRequestUKG",
      method : "POST",
      data : {
        emp_id: emp_id,
        par: par,
        org: org,
        pos: pos,        
        dev_type: option,
        ctr: ctr,
        tmt: tmt,
        sdm_note: sdm_note,
        approvers: JSON.stringify(approvers),
      }, 
      dataType : 'json',
      success: function(response){      
        if (response==1) {
          $(".modalMessageContent").text('Pengajuan ' + option + ' berhasil dibuat.');  
          $("#modalSaved").modal({backdrop: 'static', keyboard: false});
          window.location.href = "<?php echo base_url(); ?>hrd/personaldevelopment/cluster";
        }
      }
    });
  } 
}

function showDetailRequest(id, dev_type) {
  $('.dev_log').empty();
  $('#ukg_approver').empty();
  $('#upk_approver').empty();        
  var modal_id='';
  if (dev_type=='UPK') {
    $(modal_id).modal('hide');  
    $.ajax({
      url : "<?php echo base_url()?>hrd/personaldevelopment/loadRequest",
      method : "POST",
      data : {id: id, dev_type:dev_type},
      dataType : 'json',
      success: function(response){
        // console.log(response);
        $('#req_upk_nip').val(response[0].nip);
        $('#req_upk_name').val(response[0].name);
        $('#req_upk_pos').val(response[0].position);
        $('#req_upk_org').val(response[0].org_unit);
        $('#req_upk_ctr').val(response[0].ctr_old);
        $('#req_upk_par').val(response[0].par_value);
        $('#req_upk_note').text(response[0].sdm_note);
        $('#req_upk_create').val(response[0].created_at);
        $('#req_upk_type').val(response[0].upk_type);
        if (response[0].pos_new==null) {
          $('#req_upk_pos_new').val('-');  
        } else {
          $('#req_upk_pos_new').val(response[0].pos_new);
        }
        
        if (response[0].org_new==null) {
          $('#req_upk_org_new').val('-');  
        } else {
          $('#req_upk_org_new').val(response[0].org_new);
        }        
        getUpkApproverData(id);        
        getDevRequestLog(id);
        $('#modal-detail-upk').modal({backdrop: 'static', keyboard: false});
      }
    });
  } else {
    $(modal_id).modal('hide');
    $.ajax({
      url : "<?php echo base_url()?>hrd/personaldevelopment/loadRequest",
      method : "POST",
      data : {id: id, dev_type:dev_type},
      dataType : 'json',
      success: function(response){
        $('#req_data_nip').val(response[0].nip);
        $('#req_data_name').val(response[0].name);
        $('#req_data_pos').val(response[0].position);
        $('#req_data_org').val(response[0].org_unit);
        $('#req_data_ctr').val(response[0].ctr_old);
        $('#req_data_par').val(response[0].par_value);
        $('#req_data_note').text(response[0].sdm_note);
        $('#req_data_create').val(response[0].created_at);
        $('#req_data_ctr_new').val(response[0].ctr_new);
        $('#req_data_tmt').val(response[0].tmt);        
        getUkgApproverData(id);
        modal_id = '#modal-detail-ukg';
        getDevRequestLog(id);
        $(modal_id).modal({backdrop: 'static', keyboard: false});
      }
    });
  }
}

function getStatusApproval(id) {
  $.ajax({
    url : "<?php echo base_url()?>hrd/personaldevelopment/loadApprovalStatus",
    method : "POST",
    data : {id: id},
    dataType : 'json',
    success: function(response){
      $('#req_data_ctr_new').val(response[0].ctr_new);
    }
  });
}

function getUpkApproverData(id) {
  $('#upk_approver').empty();
  var color='';
  var status='';
  $.ajax({
    url : "<?php echo base_url()?>hrd/personaldevelopment/loadUpkRequestApprover",
    method : "POST",
    data : {id: id},
    dataType : 'json',
    success: function(response){
      $.each(response,function(index,data){
        if (data['flag']==2) {
          color='badge-warning';
          status='Pending';
          $('#btn_resubmit_upk').attr('hidden', true);
        } else if (data['flag']==1) {
          color='badge-success';
          status='Disetujui';
          $('#btn_resubmit_upk').attr('hidden', true);
        } else if (data['flag']==0) {
          color='badge-danger';
          status='Ditolak';
          $('#btn_resubmit_upk').attr('hidden', false);
          $('#btn_resubmit_upk').attr('onclick','resubmitUPK('+data['dev_request_id']+')');
        }  
        $('#upk_approver').append(
          '<div class="col-md-3 text-center text-message">Atasan <br>'+
          '<label class="">'+data['approver_name']+'</label><br>'+
          '<div class="badge '+ color +' text-wrap" style="width: 7rem;">'+
          status +
          '</div>'+                          
          '</div>'
          );
      });
    }
  });
}

function setRejected(val) {
  this.isRejected = val;
}

function getUkgApproverData(id) {
  $('#ukg_approver_lv1').empty();
  $('#ukg_approver_lv2').empty();
  $('#ukg_approver_lv3').empty();
  $('#ukg_approver_lv4').empty();
  var color='';
  var status='';
  var spv_lv1 = 0;
  var spv_lv2 = 0;  
  $.ajax({
    url : "<?php echo base_url()?>hrd/personaldevelopment/loadUkgRequestApprover",
    method : "POST",
    data : {id: id},
    dataType : 'json',
    async: false,
    success: function(response){
      // console.log(response);
      $.each(response,function(index,data){
        if (data['flag']==null) {
          color='badge-secondary';
          status='-';          
        } else if (data['flag']==1) {
          color='badge-success';
          status='Disetujui';          
        } else if (data['flag']==0) {
          color='badge-danger';
          status='Ditolak';          
          setRejected(true);
        } else if (data['flag']==2) {
          color='badge-warning';
          status='Pending';          
        }  

        if (data.level == 1) {
          spv_lv1+=1;
          $('#ukg_approver_lv1').append(
            '<div class="text-center text-message mt-2 mb-4">Atasan '+ (spv_lv1) +'<br>'+
            '<label class="">'+data['approver_name']+'</label> <br>'+
            '<div class="badge '+ color +' text-wrap" style="width: 7rem;">'+
            status +
            '</div>'+                          
            '</div>'
            ); 
        } else if (data.level == 2) {
          spv_lv2+=1;
          $('#ukg_approver_lv2').append(
            '<div class="text-center text-message mt-2 mb-4">Atasan '+ (spv_lv2) +'<br>'+
            '<label class="">'+data['approver_name']+'</label> <br>'+
            '<div class="badge '+ color +' text-wrap" style="width: 7rem;">'+
            status +
            '</div>'+                          
            '</div>'
            ); 
        } else if (data.level == 3) {
          $('#ukg_approver_lv3').append(
            '<div class="text-center text-message mt-2">Manager SDM<br>'+
            '<label class="">'+data['approver_name']+'</label> <br>'+
            '<div class="badge '+ color +' text-wrap" style="width: 7rem;">'+
            status +
            '</div>'+                          
            '</div>'
            ); 
        } else if (data.level == 4) {
          $('#ukg_approver_lv4').append(
            '<div class="text-center text-message mt-2">WRS<br>'+
            '<label class="">'+data['approver_name']+'</label> <br>'+
            '<div class="badge '+ color +' text-wrap" style="width: 7rem;">'+
            status +
            '</div>'+                          
            '</div>'
            ); 
        }
      });      
    }
  });  
  if (isRejected) {
    $('#btn_resubmit_ukg').attr('hidden', false);
    $('#btn_resubmit_ukg').attr('onclick','resubmitUKG('+id+')');
  }
}

function getDevRequestLog(id) {  
  $.ajax({
    url : "<?php echo base_url()?>hrd/personaldevelopment/loadRequestLog",
    method : "POST",
    data : {id: id},
    dataType : 'json',
    success: function(response){            
      $.each(response,function(index,data){
        var comment='';
        if (data['comment'] != null) {
          comment = 'Catatan : ' + data['comment'];
        }
        $('.dev_log').append(
          '<li class="tl-list">' +
          '<div class="time">'+ data['created_at'] +'</div>'+
          '<p class="tl-detail">' + data['employee_name'] + ' ' + data['description'] + '</p>'+
          '<p class="tl-detail-note">' + comment + '</p>'+
          '</li>'
          );
      });
    }
  });
}

function resubmitUPK(id) {  
  window.location.href = "<?php echo base_url(); ?>hrd/personaldevelopment/updateUpk/"+id;
}

function resubmitUKG(id) {  
  window.location.href = "<?php echo base_url(); ?>hrd/personaldevelopment/updateUkg/"+id;
}

function resubmitData(val) {
  var el_id = '';
  if (val=='UPK') {
    el_id = '#sdm_note_upk';
  } else {
    el_id = '#sdm_note_ukg';
  }
  if (($.trim($(el_id).val())) && ($("#par_value").val())) {
    $(".modalMessageContent").text("Anda yakin akan memperbarui pengajuan "+val+"?");
    $("#modalConfirm").modal({backdrop: 'static', keyboard: false}) 
  } else {
    $(".modalMessageContent").text("Data "+val+" belum lengkap.");
    $("#modalMessage").modal({backdrop: 'static', keyboard: false}) 
  }
}

function resubmitUkgData() {
  if (($.trim($("#sdm_note_ukg").val())) && ($("#par_value").val())) {
    $(".modalMessageContent").text("Anda yakin akan memperbarui pengajuan UKG?");
    $("#modalConfirm").modal({backdrop: 'static', keyboard: false}) 
  } else {
    $(".modalMessageContent").text("Data UKG belum lengkap.");
    $("#modalMessage").modal({backdrop: 'static', keyboard: false}) 
  }
}

function confirmedResubmitUpk() {
  $("#modalConfirm").modal('hide');  
  var req_id = $('#req_id').val();  
  var par = $('#par_value').val();    
  var sdm_note = $('#sdm_note_upk').val();
  if ($('#radio_origin').is(':checked')) {
    isMutationOrigin = true;
    upk_type = 1;
  } else {
    if (upk_type==4) {
      new_pos = $('#cf_position_val').val();
    }  
  }

  $.ajax({
    url : "<?php echo base_url()?>hrd/personaldevelopment/updateRequestUPK",
    method : "POST",
    data : {      
      par: par,
      upk_type: upk_type,
      new_org: new_org,
      new_pos: new_pos,
      sdm_note: sdm_note,
      req_id: req_id,
    }, 
    dataType : 'json',
    success: function(response){      
      if (response==1) {
        $(".modalMessageContent").text('Pengajuan UPK berhasil diajukan ulang.');  
        $("#modalSaved").modal({backdrop: 'static', keyboard: false});
        window.location.href = "<?php echo base_url(); ?>hrd/personaldevelopment/cluster";
      }
    }
  });
}

function confirmedResubmitUkg() {
  $("#modalConfirm").modal('hide');  
  var req_id = $('#req_id').val();  
  var par = $('#par_value').val();    
  var sdm_note = $('#sdm_note_ukg').val();
  var ctr = $('#group').val();
  var tmt = $('#tmt').val();

  $.ajax({
    url : "<?php echo base_url()?>hrd/personaldevelopment/updateRequestUKG",
    method : "POST",
    data : {      
      emp_id: emp_id,
        par: par,        
        ctr: ctr,
        tmt: tmt,
        sdm_note: sdm_note,
        req_id: req_id,
    }, 
    dataType : 'json',
    success: function(response){      
      if (response==1) {
        $(".modalMessageContent").text('Pengajuan UKG berhasil diajukan ulang.');  
        $("#modalSaved").modal({backdrop: 'static', keyboard: false});
        window.location.href = "<?php echo base_url(); ?>hrd/personaldevelopment/cluster";
      }
    }
  });
}

$(function () {
  $("#users").DataTable({
    "responsive": true,
    "autoWidth": false,
  });
  $('#table').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
  });
});

$('.reset-confirmation').on('click', function(e){
  var c = confirm('Apakah Anda ingin setel ulang kata sandi?');
  return c;
});

$('.delete-confirmation').on('click', function(e){
  var c = confirm('Apakah Anda yakin ingin menghapus data ini?');
  return c;
});

$('.reset-password').on('click', function(e){
  $('input[name=password]').removeAttr('disabled');
  $('input[name=confirm]').removeAttr('disabled');
  $('#submit-password').removeAttr('disabled');
});

</script>
