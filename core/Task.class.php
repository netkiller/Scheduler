<?php
namespace Scheduler;

class Task extends Common {
    public function __construct() {
        parent::__construct();
    }
}

class TaskMutex extends Task {
    private $name   = null;
    private $mutex  = null;
    private $task   = null;
    public function __construct(\Scheduler\Mutex\ClusterMutex $mutex, $task) {
        parent::__construct();
        $this->name     = "crontab".":".get_class($task);
        $this->mutex    = $mutex;
        $this->task     = $task;

        if($this->mutex->create($this->name)){
            parent::$logging->info(sprintf("create mutex %s", $this->name));
        }
    }
    public function __destruct() {
        //$this->mutex->destroy($this->name);
        //parent::$logging->info(sprintf("mutex destroy %s", $this->name));
    }
    public function run(){
        if($this->mutex->lock($this->name)){
            parent::$logging->info(sprintf("mutex lock %s", $this->name));
        }else {
            parent::$logging->info(sprintf("mutex wait %s", $this->name));
            exit();
            //throw new \Exception(sprintf("mutex wait %s\n", $this->name));
        }

        /*
         * doing something
         */
        //print_r($this->mutex);
        $this->task->run();
        /*
         * doing something
         */

        if($this->mutex->unlock($this->name)){
            parent::$logging->info(sprintf("mutex unlock %s", $this->name));
        }
    }
    public function loop($seconds = 5){
        while(TRUE){
            if($this->mutex->lock($this->name)){
                parent::$logging->info(sprintf("mutex lock %s", $this->name));
            }else {
                parent::$logging->info(sprintf("mutex wait %s", $this->name));
                sleep(mt_rand(0, $seconds));
                continue;
                //throw new \Exception(sprintf("mutex wait %s\n", $this->name));
            }

            /*
             * doing something
             */
            //print_r($this->mutex);
            $this->task->run();
            /*
             * doing something
             */

            if($this->mutex->unlock($this->name)){
                parent::$logging->info(sprintf("mutex unlock %s", $this->name));
            }

            sleep($seconds);
        }
    }

    public function destroy(){
        $this->mutex->destroy($this->name);
        parent::$logging->info(sprintf("mutex destroy %s", $this->name));
    }

}

class TaskQueue extends Task {
    private $name   = null;
    private $queue  = null;

    public function __construct(\Scheduler\Queue $queue, $task) {
        parent::__construct();
        $this->name     = "crontab".":".get_class($task);
        $this->mutex    = $mutex;
        $this->task     = $task;

        if($this->queue->current($this->name)){
            parent::$logging->info(sprintf("get curent queue %s", $this->name));
        }

    }
    public function __destruct() {
        //$this->mutex->destroy($this->name);
        //parent::$logging->info(sprintf("mutex destroy %s", $this->name));
    }

}