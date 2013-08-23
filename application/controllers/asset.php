<?php
class Asset extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
			redirect('auth/login');
		
		$this->load->model('asset_model');
	}

	public function index()
	{
		$data['title'] = 'All Assets';

		// for every asset: truncate 'note' and create HTML for delete button
		$this->load->helper('asset_view');
		$data['assets'] = format_assets($this->asset_model->get_assets());

		// get categories
		$this->load->model('category_model');
		$data['categories'] = $this->category_model->form_dropdown_options();

		// get rooms
		$this->load->model('room_model');
		$data['rooms'] = $this->room_model->all();

		// get users
		$data['users'] = $this->ion_auth->get_all_users();


		$this->load->view('templates/header', $data);
		$this->load->view('asset/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($id)
	{
		$data['asset'] = $this->asset_model->get_assets($id);
		
		if (empty($data['asset']))
			show_404();

		$data['title'] = 'View asset item';

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

		$this->load->view('templates/header', $data);
		$this->load->view('asset/view', $data);
		$this->load->view('templates/footer');
	}

	public function create()
	{
		$data['title'] = 'Create an asset item';

		// load categories (required field)
		$this->load->model('category_model');
		$data['categories'] = $this->category_model->form_dropdown_options();

		// load rooms
		$this->load->model('room_model');
		$data['rooms'] = $this->room_model->form_dropdown_options();

		// settings for fields
		$data['note_settings'] = array(
			'name' => 'note',
			'rows' => 6,
			'cols' => 30,
			);

		// validate
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('available', 'Availability', 'required');
		$this->form_validation->set_rules('category_id', 'Category ID', 'callback__create_validate_category_id'); 	// add required
		$this->form_validation->set_rules('room_id', 'Room ID', 'callback__create_validate_room_id');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('asset/create');
			$this->load->view('templates/footer');
		}
		else {
			$this->asset_model->set_asset($this->session->userdata('user_id'));
			$this->load->view('asset/success');
		}
	}

	// delete an asset
	// POST uri should look like asset/delete/id
	public function delete()
	{
		// make sure that this is called through POST
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			redirect(); 	// redirect to root
		}

		$id = $this->uri->segment(3);
		if (empty($id)) {
			// no id POSTed
			show_error('no id given for asset!');
			return;
		}

		$exists = $this->asset_model->id_exists($id);

		if ($exists) {
			// $id exists, delete it
			if ($this->asset_model->delete($id)) {
				// successfully deleted
				redirect('asset/index');
			}
			else {
				// unable to delete from db
				show_error('unable to delete asset');
			}
		}
		else {
			show_error('id does not exist');
		}
	}

	public function filter()
	{
		$data['title'] = 'Filter Assets';
		// display filter errors in view
		$errors = array();

		// load helper functions
		$this->load->helper('asset_view');
		$this->load->helper('asset_filter');

		// load models and get relevant data from models
		$this->load->model('category_model');
		$this->load->model('room_model');
		$data['categories'] = $this->category_model->form_dropdown_options();
		$data['rooms'] = $this->room_model->all();
		$data['users'] = $this->ion_auth->get_all_users();

		// retrieve all $_GET variables
		$GET = $this->input->get(NULL, TRUE);

		// when no GET params given, it will be FALSE
		// change to empty array if FALSE
		if ($GET === FALSE)
			$GET = array();

		// $filter will be passed to model
		// column_name => column_value
		$filter = array();
		// default value selected for dropdown menus
		$dropdown_selected = array(
			'available' => -1,
			'category'  =>  0,
			'room'      =>  0,
			);

		// validate GET parameters and create dropdown select settings

		if (isset($GET['available']) && is_whole_number($GET['available'])) {
			if ($GET['available'] == '0' || $GET['available'] == '1') {
				$filter['available'] = $GET['available'];
				$dropdown_selected['available'] = $GET['available'];
			}
			else {
				$errors[] = 'Invalid available parameter: '.$GET['available'];
			}
		}
		if (isset($GET['category']) && is_whole_number($GET['category']) && $GET['category'] != '0') {
			// validate that category exists
			if ($this->category_model->id_exists($GET['category'])) {
				$filter['category_id'] = $GET['category'];
				$dropdown_selected['category'] = $GET['category'];
			}
			else {
				$errors[] = 'Category does not exist: '.$GET['category'];
			}
		}

		if (isset($GET['room']) && is_whole_number($GET['room'])) {
			// 0 = get all rooms (including undefined (room_id = NULL))
			if ($GET['room'] == '0') {
				// by default $dropdown_selected uses this value, so do not modify
				// since getting all rooms, do not add to $filter
			}
			// -1 = get only undefined rooms
			elseif ($GET['room'] == '-1') {
				$filter['room_id'] = NULL;
				$dropdown_selected['room'] = '-1';
			}
			// since not getting all rooms or undefined rooms, must be an individual room
			// validate that it does exist
			elseif ($this->room_model->id_exists($GET['room'])) {
				$filter['room_id'] = $GET['room'];
				$dropdown_selected['room'] = $GET['room'];
			}
			else {
				$errors[] = 'Room does not exist: '.$GET['room'];
			}
		}

		// query database with filters
		$data['assets'] = format_assets($this->asset_model->get_where($filter));

		// make data available for view
		$this->load->helper('form');
		$data['available_form_dropdown'] = array(
			-1 => '',
			 1 => 'yes',
			 0 => 'no'
			);
		$data['dropdown_selected'] = $dropdown_selected;
		$data['errors'] = $errors;

		$this->load->view('templates/header', $data);
		$this->load->view('asset/filter', $data);
		$this->load->view('templates/footer');
	}

	// used to clean up url for filter()
	public function filter_post()
	{
		// redirect to filter() if request isn't POST
		if ($_SERVER['REQUEST_METHOD'] !== 'POST')
			redirect(site_url('asset/filter'));

		// retrieve all $_POST variables
		$POST = $this->input->post(NULL, TRUE);

		// when no POST params given, it will be FALSE
		// change to empty array if FALSE
		if ($POST === FALSE)
			$POST = array();

		// params will be passed to filter()
		$params = array();

		// filter out default values POST values (validate in filter())
		if (isset($POST['available'])) {
			if ($POST['available'] == '0' || $POST['available'] == '1')
				$params['available'] = $POST['available'];
		}

		if (isset($POST['category'])) {
			if ($POST['category'] != '0')
				$params['category'] = $POST['category'];
		}

		if (isset($POST['room'])) {
			if ($POST['room'] != '0')
				$params['room'] = $POST['room'];
		}

		$url = site_url('asset/filter');
		if (!empty($params))
			$url .= '?'.http_build_query($params);

		redirect($url);
	}

	// not accessible through browser, helper function for create()
	public function _create_validate_category_id($id)
	{
		$id = intval($id);
		if ($id !== 0) {
			$this->load->model('category_model');
			$valid = $this->category_model->id_exists($id);
		}
		else {
			$valid = FALSE;
		}

		if (!$valid)
			$this->form_validation->set_message('_create_validate_category_id', 'Category is required');

		return $valid;
	}

	// not accessible through browser, helper function for create()
	public function _create_validate_room_id($id)
	{
		$id = intval($id);
		if ($id !== 0) {
			$this->load->model('room_model');
			$valid = $this->room_model->id_exists($id);
		}
		else {
			// $id is allowed to be 0 (meaning no room)
			$valid = TRUE;
		}

		if (!$valid)
			$this->form_validation->set_message('_create_validate_room_id', 'Invalid room');

		return $valid;
	}

	// not accessible through browser, helper function for create()
	// makes sure that every user_id associated with an asset exists
	public function _create_validate_user_id($id)
	{
		if (empty($id)) {
			$this->form_validation->set_message('_create_validate_user_id', 'User ID cannot be empty');
			return FALSE;
		}

		$id = intval($id);
		if (!$this->ion_auth->id_exists($id)) {
			$this->form_validation->set_message('_create_validate_user_id', 'User ID does not exist');
			return FALSE;
		}

		return TRUE;
	}

}