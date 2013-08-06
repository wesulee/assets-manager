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
			);

		return $this->db->insert('assets', $data);
	}
}