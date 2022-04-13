<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Sundari Oktamiyunda | sundarioktamiyunda@gmail.com
 * @link            https://github.com/sundarioy
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class PersonalDevelopments extends CI_Model 
{
	public function getPositionsByOrganization($org_unit=NULL)
	{	
		$this->db->select('id, position');
		$this->db->from('positions');
		$this->db->where('org_unit', $org_unit);
		$query = $this->db->get();
		return $query;
	}

	public function getEmployeesByPosition($pos_id=NULL)
	{
		$this->db->select('e.id as id, e.name as name, ept.nip as nip, p.parent_id as spv_id');
		$this->db->from('employees as e');
		$this->db->join('employee_position as ep', 'ep.employee_id = e.id');
		$this->db->join('employee_pt as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ep.position_id');
		$this->db->where('ep.position_id', $pos_id);
		$this->db->where('ept.active_status', 1);
		$this->db->order_by('e.name', 'asc');
		$query = $this->db->get();
		return $query;
	}

	public function getEmployeeData($id=NULL)
	{
		$this->db->select('e.id as id, e.name as name, ept.nip as nip, p.id as pos_id, p.parent_id as spv_id');
		$this->db->from('employees as e');
		$this->db->join('employee_position as ep', 'ep.employee_id = e.id');
		$this->db->join('employee_pt as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ep.position_id');		
		$this->db->where('ep.position_id', $id);		
		$this->db->where('ept.active_status', 1);
		$this->db->order_by('e.name', 'asc');
		$query = $this->db->get();
		return $query;
	}

	/*public function getEmployeeSupervisor($id=NULL)
	{
		$this->db->select('e.id as id, e.name as name, ept.nip as nip, p.id as pos_id, p.parent_id as spv_id');
		$this->db->from('employees as e');
		$this->db->join('employee_position as ep', 'ep.employee_id = e.id');
		$this->db->join('employee_pt as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ep.position_id');		
		$this->db->where('e.id', $id);		
		$this->db->where('ept.active_status', 1);
		$this->db->order_by('e.name', 'asc');
		$query = $this->db->get();
		return $query;
	}*/

	public function getEmployeeCluster($id=NULL)
	{
		$this->db->select('e.id as id, ec.id as ctr_id, c.cluster as ctr_name, c.rank as ctr_rank');
		$this->db->from('employees as e');
		$this->db->join('employee_cluster as ec', 'e.id = ec.employee_id');
		$this->db->join('clusters as c', 'ec.cluster_id = c.id');
		$this->db->where('e.id', $id);
		$query = $this->db->get();
		return $query;
	}

	public function getEmployeePositions($id=NULL)
	{
		$this->db->select('ep.employee_id AS employee_id, o.org_unit, ep2.position_id as emp_pos_id, p2.id as pos_id, p2.position, p1.position AS parent_pos, ep2.employee_id AS spv_emp_id, e.name AS spv_name, p1.parent_id as spv_pos_id')->from('positions as p1');
		$this->db->join('positions as p2', 'p2.parent_id = p1.id');
		$this->db->join('employee_position as ep', 'ep.position_id = p2.id');
		$this->db->join('employee_position as ep2', 'ep2.position_id = p1.id');
		$this->db->join('employees as e', 'e.id = ep2.employee_id');
		$this->db->join('employee_pt as ept', 'ept.employee_id = e.id');	
		$this->db->join('organizations as o', 'o.id = p2.org_unit');		
		$this->db->where('ep.employee_id', $id);
		$this->db->where('ep.flag', TRUE);
		$this->db->where_in('ept.active_status', 1);
		$query = $this->db->get();
		return $query;
	}

	public function getUpkRequestDetail($id=NULL)
	{
		$this->db->select('dr.id, e.name, ept.nip as nip, p.position, o.org_unit, dr.par_value, dp.sdm_note, dp.created_at, p2.position AS pos_new, o2.org_unit AS org_new, ut.upk_type')->from('employee_dev_requests dr');
		$this->db->join('dev_detail_upk as dp', 'dr.id = dp.dev_request_id');
		$this->db->join('employees as e', 'e.id = dr.employee_id');
		$this->db->join('employee_pt as ept', 'ept.employee_id = dr.employee_id');
		$this->db->join('positions as p', 'p.id = dr.position_id', 'left');
		$this->db->join('upk_types as ut', 'ut.id = dp.upk_type');
		$this->db->join('organizations as o', 'o.id = dr.organization_id', 'left');
		$this->db->join('positions as p2', 'p2.id = dp.new_position_id', 'left');
		$this->db->join('organizations as o2', 'o2.id = dp.new_organization_id', 'left');		

		$this->db->where('dr.id', $id);
		$query = $this->db->get();
		return $query;
	}

	public function getUkgRequestDetail($id=NULL)
	{
		$this->db->select('dr.id, e.name, ept.nip as nip, p.position, o.org_unit, c.cluster as ctr_new, c.rank, dg.tmt, dg.sdm_note, dr.par_value, dg.created_at, c2.cluster as ctr_old ')->from('employee_dev_requests dr');
		$this->db->join('dev_detail_ukg as dg', 'dr.id = dg.dev_request_id');
		$this->db->join('employees as e', 'e.id = dr.employee_id');
		$this->db->join('employee_pt as ept', 'ept.employee_id = dr.employee_id');
		$this->db->join('positions as p', 'p.id = dr.position_id');
		$this->db->join('organizations as o', 'o.id = dr.organization_id');	
		$this->db->join('clusters as c', 'c.id = dg.cluster_id');
		$this->db->join('employee_cluster as ec', 'ec.employee_id = dr.employee_id', 'left');
		$this->db->join('clusters as c2', 'c2.id = ec.cluster_id', 'left');
		$this->db->where('dr.id', $id);
		$query = $this->db->get();
		return $query;
	}

	public function getRequestApprover($id=NULL)
	{
		$this->db->select('*')->from('approval_dev');
		$this->db->where('dev_request_id', $id);
		$query = $this->db->get();
		return $query;
	}

	public function getRequestApprovalStatus($id=NULL)
	{
		$this->db->select('dr.id, min(ad.level) AS level, (COUNT(ad.id) < count(ad.flag)) AS result')->from('approval_dev ad');
		$this->db->join('employee_dev_requests as dr', 'ad.dev_request_id = dr.id');
		$this->db->where('dr.id', $id);
		$this->db->group_by('ad.level');
		$query = $this->db->get();
		return $query;
	}

	public function checkLevelApproval($id,$lv) 
	{
		$sql = "SELECT (SELECT COUNT(level) FROM approval_dev WHERE dev_request_id = ? AND level = ?) = (SELECT COUNT(flag) FROM approval_dev WHERE dev_request_id = ? AND level = ? AND flag = 1) AS RESULT";
		$query = $this->db->query($sql, array($id, $lv, $id, $lv));
		return $query;
	}

	public function countApproverLevel($id,$lv) 
	{
		$sql = "SELECT COUNT(level) as result FROM approval_dev where dev_request_id = ? and level = ?";
		$query = $this->db->query($sql, array($id, $lv));
		return $query;
	}

	public function countApproverLevelApproved($id,$lv) 
	{
		$sql = "SELECT COUNT(level) as result FROM approval_dev where dev_request_id = ? and level = ? and flag = 1";
		$query = $this->db->query($sql, array($id, $lv));
		return $query;
	}

	public function getRequestLog($id=NULL)
	{
		$this->db->distinct();
		$this->db->select('adl.*')->from('approval_dev_logs adl');		
		$this->db->where('adl.dev_request_id', $id);
		$this->db->order_by('adl.created_at', 'desc');
		$query = $this->db->get();
		return $query;
	}

	public function getSpvApprovalStatus($id, $pid)
	{		
		$this->db->select('flag, comment, level')->from('approval_dev');
		$this->db->where('dev_request_id', $id);
		$this->db->where('approver_id', $pid);
		$query = $this->db->get();
		return $query;
	}

	public function updateApprovalDev($data,$where)
	{		
		$this->db->where($where);		
		return $this->db->update('approval_dev', $data);
	}

	public function getOrganizationByPosition($id)
	{
		$this->db->select('org_unit')->from('positions');
		$this->db->where('id', $id);		
		$query = $this->db->get()->row();
		return $query;
	}

	public function getEmployeePositionById($id)
	{
		$this->db->select('position_id')->from('employee_position');
		$this->db->where('employee_id', $id);		
		$query = $this->db->get();
		return $query;
	}

	public function getEmployeeSpv($id)
	{
		$this->db->select('p1.id as eid, p2.id, p2.parent_id, p2.position, e.name')->from('positions p1');
		$this->db->join('positions as p2', 'p1.parent_id = p2.id');
		$this->db->join('employee_position as ep', 'ep.position_id = p2.id ');
		$this->db->join('employees as e', 'e.id = ep.employee_id ');
		$this->db->join('employee_pt as ept', 'ept.employee_id = e.id');
		$this->db->where('p1.id', $id);
		$this->db->where('ep.flag', TRUE);
		$this->db->where('ept.active_status', 1); 
		$query = $this->db->get();
		return $query;
	}

	function getEmployeePositionsId($id)
	{
		$this->db->select('position_id')
		->from('employee_position')
		->where('employee_id', $id);
		$query = $this->db->get()->row();
		return $query;
	}

}
