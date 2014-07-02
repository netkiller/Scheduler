<?php
namespace Scheduler\Mutex;

class ClusterMutex{
    public $lock;
    public function __construct(\Scheduler\Lock\RemoteLock $lock) {
        return $this->lock = $lock;
    }

    final public function create($mutex){
        if(!$this->lock->exists($mutex)){
            $this->lock->set($mutex, FALSE);
        }
    }

    final public function lock($mutex){
        if($this->lock->exists($mutex)){
            if(!$this->lock->get($mutex)){
                return $this->lock->set($mutex, TRUE);
            }
        }
        return FALSE;
    }
    final public function unlock($mutex){
        if($this->lock->exists($mutex)){
            if($this->lock->get($mutex)){
                return $this->lock->set($mutex, FALSE);
            }
        }
        return FALSE;
    }
    final public function destroy($mutex){
        if($this->lock->exists($mutex)){
            return $this->lock->delete($mutex);
        }
    }

}

