<?php
class Room_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	// get an individual room
	public function get_room($id = FALSE)
	{
		if ($id === FALSE) {
			$query = $this->db->get('rooms');
			return $query->result_array();
		}

		$query = $this->db->get_where('rooms', array('id' => $id));
		return $query->row_array();
	}

	// create a new room
	public function set_room()
	{
		$this->load->helper('url');

		$data = array(
			'name' => $this->input->post('name'),
			);

		return $this->db->insert('rooms', $data);
	}

	// return options array used for form_dropdown()
	public function form_dropdown_options()
	{
		$options = array(0 => '(select room)');
		$query = $this->db->get('rooms');

		foreach($query->result() as $row) {
			$options[$row->id] = $row->name;
		}

		return $options;
	}

	// returns TRUE only if room with given $id exists
	public function id_exists($id)
	{
		$query = $this->db->get_where('rooms', array('id' => $id), 1);
		if ($query->num_rows() !== 0)
			return TRUE;
		else
			return FALSE;
	}

	// assumes $id exists
	public function id_to_name($id)
	{
		$query = $this->db->get_where('rooms', array('id' => $id), 1);
		return $query->row()->name;
	}
}