<?php

namespace Home\Common;
/*
 * 一个用于构建返回信息结构的一个类
 */
class ReturnMsg{
	public $msg="提示信息";//
	public $status=0;//状态码
	public $body=array();//对象体
	public function __construct($status=0,$body=array(),$msg=""){
		$this->msg=$msg;
		$this->status=$status;
		if($msg=="")
		switch ($this->status)
		{
			case ADD_OK:                                       $this->msg="添加成功";break;
			case WITHOUT_FACE_DATA:                 $this->msg="检测不到脸部数据";break;
			case WITHOUT_CANDIDATE:                $this->msg="找不到匹配的人";break;
			case ADD_NO:                                      $this->msg="添加失败";break;
			case OK:												 $this->msg="成功";break;
			case NO:												 $this->msg="请求不成功";break;
		}
		$this->body=$body;
		
	}
	public static function builder($status=0,$body=array(),$msg=""){
		return new ReturnMsg($status,$body,$msg);
	}
}

?>