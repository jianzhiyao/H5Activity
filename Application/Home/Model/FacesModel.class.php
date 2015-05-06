<?php

namespace Home\Model;
use Think\Model;
class FacesModel  extends Model{
	public function addFace($personId,$faceId){
		
		$res=$this->where(" faceid='%s' ",array($personId,$faceId))->select();
		if(count($res)) return 0;
		
		$data=array("personid"=>$personId,"faceid"=>$faceId);
		$res=$this->data($data)->add();
		if($res) return 1;
		else return 0;
	}
	public function getPeronIdByFace($faceId){
		$res=$this->where("faceid='%s'",array($faceId))->find();
		return $res['personid'];
	}
}

?>