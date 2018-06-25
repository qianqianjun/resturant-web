<?php
	namespace app\index\model;
	use think\Model;
	class Dish extends Model
	{
		public function selectDish(){
			$res=$this->order('id', 'desc')->field('id,name,price,picture,description,address,label,starnum,evaluatenum,time')->select(); 
			return $res;	
		}
		public function selectDish2(){
			$res=$this->order('starnum', 'desc')->field('id,name,price,picture,description,address,label,starnum,evaluatenum,time')->select(); 
			return $res;	
		}
		public function selectDish3(){
			$res=$this->order('evaluatenum', 'desc')->field('id,name,price,picture,description,address,label,starnum,evaluatenum,time')->select(); 
			return $res;	
		}
		public function selectDish4($dat){
			$res=$this->order('id', 'desc')->field('id,name,price,picture,description,address,label,starnum,evaluatenum,time')->select();
			$ress=array(array()); 
			$m=0;
			for ($i=0; $i <count($res) ; $i++) { 
				$lis=explode("%", $res[$i]['label']);
				for ($j=0; $j <count($lis) ; $j++) { 
					if ($lis[$j]==$dat) {
						$ress[$m]=$res[$i];
						$m++;
						break;
					}
				}
			}
			return $ress;	
		}
 		public function selectDish5($dat){
			$res=$this->where($dat)->field('id,name,price,picture,description,address,label,starnum,evaluatenum,time')->select(); 
			return $res;	
		}
		public function searchbyid($id)
		{
			$res=$this->where('id',$id)->select();
			return $res[0];
		}
	}
?>