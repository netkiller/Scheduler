<?php
namespace Task;

class Test {
    public function __construct(){

    }
    public function run(){
        for($i=1;$i<10;$i++){
            sleep(1);
            printf("%s \n",$i );
        }

    }
}
