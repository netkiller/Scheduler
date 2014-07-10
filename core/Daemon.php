<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Scheduler;

/**
 * Description of Daemon
 *
 * @author neo
 */
class Daemon {
    public function __construct() {

        $pid = pcntl_fork();
        if ($pid == -1) {
             die('could not fork');
        } else if ($pid) {
             pcntl_wait($status);
        } else {
             //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
        }
    }
}
