<?php
namespace app\index\model;
use think\Model;
class User extends Model
{
	public function GetPower($user,$num)
	{
		$sql=$this->where("account",$user)->field('power')->select();
		$res=$sql[0]['power'];
		// $result=array();
		// for($i=$num-1;$i>=0;$i--)
		// {
		// 	$result[$i]=$res%10;
		// 	$res=$res/10;
		// }
		$result=explode("%", $res);
		$style=array();
		for($i=0;$i<$num;$i++)
		{
			if($result[$i]==1)
			{
				$style[$i]="";
			}
			else
			{
				$style[$i]="display:none";
			}
		}
		return $style;
	}
	public function addUser($data){
			$res=$this->save($data);
			return $res;
	}
}
?>