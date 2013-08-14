<?php
class Asset_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_assets($id = FALSE)
	{
		if ($id === FALSE) {
			$query = $this->db->get('assets');
			return $query->result_array();
		}

		$query = $this->db->get_where('assets', array('id' => $id), 1);
		return $query->row_array();
	}

	public function set_asset()
	{
		$this->load->helper('url');

		$available = $this->input->post('available') == 1 ? TRUE : FALSE;
		$room_id = intval($this->input->post('room_id'));
		$room_id = $room_id == 0 ? NULL : $room_id;

		$data = array(
			'name'        => $this->input->post('name'),
			'available'   => $available,
			'category_id' => $this->input->post('category_id'),
			'room_id'     => $room_id,
			'note'        => $this->input->post('note')
			);

		return $this->db->insert('assets', $data);
	}

	// returns TRUE only if asset with given $id exists, else FALSE
	public function id_exists($id)
	{
		$query = $this->db->get_where('assets', array('id' => $id), 1);
		if ($query->num_rows() !== 0)
			return TRUE;
		else
			return FALSE;
	}

	public function delete($id)
	{
		return $this->db->delete('assets', array('id' => $id));
	}

	public function get_where($params)
	{
		$query = $this->db->get_where('assets', $params);
		return $query->result_array();
	}

	public function get_by_room_id($id)
	{
		return self::get_by_column('room_id', $id);
	}

	public function get_by_category_id($id)
	{
		return self::get_by_column('category_id', $id);
	}

	// returns an array of rows
	// $limit should be NULL (no limit) or integer
	private function get_by_column($column_name, $column_value, $limit=NULL)
	{
		if (is_null($limit))
			$query = $this->db->get_where('assets', array($column_name => $column_value));
		else
			$query = $this->db->get_where('assets', array($column_name => $column_value), $limit);

		return $query->result_array();
	}
}