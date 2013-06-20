<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class settings extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Country.Settings.View');
		$this->load->model('country_model', null, true);
		$this->lang->load('country');
		
		Template::set_block('sub_nav', 'settings/_sub_nav');
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
					$result = $this->country_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('country_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('country_delete_failure') . $this->country_model->error, 'error');
				}
			}
		}

		$records = $this->country_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Country');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: create()

		Creates a Country object.
	*/
	public function create()
	{
		$this->auth->restrict('Country.Settings.Create');

		if ($this->input->post('save'))
		{
			if ($insert_id = $this->save_country())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('country_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'country');

				Template::set_message(lang('country_create_success'), 'success');
				Template::redirect(SITE_AREA .'/settings/country');
			}
			else
			{
				Template::set_message(lang('country_create_failure') . $this->country_model->error, 'error');
			}
		}
		Assets::add_module_js('country', 'country.js');

		Template::set('toolbar_title', lang('country_create') . ' Country');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of Country data.
	*/
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('country_invalid_id'), 'error');
			redirect(SITE_AREA .'/settings/country');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Country.Settings.Edit');

			if ($this->save_country('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('country_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'country');

				Template::set_message(lang('country_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('country_edit_failure') . $this->country_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Country.Settings.Delete');

			if ($this->country_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('country_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'country');

				Template::set_message(lang('country_delete_success'), 'success');

				redirect(SITE_AREA .'/settings/country');
			} else
			{
				Template::set_message(lang('country_delete_failure') . $this->country_model->error, 'error');
			}
		}
		Template::set('country', $this->country_model->find($id));
		Assets::add_module_js('country', 'country.js');

		Template::set('toolbar_title', lang('country_edit') . ' Country');
		Template::render();
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/*
		Method: save_country()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_country($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		
		$this->form_validation->set_rules('country_name','Name','max_length[64]');
		$this->form_validation->set_rules('country_iso_code','Iso Code','max_length[3]');
		$this->form_validation->set_rules('country_status','Status','max_length[1]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['name']        = $this->input->post('country_name');
		$data['iso_code']        = $this->input->post('country_iso_code');
		$data['status']        = $this->input->post('country_status');

		if ($type == 'insert')
		{
			$id = $this->country_model->insert($data);

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
			$return = $this->country_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------



}