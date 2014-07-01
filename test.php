<?php
include_once 'Scheduler.php';
include_once 'Mutex.php';
include_once 'Task.php';

/*
$remote = new RemoteLock();

$mutex = new ClusterMutex(new RemoteLock());
$mutex_key = 'task.lock';
$mutex->create($mutex_key);
echo $remote->get($mutex_key);
$mutex->lock($mutex_key);
echo $remote->get($mutex_key);
$mutex->unlock($mutex_key);
echo $remote->get($mutex_key);
$mutex->destroy($mutex_key);
echo $remote->get($mutex_key);
*/

/*
$lock = new RemoteLock();
$mutex = new ClusterMutex($lock);
$task = new Task($mutex);
*/
$scheduler = new Scheduler();
$scheduler->join('*/5 * * * *', '/var/www/test.php');
$scheduler->join('*/5 * * * *', '/var/www/abc.php', FALSE);
$scheduler->debug();
$scheduler->setup();

/*
$task = new Task(new ClusterMutex(new RemoteLock()));
$task->run();
*/