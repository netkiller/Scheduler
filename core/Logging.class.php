<?php

namespace Scheduler;

class Logging {
	protected $file;
	protected $logfile;
	public function __construct($logfile = null, $logpath = null, $prefix = '', $suffix = "log"){

		if ($logpath) {
            $this->logfile = $logpath.'/'.$prefix.$logfile.'.'.date('Y-m-d.H:i:s').'.'. $suffix;
        }else if($logfile){
			$this->logfile = $logfile;
		}

        if(!file_exists(dirname($this->logfile))){
			throw new \Exception('Directory '. dirname($this->logfile) ." isn't exist.");
		}
		if(file_exists($this->logfile)){
			if(!is_writable($this->logfile)){
				throw new \Exception('Directory '. $this->logfile ." isn't writable.");
			}
		}
	}
	public function __destruct() {
		if($this->file){
			fclose($this->file);
		}
	}
	private function write($msg){
        $this->file = fopen($this->logfile,"a+");
		if($this->file){
			fwrite($this->file,date('Y-m-d H:i:s')."\t".$msg."\r\n");
		}
	}
	public function info($msg){
		$this->write(__FUNCTION__."\t".$msg);
	}
	public function warning($msg){
		$this->write(__FUNCTION__."\t".$msg);
	}
	public function error($msg){
		$this->write(__FUNCTION__."\t".$msg);
	}
	public function debug($msg){
		$this->write(__FUNCTION__."\t".$msg);
	}
	public function exception($msg){
		$this->write(__FUNCTION__."\t".$msg);
	}

}
