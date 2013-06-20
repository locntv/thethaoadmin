<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Tournament.Content.View');
		$this->load->model('tournament_model', null, true);
		$this->lang->load('tournament');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
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
					$result = $this->tournament_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('tournament_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('tournament_delete_failure') . $this->tournament_model->error, 'error');
				}
			}
		}

		$records = $this->tournament_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Tournament');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: create()

		Creates a Tournament object.
	*/
	public function create()
	{
		$this->auth->restrict('Tournament.Content.Create');

		if ($this->input->post('save'))
		{
			if ($insert_id = $this->save_tournament())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('tournament_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'tournament');

				Template::set_message(lang('tournament_create_success'), 'success');
				Template::redirect(SITE_AREA .'/content/tournament');
			}
			else
			{
				Template::set_message(lang('tournament_create_failure') . $this->tournament_model->error, 'error');
			}
		}
		Assets::add_module_js('tournament', 'tournament.js');

		Template::set('toolbar_title', lang('tournament_create') . ' Tournament');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of Tournament data.
	*/
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('tournament_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/tournament');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Tournament.Content.Edit');

			if ($this->save_tournament('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('tournament_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'tournament');

				Template::set_message(lang('tournament_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('tournament_edit_failure') . $this->tournament_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Tournament.Content.Delete');

			if ($this->tournament_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('tournament_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'tournament');

				Template::set_message(lang('tournament_delete_success'), 'success');

				redirect(SITE_AREA .'/content/tournament');
			} else
			{
				Template::set_message(lang('tournament_delete_failure') . $this->tournament_model->error, 'error');
			}
		}
		Template::set('tournament', $this->tournament_model->find($id));
		Assets::add_module_js('tournament', 'tournament.js');

		Template::set('toolbar_title', lang('tournament_edit') . ' Tournament');
		Template::render();
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/*
		Method: save_tournament()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_tournament($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		
		$this->form_validation->set_rules('name','Name','required|max_length[64]');
		$this->form_validation->set_rules('description','Description','');
		$this->form_validation->set_rules('date_start','Date Start','max_length[64]');
		$this->form_validation->set_rules('date_end','Date End','max_length[64]');
		$this->form_validation->set_rules('category_id','Category Id','max_length[6]');
		$this->form_validation->set_rules('take_place','Take Place','max_length[128]');
		$this->form_validation->set_rules('status','Status','max_length[1]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['name']        = $this->input->post('name');
		$data['description']        = $this->input->post('description');
		$data['date_start']        = $this->input->post('date_start') ? $this->input->post('date_start') : '0000-00-00';
		$data['date_end']        = $this->input->post('date_end') ? $this->input->post('date_end') : '0000-00-00';
		$data['category_id']        = $this->input->post('category_id');
		$data['take_place']        = $this->input->post('take_place');
		$data['status']        = $this->input->post('status');

		if ($type == 'insert')
		{
			$id = $this->tournament_model->insert($data);

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
			$return = $this->tournament_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------



}