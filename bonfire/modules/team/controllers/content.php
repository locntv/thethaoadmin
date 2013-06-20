<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Team.Content.View');
		$this->load->model('team_model', null, true);
		$this->lang->load('team');
		
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
					$result = $this->team_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('team_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('team_delete_failure') . $this->team_model->error, 'error');
				}
			}
		}

		$records = $this->team_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Team');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: create()

		Creates a Team object.
	*/
	public function create()
	{
		$this->auth->restrict('Team.Content.Create');

		if ($this->input->post('save'))
		{
			if ($insert_id = $this->save_team())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('team_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'team');

				Template::set_message(lang('team_create_success'), 'success');
				Template::redirect(SITE_AREA .'/content/team');
			}
			else
			{
				Template::set_message(lang('team_create_failure') . $this->team_model->error, 'error');
			}
		}
		Assets::add_module_js('team', 'team.js');

		Template::set('toolbar_title', lang('team_create') . ' Team');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of Team data.
	*/
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('team_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/team');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Team.Content.Edit');

			if ($this->save_team('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('team_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'team');

				Template::set_message(lang('team_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('team_edit_failure') . $this->team_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Team.Content.Delete');

			if ($this->team_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('team_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'team');

				Template::set_message(lang('team_delete_success'), 'success');

				redirect(SITE_AREA .'/content/team');
			} else
			{
				Template::set_message(lang('team_delete_failure') . $this->team_model->error, 'error');
			}
		}
		Template::set('team', $this->team_model->find($id));
		Assets::add_module_js('team', 'team.js');

		Template::set('toolbar_title', lang('team_edit') . ' Team');
		Template::render();
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/*
		Method: save_team()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_team($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		
		$this->form_validation->set_rules('team_name','Name','required|max_length[64]');
		$this->form_validation->set_rules('team_type','Type','max_length[0,1,2]');
		$this->form_validation->set_rules('team_category_id','Category Id','max_length[0,1,2,3]');
		$this->form_validation->set_rules('team_description','Description','');
		$this->form_validation->set_rules('team_country_id','Country Id','max_length[11]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['name']        = $this->input->post('team_name');
		$data['type']        = $this->input->post('team_type');
		$data['category_id']        = $this->input->post('team_category_id');
		$data['description']        = $this->input->post('team_description');
		$data['country_id']        = $this->input->post('team_country_id');

		if ($type == 'insert')
		{
			$id = $this->team_model->insert($data);

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
			$return = $this->team_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------



}