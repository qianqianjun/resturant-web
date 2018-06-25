<?php
/**
*萌芽杯项目
*高谦 杨静 朱迪迪 余中瑞
*/
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
	//注销登录(高谦)
	public function logoout()
	{
		setcookie("user","");
		return "注销";
	}
	//索引文件（高谦）
	public function index()
	{
		if(input('cookie.user')!="")
		{
			return $this->redirect("Index/manager");
		}
		else
		{
			return $this->fetch("Index/login");
		}
	}
	//注销登陆（高谦）
	public function logout()
	{
		setcookie("user","");
		return $this->redirect('Index/index');
	}
	//生成管理员界面(高谦)
	public function manager()
	{
		if (isset($_COOKIE["user"])&&$_COOKIE["user"]!="") 
		{
			$user=input('cookie.user');
			$PowerNum=5;
			$model=model("User");
			$user=input('cookie.user');
			$style=$model->GetPower($user,$PowerNum);
			$this->assign('user',$user);
			$this->assign('style',$style);
			$model1=model('Dish'); 
			$list=$model1->selectDish();
			$list=$model1->order('id', 'desc')->paginate(3);	
			for ($i=0; $i <count($list) ; $i++) { 
					$lis=explode("%", $list[$i]['label']);
					$list[$i]['label']='';
					for ($j=0; $j <count($lis) ; $j++) { 
						$list[$i]['label']=$list[$i]['label']."  ".$lis[$j];
					}
				}
			$this->assign('list', $list);
			return $this->fetch("Index/manager");
		}
		else
		{
			return $this->redirect('Index/index');
		}
	}
	//解析权限（高谦）
	public function getpower()
	{
		// if (isset($_POST["data"])&&$_POST["data"]!="")
		if(input('post.data')!="") 
		{
			// $str=$_POST["data"];
			$str=input('post.data');
			switch ($str) {
				case 'replymanager':
					return $this->redirect('Index/replymanager');
					break;
				case 'replymanager1':
					return $this->redirect('Index/searchuser');
					break;
				case 'powermanager':
					return $this->redirect('Index/powermanager');
					break;
				case 'givepowermanager':
					return $this->fetch('Index/givepowermanager');
					break;
				case 'viewdish':
				    return $this->redirect('Index/viewdish');
				    break;
				case 'dishreply':
				    return $this->redirect('Index/dishreply');
				    break;
				case 'publishdish':
				    return $this->fetch('Index/publishdish');
				case 'dishmanager':
				    return $this->redirect('Index/dishmanager');
				default:  //菜品一览;
					return "默认";
					break;
			}
       }
	}

	//获得管理员信息(高谦)
	public function powermanager()
	{
		$model=model('User');
		$result= $model->order('id','desc')->select();
		$this->assign('userdata',$result);
		return $this->fetch('Index/powermanager');
	}
	//禁止登陆，允许登陆功能实现（高谦）
	public function loginmanager()
	{
		$id=input('post.id');
		$kind=input('post.kind');
		$user = model('User');
		$user->save([
				    'status' => $kind
				],['id' => $id]);
		return 0;
	}
	//查看所有菜的简略信息（高谦）
	public function viewdish()
	{
		$model=model('Dish'); 
		$list=$model->selectDish();
		$list=$model->order('id', 'desc')->paginate(3);	
		for ($i=0; $i <count($list) ; $i++) { 
				$lis=explode("%", $list[$i]['label']);
				$list[$i]['label']='';
				for ($j=0; $j <count($lis) ; $j++) { 
					$list[$i]['label']=$list[$i]['label']."  ".$lis[$j];
				}
			}
		
		$this->assign('list', $list);
		return $this->fetch('Index/viewdish');
	}
	// 获取菜的详细信息 （高谦）
	public function getdishdetail()
	{
		$id=input('post.id');
		$model=model('Dish');
		$result=$model->searchbyid($id);
		$this->assign('result',$result);
		return $this->fetch('Index/dishdetail');
	}
	//菜品管理功能
	public function dishmanager()
	{
		$model=model('Dish');
		$list=$model->order('id','desc')->select();
		$this->assign('list',$list);
		return $this->fetch('Index/dishmanager');
	}
	//回复菜的评论（杨静）
	function dishreply()
	{
		$model=model('Dishcomment');
		$model1=model('Dishcommentreply'); 
		// $model2=model('Dish'); 
		// $list1=$model2->selectDish();
   //      $list1=$model2->order('id', 'desc')->paginate(5);
   //      	for ($i=0; $i <count($list1) ; $i++) { 
			// 	$lis=explode("%", $list1[$i]['label']);
			// 	$list1[$i]['label']='';
			// 	for ($j=0; $j <count($lis) ; $j++) { 
			// 		$list1[$i]['label']=$list1[$i]['label']."  ".$lis[$j];
			// 	}
			// }	
		
		$su_list1=$model->selectcomment();
		$re_list1=$model1->selectcommentreply();
		$lis=array(array(array()));
		for ($i=0; $i <count($su_list1) ; $i++) { 
			$lis[$i]['su_id']=$su_list1[$i]['id'];
			$lis[$i]['su_time']=$su_list1[$i]['time'];
			$lis[$i]['su_dish']=$su_list1[$i]['dishname'];
			$lis[$i]['su_account']=$su_list1[$i]['account'];
			$lis[$i]['su_picture']=$su_list1[$i]['picture'];
			$lis[$i]['su_content']=$su_list1[$i]['content'];
			$lis[$i]['re']=array(array('re_description'=>'','replypeople'=>'','re_time'=>''));

		}
		$k=0;
		foreach ($re_list1 as $key => $value) {
			$re_list1[$k]=$value;
			$k++;
		}
		$m=0;
		for ($i=0; $i <count($su_list1) ; $i++) { 			
			for ($j=0; $j <count($re_list1) ; $j++) { 
				if ($su_list1[$i]['id']==$re_list1[$j]['replyid']) {
					$lis[$i]['re'][$m]['re_description']=$re_list1[$j]['description'];
					$lis[$i]['re'][$m]['replypeople']=$re_list1[$j]['replypeople'];
					$lis[$i]['re'][$m]['re_time']=$re_list1[$j]['time'];
					$m++;
				}
			}
		}
		

		// $list=array(array(array()));
		// for ($i=0; $i <count($list1) ; $i++) { 
		// 	$list[$i]['id']=$list1[$i]['id'];
		// 	$list[$i]['name']=$list1[$i]['name'];
		// 	$list[$i]['price']=$list1[$i]['price'];
		// 	$list[$i]['picture']=$list1[$i]['picture'];
		// 	$list[$i]['description']=$list1[$i]['description'];
		// 	$list[$i]['address']=$list1[$i]['address'];
		// 	$list[$i]['label']=$list1[$i]['label'];
		// 	$list[$i]['starnum']=$list1[$i]['starnum'];
		// 	$list[$i]['evaluatenum']=$list1[$i]['evaluatenum'];
		// 	$list[$i]['time']=$list1[$i]['time'];
		// 	$list[$i]['sub']=array(array('su_id'=>'','su_time'=>'','su_account'=>'','su_picture'=>'','su_content'=>'','re'=>'','su_dishid'=>''));

		// }
		// $n=0;
		// for ($i=0; $i <count($list) ; $i++) { 			
		// 	for ($j=0; $j <count($lis) ; $j++) { 
		// 		if ($list[$i]['id']==$lis[$j]['su_dishid']) {
		// 			$list[$i]['sub'][$n]['su_id']=$lis[$j]['su_id'];
		// 			$list[$i]['sub'][$n]['su_time']=$lis[$j]['su_time'];
		// 			$list[$i]['sub'][$n]['su_account']=$lis[$j]['su_account'];
		// 			$list[$i]['sub'][$n]['su_picture']=$lis[$j]['su_picture'];
		// 			$list[$i]['sub'][$n]['su_content']=$lis[$j]['su_content'];
		// 			$list[$i]['sub'][$n]['re']=$lis[$j]['re'];
		// 			$list[$i]['sub'][$n]['su_dishid']=$lis[$j]['su_dishid'];
		// 			$n++;
		// 		}
		// 	}
		// }
		// $page =$su_list1->render();
		$this->assign('list', $lis);
		// $this->assign('page', $page);
		return $this->fetch('Index/dishreply');
	}
	//反馈管理（杨静）
	public function replymanager()
	{
		$model=model('Replymessage'); 
		$list1=model('Replymessage')->selectText();
        $list1=$model->order('id', 'desc')->paginate(10);
		$model1=model('Managerreply');
		$re_list1=model('Managerreply')->selectReply();
		$list=array(array(array()));
		for ($i=0; $i <count($list1) ; $i++) { 
			$list[$i]['id']=$list1[$i]['id'];
			$list[$i]['time']=$list1[$i]['time'];
			$list[$i]['account']=$list1[$i]['account'];
			$list[$i]['picture']=$list1[$i]['picture'];
			$list[$i]['description']=$list1[$i]['description'];
			$list[$i]['sub']=array(array('re_description'=>'','replypeople'=>'','re_time'=>'','re_id'=>''));

		}
		$k=0;
		foreach ($re_list1 as $key => $value) {
			$re_list1[$k]=$value;
			$k++;
		}
		$m=0;
		for ($i=0; $i <count($list1) ; $i++) { 			
			for ($j=0; $j <count($re_list1) ; $j++) { 
				if ($list1[$i]['id']==$re_list1[$j]['replyid']) {
					$list[$i]['sub'][$m]['re_description']=$re_list1[$j]['description'];
					$list[$i]['sub'][$m]['replypeople']=$re_list1[$j]['replypeople'];
					$list[$i]['sub'][$m]['re_time']=$re_list1[$j]['time'];
					$list[$i]['sub'][$m]['re_id']=$re_list1[$j]['id'];
					$m++;
				}
			}
		}
		$page = $list1->render();
		$this->assign('list', $list);
		$this->assign('page', $page);
		 return $this->fetch('Index/replymanager');

	}
	public function replyuser(){
		$data['replyid']=input("post.id");
		$data['description']=input("post.replytext");
		$data['replypeople']=input("cookie.user");
		$t=time();
		$data['time']=date("Y-m-d H:i:s",$t);
		$res=model('Managerreply')->Addreply($data);
		return $data['replyid'];
	}
	//菜品评论回复 杨静
	public function replydishuser(){
		$data['replyid']=input("post.id");
		$data['description']=input("post.replytext");
		$data['replypeople']=input("cookie.user");
		$t=time();
		$data['time']=date("Y-m-d H:i:s",$t);
		$res=model('Dishcommentreply')-> Adddishreply($data);
		return $data['replyid'];
	}


	/*
	//反馈搜索 杨静
	public function searchuser(){


		$dat=input("post.account");
		// $dat=$this->replypsearchuser;
		$list1=model('Replymessage')->searSelectReply($dat);
        // $list1=model('Replymessage')->where($dat)->order('id', 'desc')->paginate(10);
		$re_list1=model('Managerreply')->selectReply();
		$list=array(array());
		for ($i=0; $i <count($list1) ; $i++) { 
			$list[$i]['id']=$list1[$i]['id'];
			$list[$i]['time']=$list1[$i]['time'];
			$list[$i]['account']=$list1[$i]['account'];
			$list[$i]['picture']=$list1[$i]['picture'];
			$list[$i]['description']=$list1[$i]['description'];
			$list[$i]['sub']=array(array('re_description'=>'','replypeople'=>'','re_time'=>'','re_id'=>''));

		}
		$k=0;
		foreach ($re_list1 as $key => $value) {
			$re_list1[$k]=$value;
			$k++;
		}
		$m=0;
		for ($i=0; $i <count($list1) ; $i++) { 			
			for ($j=0; $j <count($re_list1) ; $j++) { 
				if ($list1[$i]['id']==$re_list1[$j]['replyid']) {
					$list[$i]['sub'][$m]['re_description']=$re_list1[$j]['description'];
					$list[$i]['sub'][$m]['replypeople']=$re_list1[$j]['replypeople'];
					$list[$i]['sub'][$m]['re_time']=$re_list1[$j]['time'];
					$list[$i]['sub'][$m]['re_id']=$re_list1[$j]['id'];
					$m++;
				}
			}
		}
		// $page = $list1->render();
		$this->assign('list', $list);
	    return $this->fetch('Index/replymanager');
		//return $list;

	}
	public function replypsearchuser()
	{
		$dat=input("post.account");
		$model=model("replymessage");
		$model->select();

		return $dat;
	}*/
	//授权管理员  杨静
	public function signup(){
		$dat=$_POST;
		$data['name']=$dat['name'];
		$data['office']=$dat['office'];
		$data['phone']=$dat['tel'];
		$data['mail']=$dat['email'];
		$data['gender']=$dat['gender'];
		$data['account']=$dat['account'];
		$data['password']=md5($dat['password']);
		$data['status']="1";
		$dataa=array('菜品一览','用户授权','反馈管理','菜品操作','权限管理');
		$data1= array('0','0','0','0','0');
		$datt=array();
		$i=0;
		foreach($dat['power'] as $key => $value){
		        $datt[$i] = $value;
		        $i++;
		    }	
		for ($i=0; $i <count($datt) ; $i++) { 
			for ($j=0; $j < count($dataa); $j++) { 
				if ($dataa[$j]==$datt[$i]) {
					$data1[$j]="1";
					break;
				}
				
			}
		}
		$data['power']=implode("%",$data1);
		$res=model('User')->addUser($data);
		if ($res) {
			echo "<script>alert('管理员授权成功!');</script>";
			return $this->redirect("Index/manager");
		}
		else
		{
			echo "<script>alert('失败');</script>";
		}
	}
	//删除评论 朱迪迪
	public function deleteComments()
	{
		$id=input("post.id");
		$res=model('Dishcomment').delete($id);
		if($res)
		{
			echo "<script>alert('删除成功');</script>";
		}
		else
		{
			echo "<script>alert('删除失败');</script>";
		}
		return $this->fetch();
	}
	//登陆功能(朱迪迪)
	public function login()
	{
		//检测有没有cookie
		if(input('cookie.user')!="")
			return $this->redirect("Index/manager");
		//获取到用户输入的表单名和密码
		if(input('post.account')&&input('post.password'))
		{
			$model=model('User');
			$map['account']=input('post.account');
			$res=$model->where($map)->select();
			if($res)
			{
				$password=md5(input('post.password'));
				if($res[0]["password"]==$password)
				{
					if ($res[0]["status"]==1) {
						echo "<script>alert('登陆成功');</script>";
						setcookie("user",input('post.account'));
						return $this->redirect("Index/manager");
					}
					else
					{
						echo "<script>alert('您没有登录权限，请联系超级管理员');history.back();</script>";
					}
				}
				else  
				{
					echo "<script>alert('密码错误');</script>";
					return $this->fetch("login");
				}
			}
			else
			{
				echo "<script>alert('账号不存在');</script>";
				return $this->fetch("login");
			}	
			
		}
		else
		{
			return $this->fetch('login');
		}
		
	}
	// 发布新的菜（高谦）
	public function upload()
	{
	    $file = request()->file('image');
	    if ($file==NULL) {
	    	echo "<script>alert('图片数据提交失败');history.back();</script>";
	    }
	    else
	    {
		    $info = $file->validate(['ext'=>'jpg,png,gif'])->rule('uniqid')->move(ROOT_PATH . 'public/static/' . DS . 'uploads');
		    // $info=true;
		    //如果一切正常，则要进行新菜的存储操作
		    if($info)
		    {
		        // echo $info->getExtension()."<br>";
		        // echo $info->getSaveName()."<br>";
		        // echo $info->getFilename()."<br>"; 
		        // $url=$info->getSaveName();
		        $taste=$_POST["taste"];
		        $sort=input("post.sort");
		        $lab=implode("%",$taste);
		        $label=$lab."%".$sort;
		        $data["name"]=input("post.name");
		        $data["address"]=input("post.address");
		        $data["owner"]=input("post.owner");
		        $data["price"]=input("post.price");
		        $data["description"]=input("post.description");
		        $data["label"]=$label;
		        //默认新菜的星级为5;
		        $data["starnum"]=1;
		        $data["evaluatenum"]=0;
		        $data["time"]=date("Y-m-d H:i:s");
		        $data["owner"]=input("cookie.user");
		        $data["ownerphone"]=input("post.ownerphone");
		        $data["picture"]=$info->getSaveName();
		        $data["status"]=0;
		        $model=model("Dish");
		        $model->save($data);
		        echo "<script>alert('添加成功');window.location.href='manager.html';</script>";
		    }
		    else
		    {
		        echo "<script>alert('服务器存储异常！');history.back();</script>";
		    }
		}
    }
    //对菜的下架上架操作（高谦）
    public function dropoffon()
    {
    	$id=input("post.id");
    	$model=model("Dish");
    	$old=$model->where('id',$id)->select();
    	$oldstatus=$old[0]['status'];
    	$newstatus=($oldstatus+1)%2;
    	$model->where('id', $id)->update(['status' => $newstatus]);
    	return true;
    }
    //权限管理，修改（高谦）
    public function fixpower()
    {
    	$power=input("post.power");
    	$account=input("post.account");
    	$model=model("User");
    	$model->where('account',$account)->update(['power' => $power]);
    	return true;
    }
    //返回菜品一栏搜索数据
    public function searchinfo()
    {
    	$type=input("post.type");
    	$info =input("post.info");
    	$model=model($type);
    	//多列同条件查询
    	$result=$model->where('name|price|description|address|label|time|owner|ownerphone','like','%'+$info+'%')->select();
    	$this->assign('list',$result);
    	return $this->fetch("Index/searchdishresult");
    }
}
?>
