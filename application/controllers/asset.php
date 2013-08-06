<?php
class Asset extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('asset_model');
	}

	public function index()
	{
		$data['assets'] = $this->asset_model->get_assets();
		$data['title'] = 'All Assets';

		// get categories
		$this->load->model('category_model');
		$data['categories'] = $this->category_model->form_dropdown_options();

		$this->load->view('templates/header', $data);
		$this->load->view('asset/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($id)
	{
		$data['asset'] = $this->asset_model->get_assets($id);
		
		if (empty($data['asset']))
			show_404();

		// convert category_id to name
		$this->load->model('category_model');
		$data['asset']['category'] = $this->category_model->id_to_name($data['asset']['category_id']);

		// convert room_id to name
		if (empty($data['asset']['room_id'])) {
			$data['asset']['room'] = '-'; 	// default room name display when no room assigned
		}
		else {
			$this->load->model('room_model');
			$data['asset']['room'] = $this->room_model->id_to_name($data['asset']['room_id']);
		}

		$data['title'] = 'View asset item';

		$this->load->view('templates/header', $data);
		$this->load->view('asset/view', $data);
		$this->load->view('templates/footer');
	}

	public function create()
	{
		// load categories (required field)
		$this->load->model('category_model');
		$data['categories'] = $this->category_model->form_dropdown_options();

		// load rooms
		$this->load->model('room_model');
		$data['rooms'] = $this->room_model->form_dropdown_options();

		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Create an asset item';

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('available', 'Availability', 'required');
		$this->form_validation->set_rules('category_id', 'Category ID', 'callback_validate_category_id'); 	// add required
		$this->form_validation->set_message('validate_category_id', 'Invalid category ID');
		$this->form_validation->set_rules('room_id', 'Room ID', 'callback_validate_room_id'); 	// add required
		$this->form_validation->set_message('validate_room_id', 'Invalid room ID');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('asset/create');
			$this->load->view('templates/footer');
		}
		else {
			$this->asset_model->set_asset();
			$this->load->view('asset/success');
		}
	}

	// makes sure that category_id exists (required)
	public function validate_category_id($id)
	{
		$id = intval($id);
		$this->load->model('category_model');
		return $this->category_model->id_exists($id);
	}

	// makes sure room_id is valid or 0 (0 means no room)
	public function validate_room_id($id)
	{
		$id = intval($id);
		if ($id === 0)
			return TRUE;

		$this->load->model('room_model');
		return $this->room_model->id_exists($id);
	}
}