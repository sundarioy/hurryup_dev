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
                      Usulan Kenaikan Golongan (UKG)
                    </button>
                  </h5>
                </div>
                <div>
                  <div class="card-body">                    
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="employee_gol">Golongan Saat ini &emsp;&emsp;&emsp;&emsp;: </label>
                          <span id="employee_gol" class=""><?php echo $request->cluster ?> - <?php echo $request->rank ?></span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="staticEmail" class="col-md-4 col-form-label">Perubahan golongan ke</label>
                          <div class="col-md-8">
                            <select class="form-control" name="group" id="group">
                              <option value="0">Pilih Golongan</option>
                              <?php foreach ($clusters->result() as $value): ?>                      
                                <option 
                                <?php 
                                if ($value->id == $request->cluster_id) {
                                  ?>
                                  selected
                                  <?php 
                                }
                                ?> 
                                value="<?php echo $value->id ?>"><?php echo $value->cluster ?></option>
                              <?php endforeach ?>                              
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="staticEmail" class="col-md-4 col-form-label">Terhitung mulai tanggal</label>
                          <div class="col-md-8">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                              </div>
                              <input type="text" class="form-control datepicker" name="tmt" id="tmt" value="<?php echo date('d-m-Y', strtotime($request->tmt)) ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="exampleFormControlTextarea1">Catatan SDM<span class="text-danger">*</span></label>
                          <textarea class="form-control" id="sdm_note_ukg" rows="3" maxlength="200"><?php echo $request->sdm_note ?></textarea>
                        </div>
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
            <button class="btn btn-primary create-data" onclick="resubmitData('UKG')">Kirim</button>
          </div>
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
        <button type="button" class="btn btn-primary btn-modal" onclick="confirmedResubmitUkg()">Ya</button>
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