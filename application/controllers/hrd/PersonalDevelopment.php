<?php

/**
 * @author          Sundari Oktamiyunda | sundarioktamiyunda@gmail.com
 * @link            https://github.com/sundarioy
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class PersonalDevelopment extends MY_Controller
{
  protected $view = 'contents/hrd/personal_development/';

  public function __construct()
  {
    parent::__construct();
    $this->authorization->hrd();
    $this->load->model('personaldevelopments');
    $this->load->model('employees');
  }

  public function index()
  {
    $data['content']  = $this->view.'employee/content';
    $data['css']    = $this->view.'css';
    $data['javascript'] = $this->view.'javascript';
    $data['title']    = 'Daftar Pegawai';
    $data['sub_title']  = '';
    $data['notif']    = $this->general->countEmployeeAbsence();
    $data['promotion']  = $this->general->countEmployeePromotion();   
    $data['role']   = $this->db->select('*')->from('roles')->get();
    $data['users']    = $this->db->select('ep.employee_id, e.name, ep.nip, p.position, org.org_unit')->
    from('employee_pt as ep')->join('employees as e', 'e.id = ep.user_id')->
    join('employee_position as es', 'es.employee_id = ep.employee_id')->
    join('positions as p', 'p.id = es.position_id')->     
    join('organizations as org', 'org.id = p.org_unit')->
    get();
    $this->load->view('includes/main', $data);
  }

  public function show() {
    $id = $this->uri->segment(4);
    
    $data['content']    = $this->view.'employee/detail';
    $data['css']      = $this->view.'css';
    $data['javascript']   = $this->view.'javascript';
    $data['title']      = 'Data Pegawai';
    $data['sub_title']    = '';
    $data['data']     = $this->employees->showEmployee($id)->row();
    $data['message']    = '';
    $data['notif']      = $this->general->countEmployeeAbsence();
    $data['promotion']    = $this->general->countEmployeePromotion();
    $data['organizations']  = $this->employees->showEmployeeOrgUnit($id);
    $data['educations']   = $this->employees->showEmployeeEducation($id);

    $mulai    = $data['data']->join_date;
    $selesai  = date('Y-m-d', strtotime(date('Y-m-d', strtotime($mulai)). " + 1 year"));
    $selesai  = date('Y-m-d', strtotime(date('Y-m-d', strtotime($selesai)). " - 1 day"));
    $diff     = abs(strtotime(date('Y-m-d')) - strtotime($mulai));
    $years    = floor($diff / (365*60*60*24));
    $periode  = array();

    for ($i=0; $i <= $years ; $i++) { 
      if ($i > 0) {
        $mulai =  date('Y-m-d', strtotime(date('Y-m-d', strtotime($mulai)). " + 1 year"));
        $selesai = date('Y-m-d', strtotime(date('Y-m-d', strtotime($selesai)). " + 1 year"));
      }

      $join['start'] = $mulai;
      $join['end'] = $selesai;
      array_push($periode, $join);
    }

    $data['period'] = $periode;

    $start = NULL;
    $end = NULL;

    if (isset($_GET['period'])) {
      $date = explode(' - ', $_GET['period']);
      $start = date('Y-m-d', strtotime($date[0]));
      if (isset($date[1])) {
        $end = date('Y-m-d', strtotime($date[1]));
      }
    }

    $data['leaves']   = $this->employees->showEmployeeLeave($id, $start, $end);   
    $count_leave    = $this->employees->showEmployeeLeave($id, $start, $end, 2);
    $sum = 0;
    foreach ($count_leave->result() as $key) {
      $awal = new DateTime($key->start);
      $akhir = new DateTime($key->finish);
      $interval = $awal->diff($akhir);
      $elapsed = $interval->format('%d');
      if ($key->type == 'Cuti') {
        $sum = $sum + $elapsed + 1;
      }
    }

    $data['count_leave'] = $sum;
    $data['position_history'] = $this->employees->getEmployeePositionHistory($id);

    $this->load->view('includes/main', $data);
  }

  public function cluster()
  {
    $data['content']  = $this->view.'cluster/content';
    $data['css']    = $this->view.'css';
    $data['javascript'] = $this->view.'javascript';
    $data['title']    = 'Daftar Pengajuan Golongan Pegawai';
    $data['sub_title']  = '';
    $data['notif']    = $this->general->countEmployeeAbsence();
    $data['promotion']  = $this->general->countEmployeePromotion();
    $data['role']   = $this->db->select('*')->from('roles')->get();
    $data['requests']    = $this->db->select('dr.id AS req_id, dr.created_at, e.name, ept.nip as nip, p.position, o.org_unit, dr.dev_type, 
       case 
        when (SELECT COUNT(flag) FROM approval_dev WHERE dev_request_id = req_id and flag = 0) != 0 then "Ditolak"
        when (SELECT MAX(flag) = 2 FROM approval_dev WHERE dev_request_id = req_id ) then "Proses Persetujuan"
        when (SELECT MAX(flag) = 1 FROM approval_dev WHERE dev_request_id = req_id ) then "Disetujui"
      END AS sum_flag')
    ->from('employee_dev_requests as dr')
    ->join('employees as e', 'e.id = dr.employee_id')
    ->join('employee_pt as ept', 'ept.employee_id = e.id')
    ->join('organizations as o', 'o.id = dr.organization_id')
    ->join('positions as p', 'p.id = dr.position_id')    
    ->order_by('dr.updated_at', 'desc')
    ->get();

    $this->load->view('includes/main', $data);
  }

  public function addcluster()
  {
    $data['content']  = $this->view.'cluster/create';
    $data['css']    = $this->view.'css';
    $data['javascript'] = $this->view.'javascript';
    $data['title']    = 'Rencana Pengembangan Pekerja';
    $data['sub_title']  = '';
    $data['notif']    = $this->general->countEmployeeAbsence();
    $data['promotion']  = $this->general->countEmployeePromotion();   
    $data['organizations'] = $this->db->select('id, org_unit')->from('organizations')->get();
    $data['positions'] = $this->db->select('id, position')->from('positions')->get(); 
    $data['clusters'] = $this->db->select('id, cluster')->from('clusters')->get();
    $data['role']   = $this->db->select('*')->from('roles')->get();   
    $this->load->view('includes/main', $data);
  }

  public function loadPositionsValue() {
    $org_unit = $this->input->post('id',TRUE);
    $data = $this->personaldevelopments->getPositionsByOrganization($org_unit)->result();
    echo json_encode($data);
  }

  public function loadEmployeesValue() {
    $pos_id = $this->input->post('id',TRUE);
    $data = $this->personaldevelopments->getEmployeesByPosition($pos_id)->result();   
    echo json_encode($data);
  }

  public function loadEmployeeData() {
    $id = $this->input->post('id',TRUE);
    $org_id = $this->input->post('org_id',TRUE);
    $data = $this->personaldevelopments->getEmployeeData($id)->result();    
    echo json_encode($data);
  }

  public function loadEmployeeCluster() {
    $id = $this->input->post('id',TRUE);
    $data = $this->personaldevelopments->getEmployeeCluster($id)->result();   
    echo json_encode($data);
  }

  public function loadEmployeePositions() {
    $id = $this->input->post('id',TRUE);    
    $data = $this->personaldevelopments->getEmployeePositions($id)->result();   
    echo json_encode($data);
  }

  public function createRequestUPK()
  {
    $new_org=0;
    $data = array(
      'requestor' => $this->session->userdata('id'),
      'employee_id' => $this->input->post('emp_id'),
      'par_value' => $this->input->post('par'),
      'organization_id' => $this->input->post('org'),
      'position_id' => $this->input->post('pos'),
      'dev_type' => $this->input->post('dev_type'),
      'created_by' => $this->session->userdata('id'),
      'updated_by' => $this->session->userdata('id')
    );

    $this->db->insert('employee_dev_requests', $data);
    $last_id = $this->db->insert_id();

    $data_approver = array(
      'dev_request_id' => $last_id,
      'approver_id' => $this->input->post('spv_pos_id'),
      'approver_name' => $this->input->post('spv_name'),
      'flag' => 2,
    );
    $this->db->insert('approval_dev', $data_approver);

    if ($this->input->post('upk_type') == 2 || $this->input->post('upk_type') == 3) {
      $temp = $this->personaldevelopments->getOrganizationByPosition($this->input->post('new_pos'));
      $new_org = $temp->org_unit;
    } else if ($this->input->post('upk_type') == 4) {
      $new_org = $this->input->post('new_org');
    }

    $data_detail = array(
      'dev_request_id' => $last_id,
      'upk_type' => $this->input->post('upk_type'),
      'new_organization_id' => $new_org,
      'new_position_id' => $this->input->post('new_pos'),
      'sdm_note' => $this->input->post('sdm_note'),
      'created_by' => $this->session->userdata('id'),
      'updated_by' => $this->session->userdata('id')      
    );

    $data_log = array(
      'dev_request_id' => $last_id,
      'employee_name' => $this->authorization->getUser($this->session->userdata('employee'))->name,
      'description' => '(SDM) membuat pengajuan UPK',
      'comment' => $this->input->post('sdm_note'),
    );
    $this->db->insert('approval_dev_logs', $data_log);

    if ($this->db->insert('dev_detail_upk', $data_detail)) {
      echo json_encode(1);
    } else {
      echo json_encode(0);
    }     
  }

  public function createRequestUKG()
  {
    $data = array(
      'requestor' => $this->session->userdata('id'),
      'employee_id' => $this->input->post('emp_id'),
      'par_value' => $this->input->post('par'),
      'organization_id' => $this->input->post('org'),
      'position_id' => $this->input->post('pos'),
      'dev_type' => $this->input->post('dev_type'),
      'created_by' => $this->session->userdata('id'),
      'updated_by' => $this->session->userdata('id')      
    );

    $this->db->insert('employee_dev_requests', $data);
    $last_id = $this->db->insert_id();
    $tmt_temp = strtr($this->input->post('tmt'), '/', '-');

    $appr = json_decode(stripslashes($this->input->post('approvers')));
    foreach ($appr as $val) {
      $data_approver = array(
        'dev_request_id' => $last_id,
        'approver_id' => $val->spv_position_id,
        'approver_name' => $val->spv_name,
        'level' => $val->level,
        'child' => $val->child,
      );
      $this->db->insert('approval_dev', $data_approver);
    }

    $this->db->set('flag', 2);
    $this->db->where('dev_request_id', $last_id);
    $this->db->where('level', 1);
    $this->db->update('approval_dev');

    $data_detail = array(
      'dev_request_id' => $last_id,
      'cluster_id' => $this->input->post('ctr'),
      'tmt' => date('Y-m-d', strtotime($this->input->post('tmt'))),
      'sdm_note' => $this->input->post('sdm_note'),
      'created_by' => $this->session->userdata('id'),
      'updated_by' => $this->session->userdata('id')      
    );

    $data_log = array(
      'dev_request_id' => $last_id,
      'employee_name' => $this->authorization->getUser($this->session->userdata('employee'))->name,
      'description' => 'membuat pengajuan UKG',
      'comment' => $this->input->post('sdm_note'),
    );
    $this->db->insert('approval_dev_logs', $data_log);

    if ($this->db->insert('dev_detail_ukg', $data_detail)) {
      echo json_encode(1);
    } else {
      echo json_encode(0);
    } 
  }

  public function loadRequest()
  {
    $id = $this->input->post('id',TRUE);
    $dev_type = $this->input->post('dev_type',TRUE);
    if ($dev_type == 'UPK') {
      $data = $this->personaldevelopments->getUpkRequestDetail($id)->result();  
    } else {
      $data = $this->personaldevelopments->getUkgRequestDetail($id)->result();  
    }       
    echo json_encode($data);
  }

  public function loadUpkRequestApprover()
  {
    $id = $this->input->post('id',TRUE);
    $data = $this->personaldevelopments->getRequestApprover($id)->result();  
    echo json_encode($data);
  }

  public function loadUkgRequestApprover()
  {
    $id = $this->input->post('id',TRUE);
    $data = $this->personaldevelopments->getRequestApprover($id)->result();  
    echo json_encode($data);
  }

  public function loadRequestLog()
  {
    $id = $this->input->post('id',TRUE);
    $data = $this->personaldevelopments->getRequestLog($id)->result();  
    echo json_encode($data);
  }

  public function loadApprovalStatus()
  {
    $id = $this->input->post('id',TRUE);
    $data = $this->personaldevelopments->getRequestApprovalStatus($id)->result();  
    echo json_encode($data);
  }

  public function updateUpk()
  {
    $id = $this->uri->segment(4);
    $data['content']  = $this->view.'cluster/update_upk';
    $data['css']    = $this->view.'css';
    $data['javascript'] = $this->view.'javascript';
    $data['title']    = 'Rencana Pengembangan Pekerja';
    $data['sub_title']  = '';
    $data['notif']    = $this->general->countEmployeeAbsence();
    $data['promotion']  = $this->general->countEmployeePromotion();   
    $data['organizations'] = $this->db->select('id, org_unit')->from('organizations')->get();
    $data['positions'] = $this->db->select('id, position')->from('positions')->get(); 
    $data['clusters'] = $this->db->select('id, cluster')->from('clusters')->get();
    $data['role']   = $this->db->select('*')->from('roles')->get();   
    $data['request'] = $this->db->
    select('edr.*, ad.approver_name, p.position, o.org_unit, e.name, ept.nip, ddk.*')->
    from('employee_dev_requests edr')->
    join('organizations as o', 'o.id = edr.organization_id')->
    join('positions as p', 'p.id = edr.position_id')->
    join('employees as e', 'e.id = edr.employee_id')->
    join('employee_pt as ept', 'ept.employee_id = e.id')->
    join('approval_dev as ad', 'ad.dev_request_id = edr.id')->
    join('dev_detail_upk as ddk', 'ddk.dev_request_id = edr.id')->    
    where('edr.id', $id)->get()->row();

    $this->load->view('includes/main', $data);
  }

  public function updateUkg()
  {
    $id = $this->uri->segment(4);
    $data['content']  = $this->view.'cluster/update_ukg';
    $data['css']    = $this->view.'css';
    $data['javascript'] = $this->view.'javascript';
    $data['title']    = 'Rencana Pengembangan Pekerja';
    $data['sub_title']  = '';
    $data['notif']    = $this->general->countEmployeeAbsence();
    $data['promotion']  = $this->general->countEmployeePromotion();   
    $data['organizations'] = $this->db->select('id, org_unit')->from('organizations')->get();
    $data['positions'] = $this->db->select('id, position')->from('positions')->get(); 
    $data['clusters'] = $this->db->select('id, cluster')->from('clusters')->get();
    $data['role']   = $this->db->select('*')->from('roles')->get();   
    $data['request'] = $this->db->
    select('edr.*, ad.approver_name, p.position, o.org_unit, e.name, ept.nip, ddk.*, c.*')->
    from('employee_dev_requests edr')->
    join('organizations as o', 'o.id = edr.organization_id')->
    join('positions as p', 'p.id = edr.position_id')->
    join('employees as e', 'e.id = edr.employee_id')->
    join('employee_pt as ept', 'ept.employee_id = e.id')->
    join('approval_dev as ad', 'ad.dev_request_id = edr.id')->
    join('dev_detail_ukg as ddk', 'ddk.dev_request_id = edr.id')->     
    join('employee_cluster as ec', 'ec.employee_id = edr.employee_id')->     
    join('clusters as c', 'c.id = ec.cluster_id')->
    where('edr.id', $id)->get()->row();

    $this->load->view('includes/main', $data);
  }

  public function updateRequestUPK()
  {
    $new_org = 0;
    $temp = NULL;

    $this->db->set('par_value', $this->input->post('par'));
    $this->db->set('updated_at', 'NOW()', false);
    $this->db->set('updated_by', $this->session->userdata('id'));
    $this->db->where('id', $this->input->post('req_id'));
    $this->db->update('employee_dev_requests');

    $this->db->set('comment', null);
    $this->db->set('flag', 2);
    $this->db->set('updated_at', 'NOW()', false);
    $this->db->where('dev_request_id', $this->input->post('req_id'));
    $this->db->update('approval_dev');
    
    if ($this->input->post('upk_type') == 2 || $this->input->post('upk_type') == 3) {
      $temp = $this->personaldevelopments->getOrganizationByPosition($this->input->post('new_pos'));
      $new_org = $temp->org_unit;
    } else if ($this->input->post('upk_type') == 4) {
      $new_org = $this->input->post('new_org');
    }

    $this->db->set('upk_type', $this->input->post('upk_type'));          
    $this->db->set('new_organization_id', $new_org);
    $this->db->set('new_position_id', $this->input->post('new_pos'));  
    $this->db->set('sdm_note', $this->input->post('sdm_note'));    
    $this->db->where('dev_request_id', $this->input->post('req_id'));   
    $this->db->update('dev_detail_upk'); 

    $data_log = array(
      'dev_request_id' => $this->input->post('req_id'),
      'employee_name' => $this->authorization->getUser($this->session->userdata('employee'))->name,
      'description' => '(SDM) membuat perubahan pengajuan UPK',
      'comment' => $this->input->post('sdm_note'),
    );   
    if ($this->db->insert('approval_dev_logs', $data_log)) {
      echo json_encode(1);
    } else {
      echo json_encode(0);
    }     
    
  }

  public function updateRequestUKG()
  {
    $this->db->set('par_value', $this->input->post('par'));
    $this->db->set('updated_at', 'NOW()', false);
    $this->db->set('updated_by', $this->session->userdata('id'));
    $this->db->where('id', $this->input->post('req_id'));
    $this->db->update('employee_dev_requests');

    $this->db->set('comment', null);
    $this->db->set('flag', 2);    
    $this->db->set('updated_at', 'NOW()', false);
    $this->db->where('dev_request_id', $this->input->post('req_id'));
    $this->db->where('level', 1);
    $this->db->update('approval_dev');

    $this->db->set('comment', null);
    $this->db->set('flag', null);
    $this->db->set('updated_at', 'NOW()', false);
    $this->db->where('dev_request_id', $this->input->post('req_id'));
    $this->db->where('level !=', 1);
    $this->db->update('approval_dev');
        
    $this->db->set('cluster_id', $this->input->post('ctr'));          
    $this->db->set('tmt', date('Y-m-d', strtotime($this->input->post('tmt'))));  
    $this->db->set('sdm_note', $this->input->post('sdm_note'));    
    $this->db->where('dev_request_id', $this->input->post('req_id'));   
    $this->db->update('dev_detail_ukg'); 

    $data_log = array(
      'dev_request_id' => $this->input->post('req_id'),
      'employee_name' => $this->authorization->getUser($this->session->userdata('employee'))->name,
      'description' => '(SDM) membuat perubahan pengajuan UGK',
      'comment' => $this->input->post('sdm_note'),
    );   
    if ($this->db->insert('approval_dev_logs', $data_log)) {
      echo json_encode(1);
    } else {
      echo json_encode(0);
    }     
    
  }

  public function loadPositionId()
  {
    $id = $this->input->post('id',TRUE);
    $data = $this->personaldevelopments->getEmployeePositionById($id)->result();
    echo json_encode($data); 
  }

  public function loadApprover()
  {
    $id = $this->input->post('id',TRUE);    
    $data = $this->personaldevelopments->getEmployeeSpv($id)->result();
    echo json_encode($data);
  }

  

  // public function loadApproverApproveStatus()
  // {
  //   $req_id = $this->input->post('id',TRUE);
  //   $apr_id = $this->input->post('apr_id',TRUE);
  //   $data = $this->personaldevelopments->getApproverApprovalStatus($req_id,$apr_id)->result();
  //   echo json_encode($data);
  // }

}
