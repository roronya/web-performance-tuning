<?php

use Phpmig\Migration\Migration;

class CreateFollowersIndex extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
	$sql = "alter table follows add index follow_user_id_index(follow_user_id)";
	$container = $this->getContainer();
	$container['db']->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
	$sql = "alter table follows drop index follow_user_id_index";
	$container = $this->getContainer();
	$container['db']->query($sql);	
    }
}
