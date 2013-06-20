<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('TournamentToTeam.Content.View');
		$this->load->model('tournamenttoteam_model', null, true);
		$this->lang->load('tournamenttoteam');
		
		Template::set_block('sub_nav', 'content/_sub_nav');
	}

	//--------------------------------------------------------------------



	/*
		Method: index()

		Displays a list of form data.
	*/
	public function index()
	{
		$tournament_id = $this->uri->segment(5);
		if (empty($tournament_id)) {
			Template::set_message(lang('tournamenttoteam_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/tournamenttoteam');
		}
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->tournamenttoteam_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('tournamenttoteam_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('tournamenttoteam_delete_failure') . $this->tournamenttoteam_model->error, 'error');
				}
			}
		}
		$this->db->join('team', 'team.id = tournament_to_team.team_id', 'left');
		$records = $this->tournamenttoteam_model->find_all_by("tournament_id", $tournament_id);

		Template::set('records', $records);
		Template::set('tournament_id', $tournament_id);
		Template::set('toolbar_title', 'Manage TournamentToTeam');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: create()

		Creates a TournamentToTeam object.
	*/
	public function create()
	{
		$tournament_id = $this->uri->segment(5);
		$this->auth->restrict('TournamentToTeam.Content.Create');

		if ($this->input->post('save'))
		{
			if ($insert_id = $this->save_tournamenttoteam())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('tournamenttoteam_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'tournamenttoteam');

				Template::set_message(lang('tournamenttoteam_create_success'), 'success');
				Template::redirect(SITE_AREA .'/content/tournamenttoteam');
			}
			else
			{
				Template::set_message(lang('tournamenttoteam_create_failure') . $this->tournamenttoteam_model->error, 'error');
			}
		}
		
		$this->load->model('team/team_model', null, true);
		$team = $this->team_model->select('id, name')
								 ->find_all();
		
		Assets::add_module_js('tournamenttoteam', 'tournamenttoteam.js');
		Template::set('tournament_id', $tournament_id);
		Template::set('team', $team);
		Template::set('toolbar_title', lang('tournamenttoteam_create') . ' TournamentToTeam');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of TournamentToTeam data.
	*/
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('tournamenttoteam_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/tournamenttoteam');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('TournamentToTeam.Content.Edit');

			if ($this->save_tournamenttoteam('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('tournamenttoteam_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'tournamenttoteam');

				Template::set_message(lang('tournamenttoteam_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('tournamenttoteam_edit_failure') . $this->tournamenttoteam_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('TournamentToTeam.Content.Delete');

			if ($this->tournamenttoteam_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('tournamenttoteam_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'tournamenttoteam');

				Template::set_message(lang('tournamenttoteam_delete_success'), 'success');

				redirect(SITE_AREA .'/content/tournamenttoteam');
			} else
			{
				Template::set_message(lang('tournamenttoteam_delete_failure') . $this->tournamenttoteam_model->error, 'error');
			}
		}
		Template::set('tournamenttoteam', $this->tournamenttoteam_model->find($id));
		Assets::add_module_js('tournamenttoteam', 'tournamenttoteam.js');

		Template::set('toolbar_title', lang('tournamenttoteam_edit') . ' TournamentToTeam');
		Template::render();
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/*
		Method: save_tournamenttoteam()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_tournamenttoteam($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		
		$this->form_validation->set_rules('tournamenttoteam_tournament_id','Tournament Id','max_length[1,2]');
		$this->form_validation->set_rules('tournamenttoteam_team_id','Team Id','max_length[11,2]');
		$this->form_validation->set_rules('tournamenttoteam_team_info','Team Info','max_length[128]');
		$this->form_validation->set_rules('tournamenttoteam_group_code','Group Code','max_length[group-a,group-b,group-c,group-d,group-e,group-f,group-g,group-h]');
		$this->form_validation->set_rules('tournamenttoteam_point','Point','max_length[4]');
		$this->form_validation->set_rules('tournamenttoteam_ranking','Ranking','max_length[4]');
		$this->form_validation->set_rules('tournamenttoteam_is_out','Is Out','max_length[1]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['tournament_id']        = $this->input->post('tournamenttoteam_tournament_id');
		$data['team_id']        = $this->input->post('tournamenttoteam_team_id');
		$data['team_info']        = $this->input->post('tournamenttoteam_team_info');
		$data['group_code']        = $this->input->post('tournamenttoteam_group_code');
		$data['point']        = $this->input->post('tournamenttoteam_point');
		$data['ranking']        = $this->input->post('tournamenttoteam_ranking');
		$data['is_out']        = $this->input->post('tournamenttoteam_is_out');

		if ($type == 'insert')
		{
			$id = $this->tournamenttoteam_model->insert($data);

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
			$return = $this->tournamenttoteam_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------



}