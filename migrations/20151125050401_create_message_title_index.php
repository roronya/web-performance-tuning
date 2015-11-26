<?php

use Phpmig\Migration\Migration;

class CreateMessageTitleIndex extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
	$sql = "alter table messages add index title_created_at_index(title, created_at)";
	$container = $this->getContainer();
	$container['db']->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
	$sql = "alter table messages drop index title_created_at_index";
	$container = $this->getContainer();
	$container['db']->query($sql);	
    }
}
