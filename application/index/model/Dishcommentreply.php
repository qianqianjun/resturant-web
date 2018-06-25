<?php
	namespace app\index\model;
	use think\Model;
	class Dishcommentreply extends Model
	{
		public function selectcommentreply(){
			$res=$this->order('id', 'desc')->field('id,replyid,replypeople,description,time')->select(); 
			return $res;	
		}
		public function Adddishreply($data){
			$res=$this->save($data);
			return $res;
		}	
 	
	}
?>