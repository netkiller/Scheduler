<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Scheduler;

/**
 * Description of Queue
 *
 * @author neo
 */
class Queue {
    private $redis;
    private $key;
    public function __construct($key = null) {
        $this->key = $key;
        $this->redis = new \Redis();
        $this->redis->pconnect('192.168.2.1', 6379);
        return($this->redis);
    }
    public function push($key, $val) {
        if($this->search($key, $val)){
            return FALSE;
        }
        return $this->redis->rpush($key, $val);
    }
    public function pop($key){
        return $this->redis->lpop($key);
    }
    public function current($key){
        return $this->redis->lget($key, 0);
    }
    public function search($key, $val){
        for($i=0;$i<$this->redis->lsize($key);$i++){
            if($this->redis->lget($key, $i) == $val) {
                return TRUE;
            }
        }
        return FALSE;
    }
}
/*
$queue = new Queue();
$key = 'crontab:queue';

echo $queue->current($key);

$queue->push($key, 'aaa');
$queue->push($key, 'bbb');
$queue->push($key, 'ccc');

$queue->search($key, 'aaa');

$queue->pop($key);
*/

//echo mt_rand(1, 9);
//echo rand(1, 9);
sleep(0);
