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
                    <i class="fa fa-tags"></i>
                  </span>
                </div>
                <select class="form-control" name="org_unit">
                  <option <?php echo (isset($_GET['org_unit'])) ? 'selected': ''; ?>>Pilih Fungsi</option>
                  <?php foreach ($organizations->result() as $value): ?>                      
                    <option <?php echo (isset($_GET['org_unit']) && $_GET['org_unit'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->org_unit ?></option>
                  <?php endforeach ?>
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
                <select class="form-control" name="position">
                  <option>Manajer Pengembangan dan Evaluasi Pendidikan</option>
                  <option>Asisten Manajer Monitoring Pengajaran dan Implementasi Kurikulum</option>
                  <option>Staf Pengembangan Konten E-Learning</option>
                  <option>Staf Pengembangan Evaluasi Akademik</option>
                  <!-- <option <?php echo (isset($_GET['position'])) ? 'selected': ''; ?>>Pilih Jabatan</option>
                  <?php foreach ($positions->result() as $value): ?>                      
                    <option <?php echo (isset($_GET['position']) && $_GET['position'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
                    <?php endforeach ?> -->
                  </select>
                </div>
              </div>                    
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Nama</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-tags"></i>
                    </span>
                  </div>
                  <select class="form-control" name="position">
                    <option>Pilih Nama</option>
                    <option>Nani Setiarini</option>                  
                  </select>
                </div>
              </div>                    
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">                    
              <div class="form-group">
                <label>Nama Atasan</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-user-secret"></i>
                    </span>
                  </div>                        
                  <select class="form-control" name="org_unit">
                    <option>Gita Kurnia</option>
                  <!-- <option>Atasan 2</option>
                    <option>Atasan 3</option> -->
                  </select>
                </div>
              </div>
            </div>



            <div class="col-md-4">
              <div class="form-group">
                <label>NIP: </label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-tags"></i>
                    </span>
                  </div>
                  <input-type class="form-control" name="position" value="219032">219032</input-type>
                </div>
              </div>                    
            </div>
            <div class="col-md-4">                    
              <div class="form-group">
                <label>Nilai PAR</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-tags"></i></span>
                  </div>
                  <input-type class="form-control" name="position" value="80">90</input-type>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div id="accordion">              
                <div class="card">
                  <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Usulan Pengembangan Karir (UPK)
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                            <label class="form-check-label" for="exampleRadios2">
                              Tetap pada jabatan semula 
                            </label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                            <label class="form-check-label" for="exampleRadios2">
                              Mutasi promosi
                            </label>
                          </div>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                Ke
                              </span>
                            </div>
                            <select class="form-control" name="position">
                              <option <?php echo (isset($_GET['position'])) ? 'selected': ''; ?>>Pilih Jabatan</option>
                              <?php foreach ($positions->result() as $value): ?>                      
                                <option <?php echo (isset($_GET['position']) && $_GET['position'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                            <label class="form-check-label" for="exampleRadios2">
                              Mutasi lateral
                            </label>                          
                          </div>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                Ke
                              </span>
                            </div>
                            <select class="form-control" name="position">
                              <option <?php echo (isset($_GET['position'])) ? 'selected': ''; ?>>Pilih Jabatan</option>
                              <?php foreach ($positions->result() as $value): ?>                      
                                <option <?php echo (isset($_GET['position']) && $_GET['position'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->position ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                            <label class="form-check-label" for="exampleRadios2">
                              Mutasi lintas fungsi/spesialisasi
                            </label>
                          </div>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                Ke
                              </span>
                            </div>
                            <select class="form-control" name="org_unit">
                              <option <?php echo (isset($_GET['org_unit'])) ? 'selected': ''; ?>>Pilih Fungsi</option>
                              <?php foreach ($organizations->result() as $value): ?>                      
                                <option <?php echo (isset($_GET['org_unit']) && $_GET['org_unit'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->org_unit ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Catatan SDM</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Usulan Kenaikan Golongan (UKG)
                      </button>
                    </h5>
                  </div>
                  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label for="staticEmail" class="col-md-6 col-form-label">Perubahan golongan ke</label>
                            <div class="col-md-6">
                              <select class="form-control" name="org_unit">
                                <option>Pilih Golongan</option>
                                <option>III/a</option>
                                <option>III/b</option>
                                <option>III/c</option>
                                <option>III/d</option>
                                <option>IV/a</option>
                                <option>IV/b</option>
                                <option>IV/c</option>
                                <option>IV/d</option>
                                <option>IV/e</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label for="staticEmail" class="col-md-6 col-form-label">Terhitung mulai tanggal</label>
                            <div class="col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control datepicker" name="birthday">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Catatan SDM</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="float-right">
                <a href="<?php echo base_url()?>hrd/personaldevelopment/addgroup" class="btn btn-success create-data">Kirim</a>
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
