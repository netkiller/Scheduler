<?php
//include_once 'autoload.php';
chdir(dirname(__DIR__));

include_once 'core/Common.class.php';
include_once 'core/Logging.class.php';
include_once 'core/Lock.class.php';
include_once 'core/Mutex.class.php';
include_once 'core/Task.class.php';
include_once 'job/test.class.php';

try {

    $lock = new Scheduler\Lock\RemoteLock($expire=300);
    $mutex = new Scheduler\Mutex\ClusterMutex($lock);
    $test = new Job\Test();

    $task = new Scheduler\TaskMutex($mutex, $test);
    $task->run();
    //$task->loop(5);

} catch (Exception $e) {
    echo $e->getMessage();
}


//$scheduler->setup($host, $port, $user, $password);

//$task = new Scheduler\Task\Task(new Scheduler\Mutex\ClusterMutex(new Scheduler\Lock\RemoteLock()));
//$task->resetlock();
