<?php
class Category extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('category_model');
	}

	public function index()
	{
		$data['categories'] = $this->category_model->get_category();
		$data['title'] = 'All Categories';

		$this->load->view('templates/header', $data);
		$this->load->view('category/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($id)
	{
		$data['category'] = $this->category_model->get_category($id);
		
		if (empty($data['category']))
			show_404();

		$data['title'] = 'View category';

		// get assets
		$this->load->model('asset_model');
		$this->load->helper('asset_view');
		$data['assets'] = format_assets($this->asset_model->get_by_room_id($id));

		$this->load->view('templates/header', $data);
		$this->load->view('category/view', $data);
		$this->load->view('templates/footer');
	}

	public function create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Create a new category';

		$this->form_validation->set_rules('name', 'Name', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('category/create');
			$this->load->view('templates/footer');

		}
		else {
			$this->category_model->set_category();
			$this->load->view('category/success');
		}
	}
}