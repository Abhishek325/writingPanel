<?php
namespace Prote\DBI\user;
use DIC\Service;

class validate {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    }

    public function checkUserName($uname){ 
        $this->Db->set_parameters(array(strtolower($uname)));
        $data=$this->Db->find_one('SELECT `uname` from `user_details` where uname=?');
        if(!empty($data->uname))
            return true;
        if(empty($data->uname))
            return false;
    } 

    public function checkUserEmail($uname){ 
        $this->Db->set_parameters(array(strtolower($uname)));
        $data=$this->Db->find_one('SELECT `email` from `user_details` where email=?');
        if(!empty($data->email))
            return true;
        if(empty($data->email))
            return false;
    } 
}