<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <table id="users" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th style="width: 5%" class="center">No</th>
              <th class="center">Nama</th>
              <th class="center">NIP</th>
              <th class="center">Jabatan</th>
              <th class="center">Fungsi</th>
              <th class="center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($users->result() as $data) {?>
              <tr>
                <td class="center"><?php echo $no++ ?></td>
                <td> <?php echo $data->name ?> </td>
                <td class="center"><?php echo $data->nip ?></td>
                <td class="center"><?php echo $data->position ?></td>
                <td class="center"><?php echo $data->org_unit ?></td>
                <td class="center">
                  <a href="<?php echo base_url() ?>hrd/personaldevelopment/show/<?php echo $data->employee_id ?>" title="detail" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>