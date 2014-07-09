<?php
include_once 'core/Scheduler.class.php';

$scheduler = new Scheduler();
$scheduler->join('*/5 * * * *', '/srv/php/bin/php -c /srv/php-5.5.14/etc/php.ini task/test.php');
$scheduler->join('*/5 * * * *', '/var/www/abc.php', FALSE);
$scheduler->debug();
$scheduler->setup();