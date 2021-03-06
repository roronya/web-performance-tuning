<?php

use Phpmig\Migration\Migration;

class CreateMessageIndex extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
	$sql = "alter table messages add index user_id_index(user_id)";
	$container = $this->getContainer();
	$container['db']->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
	$sql = "alter table messages drop index user_id_index";
	$container = $this->getContainer();
	$container['db']->query($sql);	
    }
}
