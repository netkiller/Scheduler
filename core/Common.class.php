<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Scheduler;

/**
 * Description of Common
 *
 * @author neo
 */
class Common {
    public static $logging;
    public function __construct() {
        self::$logging = new Logging('/tmp/test.log');
    }
}
