<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tournament_model extends BF_Model {

	protected $table		= "tournament";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= false;
	protected $set_modified = false;
	protected $created_field = "date_start";
	protected $modified_field = "date_end";
}
