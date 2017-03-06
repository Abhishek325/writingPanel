<?php
namespace Prote\DBI\user;
use DIC\Service;

class func {
    private $salt='';
    private $hash='';
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    } 

    public function generate_hash($pwd){
        return $this->hash=hash('sha512',$pwd.$this->salt);
    }

    public function make_salt($username,$pwd){
        return $this->salt=crypt($pwd, $username.'5UCK5'.$pwd);    
    } 

    public function verify($uname,$pwd){ 
         $this->Db->set_parameters(array($uname,$pwd)); 
         if($data=$this->Db->find_one('SELECT `uid` from `user_details` where uname=? && password=?')){
            return $data->uid;
        }else{
            return 0;
        }
    }
}