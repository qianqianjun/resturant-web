<?php
	namespace app\index\model;
	use think\Model;//注意大小写，Model指的是基类，并不是文件夹的名字
	//使用命名空间
	/**
	* 
	*/
	class Replymessage extends Model//Model类为首字母大写
	{
		public function selectText(){
			$res=$this->order('id desc')->field('account,time,picture,description,id')->select(); 
			return $res;
		}	
		public function searSelectReply($dat){
			$map['account']=$dat;
 			$res=$this->where($map)->order('time', 'desc')->field('account,time,picture,description,id')->select(); 
			return $res;
 		}
 	
	}
?>