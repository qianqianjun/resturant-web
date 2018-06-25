<?php
	namespace app\index\model;
	use think\Model;
	class Managerreply extends Model
	{
		public function Addreply($data){
			$res=$this->save($data);
			return $res;
		}	
		public function selectReply(){
			$res=$this->order('time', 'desc')->field('description,replypeople,time,replyid,id')->select(); 
			return $res;
		}	
 		
	}
?>