<?php

namespace Home\Model;
use Think\Model;

class SignupModel extends Model {
	public function signup($activityId,$personId){
		return $this->data(array("activityid"=>$activityId,"personid"=>$personId))->add();
	}
	
}

?>