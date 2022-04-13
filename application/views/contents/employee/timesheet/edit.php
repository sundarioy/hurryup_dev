          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Ubah Kegiatan</h3>
              </div>
              <form action="<?php echo base_url() ?>employee/timesheet/update/<?php echo $data->id ?>" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Tupoksi</label>
                    <input type="text" class="form-control" value="<?= $data->tupoksi ?>" readonly>
                  </div>

                  <div class="form-group">
                    <label>Bobot</label>
                    <input type="number" min="0" class="form-control" value="<?= $data->weight ?>" readonly>
                  </div>

                  <div class="form-group">
                    <label>Kegiatan</label>
                    <textarea class="form-control" name="activity" required><?= $data->activity ?></textarea>
                  </div>

                  <div class="form-group">
                    <label>Durasi (Menit)</label>
                    <input type="number" min="0" name="duration" class="form-control" required value="<?= $data->duration ?>"> 
                  </div>

                  <div class="form-group">
                    <label>Saran</label>
                    <textarea class="form-control" readonly><?= $data->feedback ?></textarea>
                  </div>

                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <a href="<?php echo base_url() ?>employee/timesheet" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
              </form>
            </div>
          </div>