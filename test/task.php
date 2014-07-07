<?php
//include_once 'autoload.php';

include_once 'core/Common.class.php';
include_once 'core/Scheduler.class.php';
include_once 'core/Logging.class.php';
include_once 'core/Lock.class.php';
include_once 'core/Mutex.class.php';
include_once 'core/Task.class.php';
include_once 'task/test.class.php';

try {

    $lock = new Scheduler\Lock\RemoteLock();
    $mutex = new Scheduler\Mutex\ClusterMutex($lock);
    $test = new \Task\Test();
    $task = new Scheduler\Task($mutex, $test);
    //$task->resetlock();

} catch (Exception $e) {
    echo $e->getMessage();
}


//$scheduler->setup($host, $port, $user, $password);

//$task = new Scheduler\Task\Task(new Scheduler\Mutex\ClusterMutex(new Scheduler\Lock\RemoteLock()));
//$task->resetlock();