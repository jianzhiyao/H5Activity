<?php
namespace Home\Model;
use Think\Model;
class ActivityModel extends Model {
	public function match($personId,$activityId){
		$res=$this->where("id='%s' and founderid='%s'",array($activityId,$personId))->select();
		if(count($res)) return 1;
		else return 0;
	}
}
?>