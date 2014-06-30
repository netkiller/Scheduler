<?php
class RemoteLock {
    public $redis;
    public function __construct() {
        $this->redis = new Redis();
        $this->redis->pconnect('192.168.2.1', 6379);
        return($this->redis);
    }
    public function set($key, $val){
        return $this->redis->set($key, $val);
    }
    public function get($key){
        return $this->redis->get($key);
    }
    public function exists($key){
        return $this->redis->exists($key);
    }
    public function delete($key){
        return $this->redis->delete($key);
    }
}

class LocalLock {
    public $redis;
    public function __construct() {

    }
    public function set($key, $val){

    }
    public function get($key){

    }
    public function exists($key){

    }
    public function delete($key){

    }
}

class ClusterMutex{
    public $lock;
    public function __construct(RemoteLock $lock) {
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

