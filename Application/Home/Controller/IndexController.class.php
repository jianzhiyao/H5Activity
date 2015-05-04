<?php
namespace Home\Controller;
use Think\Controller;
use Home\Common\Face;
use Home\Common\ReturnMsg;


class IndexController extends Controller {
    public function index(){
//      	$this->assign("scanUrl",U('Index/recordScan'));
    	$this->assign("scanUrl",U('Index/signupScan'));
    	$this->display("h5cam");
    }
    public function recordScan(){
    	//测试数据
    	$_POST['personId']="31120030588";
    	$face=Face::detectFaceByData($_POST['img']);
    	$personId=$_POST['personId'];
    	//var_dump($face);
    	if(count($face))//检测到了
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
    		if(count($data)>1)
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
    			$this->ajaxReturn(
    					ReturnMsg::builder( OK , $cansRes)
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
    	//签到要有主办人的id
    	$activityId=$_POST['act_id'];
    	$personId=$_POST['per_id'];
    	if(D("faces")->addFace($activityId,$personId))
    		$this->ajaxReturn((ReturnMsg::builder(OK)));
    	else
    		$this->ajaxReturn((ReturnMsg::builder(NO)));
    }
}