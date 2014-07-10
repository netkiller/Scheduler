<?php
include_once 'core/Crontab.class.php';

define(PHP, '/srv/php/bin/php -c /srv/php-5.5.14/etc/php.ini ');
$scheduler = new Scheduler\Crontab();
$scheduler->join('*/5 * * * *', 'cd /www/Scheduler/ && '.PHP.'/www/Scheduler/task/testmutex.php');
$scheduler->join('*/5 * * * *', PHP.'task/testqueue.php', FALSE);
$scheduler->join('*/5 * * * *', PHP.'/var/www/def.php', FALSE);
$scheduler->debug();
$scheduler->setup();