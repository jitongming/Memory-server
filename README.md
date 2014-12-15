Memory-server
=============

注意事项
-------------------------

因为使用了rewrite模块来改写URL，所以请根据项目的文件夹改写Base的值。若所用环境不支持rewrite，无法访问类似于/momory/user/add的目录的时候请使用类似/memory/index.php/user/add的方式来访问。    

###使用model访问数据库##

    class userController extends Controller {
      public function index() {
        $user = $this ->model('user', 'user'); 
		    // model操作代码
		  }
		}

无论进行任何操作都需要初始化一个访问数据库的model，第一个参数为对应的model类名，第二个参数为对应的表名。    
每个model都有四个方法（增，删，改，查），代码参考app/memo/model.php    
调用add()方法之前需要调用set()方法为其对应字段赋值   

    $user ->set('email', 'abc@abc.com'); 
    $user ->set('password', '987654321'); 
		$user ->set('status', 1);  

fetch()方法会根据数据库中的将对应的字段赋上值   
update()方法会更新对应的数据行    
delete()会删除对应的数据行  


岁月静好-软件工程大作业
