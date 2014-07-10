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
        $this->name     = "schedule:mutex:".get_class($task);
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
    private $node   = null;
    private $queue  = null;
    private $task   = null;

    const prefix = "schedule:queue";

    public function __construct(\Scheduler\Queue $queue, $task) {
        parent::__construct();
        $this->name     = self::prefix.':'.get_class($task);
        $this->class    = get_class($task);
        //$this->node     = getenv('HOSTNAME');
        $this->node     = getmypid();
        $this->queue    = $queue;
        $this->task     = $task;
    }
    public function __destruct() {
        //$this->mutex->destroy($this->name);
        //parent::$logging->info(sprintf("mutex destroy %s", $this->name));
    }
    public function run(){
        if($this->queue->push($this->name, $this->node)){
            parent::$logging->info(sprintf("queue push %s:%s", $this->name, $this->node));
        }

        $first = $this->queue->first($this->name);
        if($first == $this->node){
            parent::$logging->info(sprintf("get first queue %s:%s", $this->name, $first));

            $this->task->run();

            if($pop = $this->queue->pop($this->name)){
                parent::$logging->info(sprintf("queue pop %s", $pop));
            }
        }else{
            parent::$logging->info(sprintf("waiting for pop queue %s:%s", $this->name, $first));
            return;
        }
    }
    public function loop($seconds = 5){
        /* $seconds >= runtime */
        while(TRUE){
            if($this->queue->push($this->name, $this->node)){
                parent::$logging->info(sprintf("queue push %s:%s", $this->name, $this->node));
            }

            $first = $this->queue->first($this->name);
            if($first == $this->node){
                parent::$logging->info(sprintf("get first queue %s:%s", $this->name, $first));

                $this->task->run();

                if($pop = $this->queue->pop($this->name)){
                    parent::$logging->info(sprintf("queue pop %s:%s", $this->name, $pop));
                }
            }else{
                parent::$logging->info(sprintf("queue waiting for pop  %s:%s - %s", $this->name, $this->node, $first));
                sleep(mt_rand(1, $seconds));

                $ckey = self::prefix.':count:'.$this->class.'-'.$first;
                $queue_count    = $this->queue->count($ckey);
                $max_count      = $this->queue->size($this->name) * $seconds;
                if( $queue_count > $max_count ){
                    if($pop = $this->queue->pop($this->name)){
                        parent::$logging->info(sprintf("queue force pop %s:%s (%s:%s)", $this->name, $pop, $queue_count, $max_count));
                        $this->queue->delete($ckey);
                    }
                }
                #printf("%d=", $this->queue->count($ckey)) ;

                continue;
            }

            sleep($seconds);
            parent::$logging->info(sprintf("===== %s:%s =====", $this->name, $this->node));
        }
    }
}