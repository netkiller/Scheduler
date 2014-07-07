<?php
include_once 'core/Scheduler.class.php';

$scheduler = new Scheduler();
$scheduler->join('*/5 * * * *', '/var/www/test.php');
$scheduler->join('*/5 * * * *', '/var/www/abc.php', FALSE);
$scheduler->debug();
$scheduler->setup();