<?php
include_once 'Scheduler.class.php';
include_once 'Logging.class.php';
include_once 'Lock.class.php';
include_once 'Mutex.class.php';
include_once 'Task.class.php';


use Scheduler\Timer;
//use Scheduler\Lock;
use Scheduler\Mutex;
use Scheduler\Task;

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
<<<<<<< HEAD
$lock = new Scheduler\Lock\RemoteLock();
$mutex = new Scheduler\Mutex\ClusterMutex($lock);
$task = new Scheduler\Task\Task($mutex);
$task->run();
=======
$lock = new RemoteLock();
$mutex = new ClusterMutex($lock);
$task = new Task($mutex);
>>>>>>> 90d6be8970a700f6caae20022ce68e40e6f965dd
*/
$scheduler = new Scheduler();
$scheduler->join('*/5 * * * *', '/var/www/test.php');
$scheduler->join('*/5 * * * *', '/var/www/abc.php', FALSE);
$scheduler->debug();
$scheduler->setup();

<<<<<<< HEAD
//$scheculer = new Scheduler();
//$scheculer->run();


//$task = new Scheduler\Task\Task(new Scheduler\Mutex\ClusterMutex(new Scheduler\Lock\RemoteLock()));
//$task->run();
=======
/*
$task = new Task(new ClusterMutex(new RemoteLock()));
$task->run();
*/
>>>>>>> 90d6be8970a700f6caae20022ce68e40e6f965dd
