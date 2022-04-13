<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>

  $(document).ready(function() {

  });
  
  function showDetailRequest(id, dev_type) {    
    $('.dev_log').empty();
    $('.action_btn').empty();    
    var modal_id='';
    if (dev_type=='UPK') {
      $(modal_id).modal('hide');  
      $.ajax({
        url : "<?php echo base_url()?>employee/personaldevelopment/loadRequest",
        method : "POST",
        data : {id: id, dev_type:dev_type},
        dataType : 'json',
        success: function(response){          
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
          getDevRequestLog(id);
          getSpvApprovalStatus(id,dev_type);
          $('#modal-detail-upk').modal({backdrop: 'static', keyboard: false});
        }
      });
    } else {
      $(modal_id).modal('hide');
      $.ajax({
        url : "<?php echo base_url()?>employee/personaldevelopment/loadRequest",
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
          modal_id = '#modal-detail-ukg';
          getDevRequestLog(id);
          getSpvApprovalStatus(id,dev_type);
          $(modal_id).modal({backdrop: 'static', keyboard: false});
        }
      });
    }
  }

  function getDevRequestLog(id) {    
    $.ajax({
      url : "<?php echo base_url()?>employee/personaldevelopment/loadRequestLog",
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

  function getSpvApprovalStatus(id, dev_type) {
    var pid = <?php echo $this->general->getEmployeePosition($this->session->userdata('employee'))->position_id; ?>;
    var dt = dev_type == 'UPK'? 1 : 2;
    $.ajax({
      url : "<?php echo base_url()?>employee/personaldevelopment/getSpvApprovalStatus",
      method : "POST",
      data : {id: id, pid: pid},
      dataType : 'json',
      success: function(response){
        if (response[0].flag == 2) {
          $('.action_btn').append(
            '<button type="button" class="btn btn-danger mr-2" style="width:80px;" onclick="submitRequest('+id+','+pid+','+0+','+dt+')">Tolak</button>'+
            '<button type="button" class="btn btn-primary pull-left" style="width:80px;" onclick="submitRequest('+id+','+pid+','+1+','+dt+')">Setuju</button>'
            );
          $('#spv_upk_note').attr('disabled',false)
          $('#spv_ukg_note').attr('disabled',false)
        } else if (response[0].flag == 1 || response[0].flag == 0) {
          $('.action_btn').append(
            '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>'
            );
          $('#spv_upk_note').text(response[0].comment);
          $('#spv_ukg_note').text(response[0].comment);
          $('#spv_upk_note').attr('disabled',true)
          $('#spv_ukg_note').attr('disabled',true)
        } 
      }
    });
  }

  function submitRequest(id,pid,val,dt) {
    $('.spv_note').attr('hidden',true);
    if (dt==1) {
      if ( !($.trim($('#spv_upk_note').val())) ) {
        $('.spv_note').attr('hidden',false);
      } else {
        submitData(id,pid,val,dt);
      }  
    } else {      
      if ( !($.trim($('#spv_ukg_note').val())) ) {
        $('.spv_note').attr('hidden',false);
      } else {
        submitData(id,pid,val,dt);
      }
    }
  }

  function submitData(id,pid,val,dt) {    
    var comment='';
    if (dt==1) {
      comment = $('#spv_upk_note').val();
    } else {
      comment = $('#spv_ukg_note').val();
    }    
    $.ajax({
      url : "<?php echo base_url()?>employee/personaldevelopment/updateApprovalDev",
      method : "POST",
      data : {
        dr_id: id,
        apr_id: pid,
        comment: comment,
        flag: val,
        dt: dt,
      }, 
      dataType : 'json',
      success: function(response){
        if (val==1) {
          $.ajax({
            url : "<?php echo base_url()?>employee/personaldevelopment/updateApprovalStage",
            method : "POST",
            data : {
              dr_id: id,
            }, 
            dataType : 'json',
            success: function(response2){
            }
          });
        }
        if (response == 1 && val == 1) {
          $(".modalMessageContent").text('Pengajuan telah disetuji.'); 
          $("#modalSaved").modal({backdrop: 'static', keyboard: false});          
        } else {
          $(".modalMessageContent").text('Pengajuan telah ditolak.'); 
          $("#modalSaved").modal({backdrop: 'static', keyboard: false});          
        }
        $("#modal-detail-ukg").modal('hide');
        $("#modal-detail-upk").modal('hide');
        window.location.href = "<?php echo base_url(); ?>employee/personaldevelopment/cluster";
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