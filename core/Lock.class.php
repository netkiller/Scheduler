<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Scheduler\Lock;

/**
 * Description of lock
 *
 * @author neo
 */
interface Lock {
    public function set($key, $val);
    public function get($key);
    public function exists($key);
    public function delete($key);
}

class RemoteLock implements Lock{
    /* Distributed lock with Redis */
    public $redis;
    public function __construct() {
        $this->redis = new \Redis();
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

class LocalLock  implements Lock{
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

class DatabaseLock implements Lock{
    public $redis;
    public function __construct() {
        $this->redis = new \Redis();
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