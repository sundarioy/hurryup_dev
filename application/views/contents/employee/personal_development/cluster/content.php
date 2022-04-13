<div class="row">
  <div class="col-md-12">
    <div class="card-body">      
      <div class="float-right">
      </div>
    </div>
    <?php $this->load->view('contents/employee/personal_development/cluster/detail_ukg') ?>
    <?php $this->load->view('contents/employee/personal_development/cluster/detail_upk') ?>    
  </div>
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">              
        <table id="users" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th style="width: 5%" class="center">No</th>
              <th class="center">Tanggal</th>
              <th class="center">Nama</th>
              <th class="center">NIP</th>
              <th class="center">Jabatan</th>
              <th class="center">Fungsi</th>
              <th class="center">Rencana Pembangunan</th>
              <th class="center">Status</th>
              <th class="center">Aksi</th>
            </tr>
          </thead>          
          <tbody>
            <?php $no = 1;
            foreach ($requests->result() as $data) {
              ?>
              <tr>
                <td class="center"><?php echo $no++ ?></td>
                <td> 
                  <?php echo date('j F Y', strtotime($data->created_at)) ?>                  
                </td>
                <td> <?php echo $data->name ?> </td>
                <td class="center"><?php echo $data->nip ?></td>                
                <td class="center"><?php echo $data->position ?></td>
                <td class="center"><?php echo $data->org_unit ?></td>
                <td class="center"><?php echo $data->dev_type ?></td>
                <td class="center"><?php 
                if ($data->flag == 2) {
                  echo "Pending";
                } elseif ($data->flag == 1) {
                  echo "Disetujui";
                } elseif ($data->flag == 0) {
                  echo "Ditolak";
                }
              ?></td>
              <td class="center">                  
                <button class="btn btn-info btn-xs" onclick="showDetailRequest(<?php echo $data->id?>, '<?php echo $data->dev_type ?>')"><i class="fa fa-search" aria-hidden="true"></i></button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="modalMessage">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body text-center">
        <span class="modalMessageIcon" class="mt-3"><i class="fa fa-info-circle text-warning"></i></span>
        <p class="modalMessageContent" class="mt-1 pb-2"></p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalSaved">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body text-center">
        <span class="modalMessageIcon" class="mt-3"><i class="fa fa-check-circle text-success"></i></span>
        <p class="modalMessageContent" class="mt-1 pb-2"></p>
      </div>      
    </div>
  </div>
</div>

