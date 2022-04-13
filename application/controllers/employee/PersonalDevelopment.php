<?php

/**
 * @author          Sundari Oktamiyunda | sundarioktamiyunda@gmail.com
 * @link            https://github.com/sundarioy
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class PersonalDevelopment extends MY_Controller
{
  protected $view = 'contents/employee/personal_development/';

  public function __construct()
  {
    parent::__construct();
    $this->authorization->employee();
    $this->load->model('employees');
    $this->load->model('personaldevelopments');
  }

  public function index()
  {
    $position = $this->session->userdata('position');

    $data['content']  = $this->view.'employee/content';
    $data['css']    = $this->view.'css';
    $data['javascript'] = $this->view.'javascript';
    $data['title']    = 'Daftar Pegawai';
    $data['sub_title']  = '';
    $data['notif']    = $this->general->countEmployeeAbsence();
    $data['promotion']  = $this->general->countEmployeePromotion();   
    $data['role']   = $this->db->select('*')->from('roles')->get();
    $data['users']    = $this->db->select('ep.employee_id, ep.nip, e.name, p.position, o.org_unit')
    ->from('employee_pt as ep')
    ->join('employees as e', 'e.id = ep.employee_id')
    ->join('employee_position as ept', 'ept.employee_id = ep.employee_id')
    ->join('positions as p', 'p.id = ept.position_id')
    ->join('organizations as o', 'o.id = p.org_unit')
    ->where('ept.flag', TRUE)
    ->where_in('p.parent_id', $position)
    ->group_by('ep.employee_id')
    ->get();

    $this->load->view('includes/main', $data);
  }

  public function show()
  {
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
    $pos_id = $this->general->getEmployeePosition($this->session->userdata('employee'))->position_id;
    $data['content']  = $this->view.'cluster/content';
    $data['css']    = $this->view.'css';
    $data['javascript'] = $this->view.'javascript';
    $data['title']    = 'Daftar Pengajuan Golongan Pegawai';
    $data['sub_title']  = '';
    $data['notif']    = $this->general->countEmployeeAbsence();
    $data['promotion']  = $this->general->countEmployeePromotion();
    $data['role']   = $this->db->select('*')->from('roles')->get();    
    $data['requests']    = $this->db->select('dr.id, dr.created_at, e.name, ept1.nip as nip, p1.position, o.org_unit, dr.dev_type, ad.flag')
    ->from('employee_dev_requests as dr')
    ->join('employees as e', 'e.id = dr.employee_id')
    ->join('employee_pt as ept1', 'ept1.employee_id = e.id')
    ->join('organizations as o', 'o.id = dr.organization_id', 'left')
    ->join('positions as p1', 'p1.id = dr.position_id', 'left')
    ->join('approval_dev as ad', 'dr.id = ad.dev_request_id')
    ->where('ad.approver_id', $pos_id)
    ->where('ad.flag !=', null)
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
    $data['role']   = $this->db->select('*')->from('roles')->get();   
    $this->load->view('includes/main', $data);
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

  public function loadRequestLog()
  {
    $id = $this->input->post('id',TRUE);
    $data = $this->personaldevelopments->getRequestLog($id)->result();  
    echo json_encode($data);
  }

  public function getSpvApprovalStatus()
  {
    $id = $this->input->post('id',TRUE);
    $pid = $this->input->post('pid',TRUE);
    $data = $this->personaldevelopments->getSpvApprovalStatus($id,$pid)->result();  
    echo json_encode($data);
  }

  public function updateApprovalStage()
  {    
    $id = $this->input->post('dr_id');
    $lv1 = $this->personaldevelopments->countApproverLevel($id,1)->result();
    $lv1_1 = $this->personaldevelopments->countApproverLevelApproved($id,1)->result();
    $lv2 = $this->personaldevelopments->countApproverLevel($id,2)->result();
    $lv2_1 = $this->personaldevelopments->countApproverLevelApproved($id,2)->result();
    $lv3 = $this->personaldevelopments->countApproverLevel($id,3)->result();
    $lv3_1 = $this->personaldevelopments->countApproverLevelApproved($id,3)->result();
    $lv4 = $this->personaldevelopments->countApproverLevel($id,4)->result();
    $lv4_1 = $this->personaldevelopments->countApproverLevelApproved($id,4)->result();

    echo json_encode([$lv2[0]->result,$lv2_1[0]->result,$lv3[0]->result,$lv3_1[0]->result]); 

    if ($lv1[0]->result == $lv1_1[0]->result) {
      if ($lv2_1[0]->result == 0) {
        $this->db->set('flag', 2);
        $this->db->where('dev_request_id', $id);
        $this->db->where('level', 2);  
        $this->db->update('approval_dev');
      } elseif ($lv2_1[0]->result != 0 ) {
        $this->db->set('flag', 2);
        $this->db->where('dev_request_id', $id);
        $this->db->where('level', 2);  
        $this->db->where('flag', null);
        $this->db->update('approval_dev');
      }      
    } 
    if ($lv2[0]->result == $lv2_1[0]->result) {
      if ($lv3_1[0]->result == 0) {
        $this->db->set('flag', 2);
        $this->db->where('dev_request_id', $id);
        $this->db->where('level', 3);  
        $this->db->update('approval_dev');
      } 
    }
    if ($lv3[0]->result == $lv3_1[0]->result) {
      if ($lv4_1[0]->result == 0) {
        $this->db->set('flag', 2);
        $this->db->where('dev_request_id', $id);
        $this->db->where('level', 4);  
        $this->db->update('approval_dev');
      } 
    }    
  }

  public function updateApprovalDev()
  {
    date_default_timezone_set('Asia/Jakarta'); 
    $now = date('Y-m-d H:i:s');

    $desc=NULL;
    $dt = $this->input->post('dt');
    $flag = $this->input->post('flag');
    
    if ($dt==1) {
      if ($flag==1) {
        $desc = '(Atasan) menyetujui pengajuan UPK';
      } else {
        $desc = '(Atasan) menolak pengajuan UPK';
      }
    } else {
      if ($flag==1) {
        $desc = '(Atasan) menyetujui pengajuan UKG';
      } else {
        $desc = '(Atasan) menolak pengajuan UKG';
      }
    }

    $data_log = array(
      'dev_request_id' => $this->input->post('dr_id'),
      'employee_name' => $this->authorization->getUser($this->session->userdata('employee'))->name,
      'description' => $desc,
      'comment' => $this->input->post('comment'),
    );
    $this->db->insert('approval_dev_logs', $data_log);

    $this->db->set('comment', $this->input->post('comment'));
    $this->db->set('flag', $flag);
    $this->db->set('updated_at', $now);
    $this->db->where('dev_request_id', $this->input->post('dr_id'));
    $this->db->where('approver_id', $this->input->post('apr_id'));   

    if($this->db->update('approval_dev')) {      
      echo json_encode(1);
    } else {
      echo json_encode(0);  
    }
  }
}

