<?php
	namespace app\index\model;
	use think\Model;
	class Dishcomment extends Model
	{
		public function selectcomment(){
			$res=$this->order('id', 'desc')->field('id,account,content,picture,dishname,time')->select(); 
			return $res;	
		}
	}
?>