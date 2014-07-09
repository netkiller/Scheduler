<?php

class Test {
    public function __construct(){
        printf("task starting %s \n", getenv('HOSTNAME'));
        //print_r($_SERVER);

    }
    public function run(){
        for($i=1;$i<10;$i++){
            sleep(1);
            printf("%s \n",$i );
        }

    }
}
