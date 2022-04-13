       <div class="row">
       <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-body">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>NIP</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?= $data->nip ?>">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tahun</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?= $calendar->year ?>">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Nama</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>                    
                      <input type="text" class="form-control" readonly value="<?= $data->name ?>">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Organisasi</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                      </div>
                      <?php 
                      $CI =& get_instance();
                      $CI->load->model('employees');
                      $employee_position = $CI->employees->showEmployeeOrgUnit($data->employee_id)->result();

                      foreach ($employee_position as $emppos) { ?>
                        <input type="text" class="form-control" readonly value="<?= $emppos->org_unit ?>">
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>         
       </div>

      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="<?php echo base_url('employee/performance/store_reviewer') ?>">
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  <label>Penilai 1</label>
                  <select class="form-control" name="assessor[]" required>
                    <option value=""> -- Pilih Penilai -- </option>
                    <?php foreach ($coworkers->result() as $value): ?>
                      <option value="<?= $value->employee_id ?>"><?= $value->nip.' - '.$value->name ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Penilai 2</label>
                  <select class="form-control" name="assessor[]" required>
                    <option value=""> -- Pilih Penilai -- </option>
                    <?php foreach ($coworkers->result() as $value): ?>
                      <option value="<?= $value->employee_id ?>"><?= $value->nip.' - '.$value->name ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Penilai 3</label>
                  <select class="form-control" name="assessor[]" required>
                    <option value=""> -- Pilih Penilai -- </option>
                    <?php foreach ($coworkers->result() as $value): ?>
                      <option value="<?= $value->employee_id ?>"><?= $value->nip.' - '.$value->name ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div class="card-footer">
                <div class="float-right">
                  <button type="submit" name="save" class="btn btn-warning save-confirmation" value="save"><span class="fa fa-save"></span> &nbsp;Simpan sebagai Draf</button>
                  <button type="submit" name="save" class="btn btn-primary publish-confirmation" value="publish"><span class="fa fa-paper-plane"></span> &nbsp;Publikasikan</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>