<?php
namespace Home\Controller;
use Think\Controller;
use Home\Common\Face;
class IndexController extends Controller {
    public function index(){
//     	$this->assign("scanUrl",U('Index/recordScan'));
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
    			echo "成功添加脸部数据！";
    		else
    			echo "添加失败，请再次录入数据";
    	}
    	else
    	{
    		echo "检测不到脸部数据";
    	}
    }
    public function signupScan(){
    		$data=Face::searchPersonByData($_POST['img']);
    		if(count($data)>1)
    		{
    			$candidates=$data['candidate'];
    			$face_id=$data['face_id'];
    			echo count($candidates)."人与你相似，分别是\n";
    			foreach($candidates as $k => $v)
    			{
    				echo $v['person_name'].",相似度为：".$v['confidence']."\n";
    			}
				Face::addFaceToPerson($face_id, $candidates[0]['person_name']);
    		}
    		else
    		{
    			if($data==WITHOUT_CANDIDATE)
    				echo "没有人与你相似";
    			else if($data==WITHOUT_FACE_DATA)
    				echo "扫描不到脸部信息";
    				
    		}
    		
    }
    public function singup(){
    	
    }
}