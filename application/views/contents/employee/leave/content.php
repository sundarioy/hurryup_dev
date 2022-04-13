      <link href='<?php echo base_url() ?>assets/admin/plugins/fullcalendar5/main.css' rel='stylesheet' />
        <script src='<?php echo base_url() ?>assets/admin/plugins/fullcalendar5/main.js'></script>
        <!-- <script src='<?php echo base_url() ?>assets/admin/plugins/fullcalendar5/locales-all.js'></script> -->
        <script>

        var events = <?php echo json_encode($calendar); ?>

        var date = new Date()
        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()

        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
          },
          // initialView:'timeGridWeek',
          initialDate: new Date(y, m, d),
          buttonIcons: false, // show the prev/next text
          weekNumbers: true,
          navLinks: true, // can click day/week names to navigate views
          editable: false,
          dayMaxEvents: true, // allow "more" link when too many events
          events: events
        });

        calendar.render();
      });

        </script>

      <div class="row">
        <div class="col-md-12">
            <div class="card-body">
              <form action="<?php echo base_url() ?>employee/leave" method="GET">
                <div style="padding-top: 0px; padding-left:  0px; padding-right: 0px;" class="card-body">
                <div class="row">
                  <div class="col-md-6">                    
                    <div class="form-group">
                      <label>Tanggal</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" id="range-cuti" name="date" class="form-control float-right" value="<?php if (isset($_GET['date'])) { echo $_GET['date']; } ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Approval</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-tags"></i>
                          </span>
                        </div>
                        <select class="form-control" name="approval">
                          <option <?php echo (isset($_GET['approval'])) ? 'selected': ''; ?>>Semua</option>
                          <?php foreach ($this->db->get('approval_status')->result() as $value): ?>
                            <option <?php echo (isset($_GET['approval']) && $_GET['approval'] == $value->id) ? 'selected': ''; ?> value="<?php echo $value->id ?>"><?php echo $value->status ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>                    
                  </div>
                </div>

                </div>
                  <div class="float-left">
                    <a href="" class="btn btn-success create-data" data-target="#modal-add-data" data-toggle="modal"><span class="fa fa-leaf"></span> &nbsp;Ajukan Izin Kerja</a>
                  </div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> &nbsp;Cari</button>
                  </div>
              </form>
            <?php $this->load->view('contents/employee/leave/create') ?>
            </div>
        </div>

        <?php if (isset($_GET['group']) || isset($_GET['approval'])): ?>
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%" class="center">No</th>
                  <th class="center">Keperluan</th>
                  <th class="center">Tanggal</th>
                  <th class="center">Jenis</th>
                  <th class="center">Approval</th>
                  <th style="width: 10%" class="center"></th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($data->result() as $value) { 

                  switch ($value->status) {
                    case 'Approved':
                      $color = 'btn-success';
                      break;
                    
                    case 'Rejected':
                      $color = 'btn-danger';
                      break;
                    
                    case 'Waiting for Approval':
                      $color = 'btn-primary';
                      break;
                    
                    case 'Cancelled':
                      $color = 'btn-secondary';
                      break;
                    
                    case 'Reported':
                      $color = 'btn-warning';
                      break;

                    default:
                      $color = 'btn-info';
                      break;
                  }
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $value->description ?></td>
                  <td class="center"><?php echo date('j F Y', strtotime($value->start)) ?> s/d <?php echo date('j F Y', strtotime($value->finish)) ?></td>
                  <td class="center"><?php echo $value->type ?></td>
                  <td class="center"><span class="btn <?php echo $color ?> btn-xs"><?php echo $value->status ?></span></td>
                  <td class="center">
                    <?php $dates = str_replace(' ', '+', $_GET['date']); ?>
                    <a href="<?php echo base_url() ?>employee/leave/show/<?php echo $value->id.'/url?date='.$dates.'&approval='.$_GET['approval'] ?>" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
                    <?php if ($value->approval == 1 || $value->approval == 4): ?>
                      <a href="<?php echo base_url() ?>employee/leave/cancel/<?php echo $value->id.'/url?date='.$dates.'&approval='.$_GET['approval'] ?>" class="btn btn-danger btn-xs delete-confirmation"><i class="fa fa-times" aria-hidden="true"></i></a>
                    <?php endif ?>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>          
        <?php endif ?>

        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              
              <div id="calendar"></div>
            </div>
          </div>
        </div>

      </div>