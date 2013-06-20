<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Testing_model extends BF_Model {

	protected $table		= "testing";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= true;
	protected $set_modified = false;
	protected $created_field = "created_on";
}
