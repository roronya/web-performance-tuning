<?php
require 'vendor/autoload.php';
require 'src/config.php';

$con = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8', $host, $mysqldConfig['database']), $mysqldConfig['user'], $mysqldConfig['password'], array(PDO::ATTR_EMULATE_PREPARES => false));

$ids = range(1,100000);
foreach($ids as $id) {
	$sql = 'insert into profile select id,name,(select count(*) from follows where user_id = ?) as follow,(select count(*) from follows where follow_user_id = ?) as follower, (select count(*) from messages where user_id = 1) as messages from users where id = ?';
	$sth = $con->prepare($sql);
	$sth->execute(array($id, $id, $id));
	if ($id % 100 == 0) echo $id."\n";
}

