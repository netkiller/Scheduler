<?php
namespace Scheduler;

class Task extends Common {
    private $name   = null;
    private $mutex  = null;
    private $task   = null;
    public function __construct(\Scheduler\Mutex\ClusterMutex $mutex, $task) {
        parent::__construct();
        $this->name     = get_class($task);
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
        }
        /*
        else {
            parent::$logging->info(sprintf("mutex wait %s\n", $this->name));
            throw new \Exception(sprintf("mutex wait %s\n", $this->name));
        }
        */

        /*
         * doing something
         */
        print_r($this->mutex);
        $this->task->run();
        /*
         * doing something
         */

        if($this->mutex->unlock($this->name)){
            parent::$logging->info(sprintf("mutex unlock %s", $this->name));
        }
    }
    public function resetlock(){
        $this->mutex->destroy($this->name);
        parent::$logging->info(sprintf("mutex destroy %s", $this->name));
    }

}