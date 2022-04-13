<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">                  
        <h5 class="card-title">Dasar Pertimbangan</h5>      
        <p class="card-text">
          1. Yang bersangkutan secara konsisten menunjukkan prestasi kerja yang baik.<br>
          2. Yang bersangkutan mempunyai integritas dan tanggung jawab yang tinggi dalam melaksanakan pekerjaan sehari-hari.<br>
          3. Yang bersangkutan telah memasuki masa kerja selama 3 tahun sejak kenaikan golongan terakhir.
        </p>
      </div>    
    </div>
  </div>
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">        
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Fungsi</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-sitemap"></i>
                  </span>
                </div>
                <select class="form-control" name="org_unit" id="org_unit_val" disabled>
                  <option selected class="bg-white"><?php echo $request->org_unit ?></option>
                </select>
              </div>
            </div>                    
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Jabatan</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-leaf"></i>
                  </span>
                </div>
                <select class="form-control" name="position" id="position_val" disabled>
                  <option selected class="bg-white"><?php echo $request->position ?></option>
                </select>
              </div>
            </div>                    
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Nama Pegawai</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-user"></i>
                  </span>
                </div>                
                <select class="form-control" name="employee" id="employee_val" disabled>
                  <option selected><?php echo $request->name ?></option>
                </select>
              </div>
              <span class="text-danger font-italic text-message" id="employee_message" hidden></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>NIP </label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-address-card"></i>
                  </span>
                </div>
                <input type="text" class="form-control bg-white" name="employee_nip" id="employee_nip" value="<?php echo $request->nip ?>" readonly>
              </div>
            </div>                    
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Atasan Pegawai</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-user-tie"></i>
                  </span>
                </div>
                <input type="text" class="form-control bg-white" name="employee_supervisor" id="employee_spv" readonly value="<?php echo $request->approver_name ?>">
                <input type="hidden" class="form-control bg-white" name="supervisor" id="supervisor_nip" readonly>
              </div>
              <span class="text-danger font-italic text-message" id="supervisor_message" hidden></span>
            </div>                    
          </div>
          <div class="col-md-4">                    
            <div class="form-group">
              <label>Nilai PAR<span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-tags"></i></span>
                </div>
                <input type="number" class="form-control bg-white" name="par_value" id="par_value" value="<?php echo $request->par_value ?>">
              </div>
            </div>
          </div>
        </div>
        <div class="row" id="employee_positions" hidden>
          <div class="col-md-12">
            <p class="text-danger font-italic text-message">*Pekerja yang dipilih menduduki lebih dari satu jabatan</p>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Jabatan</th>
                  <th class="center">Fungsi</th>                  
                  <th class="center">Atasan</th>
                </tr>
              </thead>
              <tbody id="position_data">              
              </tbody>          
            </table> 
          </div>
        </div>               
        <div class="row">
          <div class="col-md-12">
            <div id="accordion">              
              <div class="card">
                <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed">
                      Usulan Pengembangan Karir (UPK)
                    </button>
                  </h5>
                </div>
                <div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="mutation" id="radio_origin" value="origin" <?php echo ($request->upk_type=='1')? 'checked' :'' ?>>
                            <label class="form-check-label" for="radio_origin">
                              Tetap pada jabatan semula 
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="mutation" id="radio_promotion" value="promotion" <?php echo ($request->upk_type=='2')?'checked':'' ?>>
                            <label class="form-check-label" for="radio_promotion">
                              Mutasi promosi
                            </label>
                          </div>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                Ke
                              </span>
                            </div>
                            <select class="form-control" name="promotion" id="promotion" <?php echo ($request->upk_type!='2')?'disabled':'' ?>>
                              <option <?php echo (isset($_GET['position'])) ? 'selected': ''; ?> value="0">Pilih Jabatan</option>
                              <?php foreach ($positions->result() as $value): ?>                      
                              <option <?php 
                                if ($value->id == $request->new_position_id) {
                                  ?>
                                  selected
                                  <?php 
                                }
                              ?> value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
                          <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="mutation" id="radio_lateral" value="lateral" <?php echo ($request->upk_type=='3')?'checked':'' ?>>
                            <label class="form-check-label" for="radio_lateral">
                              Mutasi lateral
                            </label>                          
                          </div>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                Ke
                              </span>
                            </div>
                            <select class="form-control" name="lateral" id="lateral" <?php echo ($request->upk_type!='3')?'disabled':'' ?>>
                              <option <?php echo (isset($_GET['position'])) ? 'selected': ''; ?> value="0">Pilih Jabatan</option>
                              <?php foreach ($positions->result() as $value): ?>                      
                              <option <?php 
                                if ($value->id == $request->new_position_id) {
                                  ?>
                                  selected
                                  <?php 
                                }
                              ?> value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
                          <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="mutation" id="radio_crossfunc" value="crossfunc" <?php echo ($request->upk_type=='4')?'checked':'' ?>>
                            <label class="form-check-label" for="radio_crossfunc">
                              Mutasi lintas fungsi/spesialisasi
                            </label>
                          </div>
                          <div class="input-group mb-1">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                Ke
                              </span>
                            </div>
                            <select class="form-control" name="crossfunc" id="crossfunc" <?php echo ($request->upk_type!='4')?'disabled':'' ?>>
                              <option <?php echo (isset($_GET['org_unit'])) ? 'selected': ''; ?> value="0">Pilih Fungsi</option>
                              <?php foreach ($organizations->result() as $value): ?>                      
                                <option <?php 
                                if ($value->id == $request->new_organization_id) {
                                  ?>
                                  selected
                                  <?php 
                                }
                              ?> value="<?php echo $value->id ?>"><?php echo $value->org_unit ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div id="cf_position" class="input-group" <?php echo ($request->upk_type!='4')?'hidden':'' ?>>
                          <select class="form-control" name="cf_position" id="cf_position_val">
                            <option value="0">Pilih Jabatan</option>
                            <?php foreach ($positions->result() as $value): ?>                      
                              <option <?php 
                                if ($value->id == $request->new_position_id) {
                                  ?>
                                  selected
                                  <?php 
                                }
                              ?> value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Catatan SDM<span class="text-danger">*</span></label>
                      <textarea class="form-control" id="sdm_note_upk" rows="3" maxlength="200"><?php echo $request->sdm_note ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>              
        </div>
      </div>
      <div class="col-md-12">
        <input type="hidden" name="req_id" id="req_id" value="<?php echo $this->uri->segment(4); ?>">
        <div class="float-right">              
          <button class="btn btn-primary create-data" onclick="resubmitData('UPK')">Kirim</button>
        </div>
      </div>
    </div>        
  </div>
</div>
</div>  
<div class="col-md-12">
  <div class="card">
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
<div class="modal fade" id="modalConfirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body text-center">
        <span class="modalMessageIcon" class="mt-3"><i class="fa fa-info-circle text-warning"></i></span>
        <p class="modalMessageContent" class="mt-1 pb-2"></p>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-primary btn-modal" onclick="confirmedResubmitUpk()">Ya</button>
        <button type="button" class="btn btn-default btn-modal" data-dismiss="modal">Batal</button>        
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