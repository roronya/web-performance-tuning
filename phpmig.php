<?php

use \Phpmig\Adapter;
require_once(__DIR__.'/vendor/pimple/pimple/lib/Pimple.php');

$container = new Pimple();

$container['db'] = $container->share(function() {
    $dbh = new PDO('mysql:dbname=groupwork;host=127.0.0.1','demouser','demopass');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
});

$container['phpmig.adapter'] = $container->share(function() use ($container) {
    return new Adapter\PDO\Sql($container['db'], 'migrations');
});

$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

return $container;
