<?php
namespace Home\Controller;
use Think\Controller;
use Home\Common\Face;
use Home\Common\ReturnMsg;


class IndexController extends Controller {
    public function index(){
    	
    }
    public function recordUI(){
    	$this->assign("recordUrl",U('Index/recordScan'));
    	$this->display("recordUI");
    }
    public function signupUI(){
    	$this->assign("scanUrl",U('Index/signupScan'));
    	$this->assign("singupUrl",U('Index/singup'));//activity_id
    	$this->assign("activity_id",1);
    	$this->display("signupUI");
    }
    public function recordScan(){
    	session_start();
    	
    	isset($_SESSION['personId']) 
    	or 
    	$this->ajaxReturn(
    			ReturnMsg::builder(NO,array(),"你没有权限")
    	);
    	
    	
    	$face=Face::detectFaceByData($_POST['img']);
    	$personId=$_SESSION['personId'];
    	//var_dump($face);
    	if(is_array($face)&&count($face))//检测到了
    	{
    		if(Face::addFaceToPerson($face['face_id'], $personId)==ADD_OK)
    		{
    				D("faces")->addFace($personId,$face['face_id']);
    				$this->ajaxReturn(
    						ReturnMsg::builder(ADD_OK)
    				);
    		}
    		else
    				$this->ajaxReturn(
    						ReturnMsg::builder(ADD_NO)
    				);	
    	}
    	else
    	{
    			$this->ajaxReturn(
    					ReturnMsg::builder(WITHOUT_FACE_DATA)
    			);	
    	}
    }
    public function signupScan(){//签到扫描
    		$data=Face::searchPersonByData($_POST['img']);
    		if(is_array($data)&&count($data))
    		{
    			$candidates=$data['candidate'];
    			$face_id=$data['face_id'];
    			$cansRes=array();
    			$i=0;
    			foreach($candidates as $k => $v)
    			{
    				if(i>=10)
    					break;
    				$cansRes[$i++]=array('personid'=>$v['person_name'],"confidence"=>$v['confidence']);
    			}
    			//Face::addFaceToPerson($face_id, $candidates[0]['person_name']);
    			$res=array(
    				"candidate"=>$cansRes,
    				"face_id"=>$face_id
    			);
    			$this->ajaxReturn(
    					ReturnMsg::builder( OK , $res)
    			);
    		}
    		else
    		{
    				$this->ajaxReturn(
    						ReturnMsg::builder($data)
    				);	
    		}
    		
    }
    public function singup(){//签到记录接受
    	session_start();
    	isset($_SESSION['personId']) or die("没有权限");
    	$founderId=$_SESSION['personId'];
    	
    	//签到要有主办人的id
    	$activityId=$_POST['activity_id'];
    	$faceId=$_POST['face_id'];
    	$personId=$_POST['person_id'];
    	

    	if(!D("activity")->match($founderId,$activityId))
    		$this->ajaxReturn(ReturnMsg::builder(NO,array(),"你没有权限操作"));
    	
    	
    	if(D("faces")->addFace($personId,$faceId))
    	{
    		$res=D('signup')->where("activityid='%s' and personid='%s'",array($activityId,$personId))->select();
    		if(count($res))
    		{
    			$this->ajaxReturn((ReturnMsg::builder(OK,array(),"你已经签到了!")));
    		}
    		
    		$status=Face::addFaceToPerson($faceId, $personId);
    		if($status== ADD_OK)
    		{
    			D('signup')->signup($activityId,$personId);
    			$this->ajaxReturn((ReturnMsg::builder(OK,array(),"签到过程完成!")));
    		}
    		else if($status== ADD_NO) 		$this->ajaxReturn((ReturnMsg::builder(NO,array(),"人脸数据已经存在(ol)")));
    		else 												$this->ajaxReturn((ReturnMsg::builder(NETWORK_ERROR)));
    		
    	}
    	else
    		$this->ajaxReturn((ReturnMsg::builder(NO,array(),"人脸数据已经存在(lc)")));
    }
}