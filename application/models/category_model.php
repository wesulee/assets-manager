<?php
class Category_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_category($id = FALSE)
	{
		if ($id === FALSE) {
			$query = $this->db->get('categories');
			return $query->result_array();
		}

		$query = $this->db->get_where('categories', array('id' => $id));
		return $query->row_array();
	}

	public function set_category()
	{
		$this->load->helper('url');

		$data = array(
			'name' => $this->input->post('name'),
			);

		return $this->db->insert('categories', $data);
	}

	// return options array used for form_dropdown()
	public function form_dropdown_options()
	{
		$options = array(0 => '(select category)');
		$query = $this->db->get('categories');

		foreach($query->result() as $row) {
			$options[$row->id] = $row->name;
		}

		return $options;
	}

	// returns TRUE only if category with given $id exists
	public function id_exists($id)
	{
		$query = $this->db->get_where('categories', array('id' => $id), 1);
		if ($query->num_rows() !== 0)
			return TRUE;
		else
			return FALSE;
	}

	// assumes $id exists
	public function id_to_name($id)
	{
		$query = $this->db->get_where('categories', array('id' => $id), 1);
		return $query->row()->name;
	}
}