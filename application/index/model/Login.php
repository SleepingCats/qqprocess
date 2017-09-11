<?php
namespace app\index\model;
use think\Controller;
use think\Db;
use think\Model;
class Login extends Model 
{
	public function login($data)
	{
		$user=Db::name('user')->where('name','=',$data['username'])->find();
		if($user){
			if($user['password'] == $data['password']&&$user['rule']==$data['ruleid']){
				session('username',$user['name']);
				session('id',$user['userId']);
				return 3; //信息正确
			}
			elseif($user['password'] == $data['password']&&$user['rule']!=$data['ruleid'])
			{
				return 4;//权限选择不正确
			}
			else{
				return 2; //密码错误
			}
		}
		else{
			return 1; //用户不存在
		}
	}
	public function view($data)
	{
				$teach=Db::name('teachers')->where('teacherName','=',$data['username'])->find();
				$t_id=$teach['teacherId'];
				$list=Db::name('schedule')->where('teacherId','=',$t_id)->find();
				$couese_Name=Db::name('course')->where('courseId','=',$list['courseId'])->find();
				$class_view=Db::name('class')->where('class','=',$list['class'])->find();
				$de_name=Db::name('department')->where('departmentId','=',$class_view['departmentId'])->find();
				$pr_name=Db::name('profession')->where('professionId','=',$class_view['professionId'])->find();
				return $list;
				return $couese_Name;
				return $de_name;
				return $pr_name;
	}
}
?>