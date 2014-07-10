<?php
//include_once 'autoload.php';

include_once 'core/Common.class.php';
include_once 'core/Scheduler.class.php';
include_once 'core/Logging.class.php';
include_once 'core/Queue.class.php';
include_once 'core/Task.class.php';
include_once 'job/test.class.php';

//namespace Task;

try {


    $queue = new Scheduler\Queue();
    $test = new Job\Test();

    $task = new Scheduler\TaskQueue($queue, $test);
    //foreach (range(0, 12) as $number) {
        //echo $number;
        //$task->run();
    //}

    $task->loop(5);

} catch (Exception $e) {
    echo $e->getMessage();
}
