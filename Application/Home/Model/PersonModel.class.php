<?php

namespace Home\Model;
use Think\Model;

class PersonModel extends Model {
	public function regist($no,$password,$name){
		$res=$this->where("no='%s' ",array($no))->select();
		if(count($res)==0)
		{
			$data=array("no"=>$no,"password"=>md5($password),"name"=>$name);
			$res=$this->data($data)->add();
			if($res)
					return $this->getLastInsID();
			else
					return 0;
		}
		else return 0;
	}
	public  function login($no,$password){
		$res=$this->where("no='%s' and password='%s' ",array($no,md5($password)))->field("id")->find();
		if(is_array($res))
			return $res['id'];
		else
			return 0;
	}
	public function changePwd($personId,$oldPwd,$newPwd){
		$res=$this->where("id='%d' and password='%s' ",array($personId,md5($oldPwd)))->select();
		if(count($res))//成功
		{
			if($this->where("id='%d'",array($personId))->save(array("password"=>md5($newPwd))))
			return 1;
		}
		else
			return 0;
	}
}

?>