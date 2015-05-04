<?php

namespace Home\Model;
use Think\Model;

class PersonModel extends Model {
	public function regist($no,$password,$name){
		$data=array("no"=>$no,"password"=>md5($password),"name"=>$name);
		$res=$this->create($data);
		if($res) return 1;
		else return 0;
	}
	public  function login($no,$password){
		$res=$this->where("no='%s' and password='%s' ",array($no,md5($password)))->select();
		return count($res);
	}
	public function changePwd($personId,$oldPwd,$newPwd){
		$res=$this->where("id='%d' and password='%s' ",array($personId,md5($oldPwd)))->select();
		if(count($res))//成功
		{
			$this->where("id='%d'",array($personId))->save(array("password"=>md5($newPwd)));
			return 1;
		}
		else
			return 0;
	}
}

?>