<?php
//访问路径：http://localhost/thinkphp/public/index.php/index/index/index
//上例的index.php/index/index/index指的是“public下面的index.php文件/application下面的Index文件夹/icontroller下的index文件或类/上一个index文件中的方法”
//声明命名空间，实际上是指当前文件在项目文件目录的实际文件存在目录
//app指的是application（根命名空间）
//index指的是index文件夹
//controller指的是index文件夹下面的controller文件夹
namespace app\index\controller;
//注意：类名要与当前文件名对应相同，且类的首字母要大写
use think\Controller;
class Index extends Controller
 {  /*函数命名使用驼峰命名
 	*1、单个单词命名的函数 ，单词必须是全小写
 	*2、多个单词命名的函数，第一个单词是全小写，从第二个单词开始首字母大写。
 	*/
    public function index ()
    {	//User指的是表名
    	//表名的首字母大写，表名的格式为tp_user_type要写成model('UserType');tp_usertype要写成model('Usertype');其中tp_指的是数据库表的前缀

    	//$model=model('User');
    	//$map['id']=24;//数组访问的方法，数组的Key代表数据库的列名，数组的value对应列名对应的值
    	/*$map['username']='444444';
    	$map['id']=31;
    	$res=$model->where($map)->select();
    	*/
    	//$res=$model->where('id=24 or id=31')->select();//注意：$res不是结果集，而是一个数组对象
    	//$res=$model->where($map)->select();
    	/*$map1['id']=25;
    	$map2['id']=31;
    	$res=$model->where($map1)->whereOr($map2)->select();*/
    	//$map['id']=['in','28,31'];
    	/*$map['id']=['not in',[24,31]];
    	$res=$model->where($map)->select();
    	*/
    	/*$map['username']=['not like','%34%'];
    	$res=$model->where($map)->select();
    	*/
    	/*foreach ($res as $key => $value) {//$value指的是对象
    		//echo "name".$value['username']."<br>";
    		echo "account".$value->username."<br>";
    	}*/
    	//echo "HELLO WORLD";
    	return $this ->fetch();//调用视图
        // echo APP_PATH."../public/static/css/index.css";
        // echo '/'.basename(ROOT_PATH).'/public/static/css/index.css';
        /*路径方法
     //    echo request()->url();
     //    $arr=explode("/", trim(request()->url()));//explode()将字符串切割成数组，第一个参数为 切割符，第二个参数为需要切割的字符
     //    var_dump($arr);
     //    $index=array_search('public',$arr);//数组查询元素的函数，第一个参数代表数组key对应的value；array_keysearch()的第一个参数代表数组key
     //    var_dump($index);
    	// $path=array_slice($arr,0,$index);//该函数为数组截断的函数，第一个参数为需要截断的数组，第二个参数为开始截断的位置，第三个参数为截断的长度
     //    var_dump($path);
     //    $path=implode("/", $path);//将数组拼接成字符串，第一个参数为字符串的连接符，第二个参数为需要拼接的数组
     //    var_dump($path);
     */
        /*$map['username']="444444";
        $res=$model->where($map)->select();
        $res[0]->username="222242";
        //var_dump($res[0]->password);
        $res[0]->save();*///数据更新
        // $model->username="234567";
        // $model->password="111111111";
        // $model->save();//数据插入
        // $view = new View();
        // return $view->fetch('index');
        //return view('register');
        // $this->assign('domain',$this->request->url(true));
        // return $this->fetch('index');
          //echo "hello world";
        //return "hello world";
        //return json(['name'=>'thinkphp','status'=>1]);

    }
     public function test (){
     	//echo "WORLD";//input("post.username")相当于$_['username']
        // $username=input("post.username");
        // var_dump($username);
        $model=model('User');
        $username=input("post.username");
        $password=input("post.password");
        // var_dump($username);
        // var_dump($password);
        $res = 'success';   
        return $res;
        // echo DS;
        
    }
    public function test2(){
        return $this->fetch('log');
    } 
    public function test3(){
        $model=model('User');
        $username=input("post.username");
        $password=input("post.password");
        return $this->fetch('content');
    }
     public function test4(){
        $modell=model('Message');
        $content=input("post.content");
        $topic=input("post.topic");
        $modell->username=$username;
        $modell->password=$password;
        $modell->save();

    }
}
