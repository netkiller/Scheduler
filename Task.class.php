<?php
namespace Scheduler\Task;

class Task {
    private $name='task.lock';
    private $mutex;
    public function __construct(\Scheduler\Mutex\ClusterMutex $mutex) {
        $this->mutex = $mutex;
        if($this->mutex->create($this->name)){
            printf("create mutex\n");
        }
    }
    public function __destruct() {
        //$this->mutex->destroy($this->name);
        //printf("destroy mutex\n");
    }

    public function run(){
        if($this->mutex->lock($this->name)){
            printf("lock\n");
        } else {
            exit();
        }

        /*
         * doing something
         */
        print_r($this->mutex);
        //usleep();
        sleep(5);
        if($this->mutex->unlock($this->name)){
            printf("unlock\n");
        }
    }
}