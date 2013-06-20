<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_testing extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;

		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
			),
			'date' => array(
				'type' => 'DATE',
				'default' => '0000-00-00',
				
			),
			'detail' => array(
				'type' => 'TEXT',
				
			),
			'created_on' => array(
				'type' => 'datetime',
				'default' => '0000-00-00 00:00:00',
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('testing');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('testing');

	}

	//--------------------------------------------------------------------

}