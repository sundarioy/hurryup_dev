<div class="row">
  <div class="col-md-12">
    <div class="card-body">                        
      <div class="float-left">        
        <a href="<?php echo base_url()?>hrd/personaldevelopment/addcluster" class="btn btn-success create-data"><span class="fa fa-plus"></span> &nbsp;Buat Pengajuan</a>
      </div>
      <div class="float-right">
      </div>
    </div>
    <?php $this->load->view('contents/hrd/personal_development/cluster/detail_ukg') ?>
    <?php $this->load->view('contents/hrd/personal_development/cluster/detail_upk') ?>
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
              <th class="center">Rencana Pengembangan</th>
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
                  <!-- <?php echo $data->created_at ?>  -->
                </td>
                <td> <?php echo $data->name ?> </td>
                <td class="center"><?php echo $data->nip ?></td>                
                <td class="center"><?php echo $data->position ?></td>
                <td class="center"><?php echo $data->org_unit ?></td>
                <td class="center"><?php echo $data->dev_type ?></td>
                <td class="center"><?php echo $data->sum_flag ?></td>
                <td class="center">
                  <button class="btn btn-info btn-xs" onclick="showDetailRequest(<?php echo $data->req_id?>, '<?php echo $data->dev_type ?>')"><i class="fa fa-search" aria-hidden="true"></i></button>
                  <!-- <a href="" class="btn btn-light btn-outline-secondary btn-xs" data-target="#modal-detail" data-toggle="modal"><i class="fa fa-search" aria-hidden="true"></i></a> -->
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>