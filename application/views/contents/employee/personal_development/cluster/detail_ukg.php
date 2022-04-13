<div class="modal fade" id="modal-detail-ukg">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Pengajuan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="box-body pl-2">
          <div class="row">            
            <div class="column col-left">              
              <div class="col-sm-12">
                <div class="row">
                  <!-- <h5 class="col-sm-12">Data Pegawai</h5> -->
                </div>
                <div class="row">
                  <label style="font-weight: 500" for="inputName" class="col-sm-3 col-form-label">NIP</label>
                  <div class="col-sm-9">
                    <label style="font-weight: 400; border: 0;" class="form-control">
                     <input type="text" class="form-control bg-white" name="req_data_nip" id="req_data_nip" disabled>
                   </label>
                 </div>
               </div>
               <div class="row">
                <label style="font-weight: 500" for="inputName" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                  <label style="font-weight: 400; border: 0;" class="form-control">
                    <input type="text" class="form-control bg-white" name="req_data_name" id="req_data_name" disabled>
                  </label>
                </div>
              </div>
              <div class="row">
                <label style="font-weight: 500" for="inputName" class="col-sm-3 col-form-label">Jabatan</label>
                <div class="col-sm-9">
                  <label style="font-weight: 400; border: 0;" class="form-control">
                    <input type="text" class="form-control bg-white" name="req_data_pos" id="req_data_pos" disabled>
                  </label>
                </div>
              </div>
              <div class="row">
                <label style="font-weight: 500" for="inputName" class="col-sm-3 col-form-label">Fungsi</label>
                <div class="col-sm-9">
                  <label style="font-weight: 400; border: 0;" class="form-control">
                    <input type="text" class="form-control bg-white" name="req_data_org" id="req_data_org" disabled>
                  </label>
                </div>
              </div>
              <div class="row">
                <label style="font-weight: 500" for="inputName" class="col-sm-3 col-form-label">Nilai PAR</label>
                <div class="col-sm-9">
                  <label style="font-weight: 400; border: 0;" class="form-control">
                    <input type="text" class="form-control bg-white" name="req_data_par" id="req_data_par" disabled>
                  </label>
                </div>
              </div>                
            </div>
          </div>
          <div class="column col-right">
            <div class="col-sm-12">
              <div class="row">
                <!-- <h5 class="col-sm-12">Data Rencana Pengembangan</h5> -->
              </div>                
              <div class="row">
                <label style="font-weight: 500" for="inputName" class="col-sm-3 col-form-label">Rencana Pengembangan</label>
                <div class="col-sm-9">
                  <label style="font-weight: 400; border: 0;" class="form-control">
                    <input type="text" class="form-control bg-white" value="Usulan Kenaikan Golongan (UKG)" disabled>
                  </label>
                </div>
              </div>
              <div class="row">
                <label style="font-weight: 500" for="inputName" class="col-sm-4 col-form-label">Golongan awal</label>
                <div class="col-sm-8">
                  <label style="font-weight: 400; border: 0;" class="form-control">
                    <input type="text" class="form-control bg-white" name="req_data_ctr" id="req_data_ctr" disabled>
                  </label>
                </div>
              </div> 
              <div class="row">
                <label style="font-weight: 500" for="inputName" class="col-sm-4 col-form-label">Golongan tujuan</label>
                <div class="col-sm-8">
                  <label style="font-weight: 400; border: 0;" class="form-control">
                    <input type="text" class="form-control bg-white" name="req_data_ctr_new" id="req_data_ctr_new" disabled>
                  </label>
                </div>
              </div>
              <div class="row">
                <label style="font-weight: 500" for="inputName" class="col-sm-4 col-form-label">Terhitung mulai tanggal</label>
                <div class="col-sm-8">
                  <label style="font-weight: 400; border: 0;" class="form-control">
                    <input type="text" class="form-control bg-white" name="req_data_tmt" id="req_data_tmt" disabled>
                  </label>
                </div>
              </div>
              <div class="row">
                <label style="font-weight: 500" for="inputName" class="col-sm-4 col-form-label">Tanggal pengajuan</label>
                <div class="col-sm-8">
                  <label style="font-weight: 400; border: 0;" class="form-control">
                    <input type="text" class="form-control bg-white" name="req_data_create" id="req_data_create" disabled>
                  </label>
                </div>
              </div>
            </div>
          </div>          
        </div>
        <div class="row mt-3">
          <label style="font-weight: 500" for="inputName" class="col-md-1 mr-5 col-form-label">Catatan SDM</label>
          <div class="col-md-10">
            <textarea class = "form-control bg-white" id="req_data_note" rows="3" style="resize: none; width:85%" disabled></textarea>
          </div>
        </div> 
        <div class="row mt-3">
          <label style="font-weight: 500" for="inputName" class="col-md-1 mr-5 col-form-label">Catatan Atasan<span class="text-danger">*</span></label>
          <div class="col-md-10">
            <textarea class = "form-control bg-white" id="spv_ukg_note" rows="3" style="resize: none; width:85%"></textarea>
            <span class="text-danger font-italic text-message spv_note" hidden>Silahkan isi catatan atasan </span>
          </div>
        </div>         
        <div class="row mt-5">
          <!-- <label style="font-weight: 500" for="inputName" class="col-md-2 col-form-label">Status Persetujuan</label> -->
          <div class="form-group col-md-10">
            <div class="row" id="ukg_approver">                
            </div>              
          </div>
        </div>
        <hr class="solid mt-3">
        <h6>Log aktivitas</h6>
        <div class="row">
          <ul class="sessions dev_log">
          </ul>
        </div>
        <div class="row mb-3"></div>
        <div class="modal-footer">
          <div class="float-right">
            <div class="action_btn"></div>            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>