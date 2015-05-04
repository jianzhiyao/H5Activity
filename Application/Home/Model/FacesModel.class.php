<?php

namespace Home\Model;
use Think\Model;
class FacesModel  extends Model{
	public function addFace($personId,$faceId){
		$data=array("personid"=>$personId,"faceid"=>$faceId);
		$res=D("faces")->data($data)->add();
		if($res) return 1;
		else return 0;
	}
	public function getPeronIdByFace($faceId){
		$res=$this->where("faceid='%s'",array($faceId))->find();
		return $res['personid'];
	}
}

?>