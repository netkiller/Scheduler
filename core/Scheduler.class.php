<?php
class Scheduler {
    public $cron = array();
    public function __construct() {
        //print('aaa');
    }
    public function __destruct() {

    }
    public function hourly($param) {

    }
    public function daily($param) {

    }
    public function weekly(){
//        echo 'bbb';
    }
    public function monthly($param) {

    }
	
    public function join($schedule, $cmd, $status = TRUE){
        $this->cron[] = array(($status?'':'#').$schedule => $cmd);
    }
    public function debug(){
//        print_r($this->cron);
        foreach($this->cron as $line){
//            print_r($line);
            list($sch, $cmd) = each($line);
            printf("%s\t%s\n", $sch, $cmd);
        }
    }
    public function setup(){
        
    }	
}