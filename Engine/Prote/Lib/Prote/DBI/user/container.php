<?php
namespace Prote\DBI\user;
use DIC\Service;
class container {
	private $Storage=array();
	private $Service;

	public function __construct(Service $Service){
		$this->Service=$Service;
	}

	public function available($class){
		if(isset($this->Storage[$class]))
			return true;
		else
			return false;
	}

	public function load($name,$path){
		if($this->available($name))
			return $this->Storage[$name];
		else
			return $this->Storage[$name]=new $path($this->Service);
	}

	public function common(){
		return $this->load('common','\Prote\DBI\user\common');
	}

	public function data(){
		return $this->load('data','\Prote\DBI\user\data');
	}

	public function func(){
		return $this->load('func','\Prote\DBI\user\func');
	}

	public function validate(){
		return $this->load('validate','\Prote\DBI\user\validate');
	}
}