<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Testing.Content.View');
		$this->load->model('testing_model', null, true);
		$this->lang->load('testing');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
			//Assets::add_js(Template::theme_url('js/editors/ckeditor/ckeditor.js'));
		Template::set_block('sub_nav', 'content/_sub_nav');
	}

	//--------------------------------------------------------------------



	/*
		Method: index()

		Displays a list of form data.
	*/
	public function index()
	{

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->testing_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('testing_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('testing_delete_failure') . $this->testing_model->error, 'error');
				}
			}
		}

		$records = $this->testing_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage testing');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: create()

		Creates a testing object.
	*/
	public function create()
	{
		$this->auth->restrict('Testing.Content.Create');

		if ($this->input->post('save'))
		{
			if ($insert_id = $this->save_testing())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('testing_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'testing');

				Template::set_message(lang('testing_create_success'), 'success');
				Template::redirect(SITE_AREA .'/content/testing');
			}
			else
			{
				Template::set_message(lang('testing_create_failure') . $this->testing_model->error, 'error');
			}
		}
		Assets::add_module_js('testing', 'testing.js');

		Template::set('toolbar_title', lang('testing_create') . ' testing');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of testing data.
	*/
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('testing_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/testing');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Testing.Content.Edit');

			if ($this->save_testing('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('testing_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'testing');

				Template::set_message(lang('testing_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('testing_edit_failure') . $this->testing_model->error, 'error');
			}
		}
		Template::set('testing', $this->testing_model->find($id));
		Assets::add_module_js('testing', 'testing.js');

		Template::set('toolbar_title', lang('testing_edit') . ' testing');
		Template::render();
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/*
		Method: save_testing()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_testing($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		
		$this->form_validation->set_rules('testing_date','date','');
		$this->form_validation->set_rules('testing_detail','detail','');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['date']        = $this->input->post('testing_date') ? $this->input->post('testing_date') : '0000-00-00';
		$data['detail']        = $this->input->post('testing_detail');

		if ($type == 'insert')
		{
			$id = $this->testing_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			} else
			{
				$return = FALSE;
			}
		}
		else if ($type == 'update')
		{
			$return = $this->testing_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------



}