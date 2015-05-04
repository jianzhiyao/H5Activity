<?php
namespace Home\Common;
use  Home\Common\Facepp;
class Face {
	static $group_name="wyu";
	public static function detectFaceByData($faceData){
		$facepp = new Facepp();//新建一个facepp对象
		//设置检测参数
		$params['img']          = saveImgReturnRealPath($faceData);
		$params['attribute']    = 'gender,age,race,smiling,glass,pose';
		$params['mode']    = 'oneface';
		
		$response = $facepp->execute('/detection/detect',$params);
		
		if($response['http_code'] == 200) {
			$data = json_decode($response['body'], 1);
			if(count($data['face']))
			{
				//有识别出脸部
				$face=$data['face'][0];
				//返回脸部信息
				return $face;
			}
			else
			{
				//返回为空
				return WITHOUT_FACE_DATA;
			}
		}
		else
		{
			return NETWORK_ERROR;
		}
	}
	public static function addFaceToPerson($faceId,$personId){
		$facepp = new Facepp();//新建一个facepp对象
		$response = $facepp->execute('/person/add_face',array("person_name"=>$personId,"face_id"=>$faceId));
		if($response['http_code'] == 200) {
			$data = json_decode($response['body'], 1);
			
			if($data['added']>0)
			{
				return ADD_OK;
			}
			else
			{
				return ADD_NO;
			}
		}
		else
		{
			return NETWORK_ERROR;
		}
		
	}
	public static function createPerson($personid){
		$facepp = new Facepp();//新建一个facepp对象
		$response = $facepp->execute('/person/create',array("person_name"=>$personid,"group_name"=>Face::$group_name));
		if($response['http_code'] == 200) {
			return $response;
		}
		else
		{
			return NETWORK_ERROR;
		}
	}
	public static function searchPersonByData($faceData){
		$facepp = new Facepp();//新建一个facepp对象
		//train
		
		
		$params['img']          = saveImgReturnRealPath($faceData);
		$params['group_name']          = Face::$group_name;
		$response = $facepp->execute('/recognition/identify',$params);
		$facepp->execute('/train/identify',array("group_name"=>Face::$group_name));
		if($response['http_code'] == 200) {
			$data = json_decode($response['body'], 1);
			
			if(count($data['face'][0]))
			{
				//有候选人
				$faceArr=$data['face'][0];
				if(count($faceArr['candidate']))
					return $faceArr;//存在候选人
				else
					return WITHOUT_CANDIDATE;//不存在候选人
			}
			else
			{
				//检测不到脸部数据
				return WITHOUT_FACE_DATA;
			}
		}
		else
		{
			return NETWORK_ERROR;
		}
	}
}
function saveImgReturnRealPath($imgData){
	$img = convert_data($imgData);
	$fileName = substr(md5(date().rand(0, 5000)),0,6).".png";//通过时间和随机数获得六位的文件名，防止太多的时候冲突
	save_to_file( $img ,  "Public\\".$fileName );
	return realpath("Public\\".$fileName);
}
function convert_data($data){
	return base64_decode(str_replace('data:image/png;base64',',',$data));
}
function save_to_file($image,$filename){
	$fp=fopen($filename,'w');
	fwrite($fp,$image);
	fclose($fp);
}
?>