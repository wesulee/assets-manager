<?php
class Room extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('room_model');
	}

	public function index()
	{
		$data['rooms'] = $this->room_model->get_room();
		$data['title'] = 'All Rooms';

		$this->load->view('templates/header', $data);
		$this->load->view('room/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($id)
	{
		// get room info
		$data['room'] = $this->room_model->get_room($id);
		
		if (empty($data['room']))
			show_error('room does not exist');

		$data['title'] = 'View room';

		// get assets
		$this->load->model('asset_model');
		$this->load->helper('asset_view');
		$data['assets'] = format_assets($this->asset_model->get_by_room_id($id));

		$this->load->view('templates/header', $data);
		$this->load->view('room/view', $data);
		$this->load->view('templates/footer');
	}

	public function create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Create a new room';

		$this->form_validation->set_rules('name', 'Name', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('room/create');
			$this->load->view('templates/footer');

		}
		else {
			$this->room_model->set_room();
			$this->load->view('room/success');
		}
	}
}