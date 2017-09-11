<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use app\index\model\Login;
class Index extends Controller
{
    public function index()
	{
//		if(request()->ispost())
//		{
//			$data=[
//			'username'=>input('username'),
//			'password'=>input('password'),
//			];
//  		if(db('admin')->insert($data)){
//  			return $this->success('添加管理员成功！');
//  		}else{
//  			return $this->error('添加管理员失败！');
//  		}
//		}
//		return $this->fetch();
		if(request()->ispost())
		{
			$data=[
			'username'=>input('username'),
			'password'=>input('password'),
			'ruleid'=>input('ruleid'),
			];
			$validate=\think\Loader::validate('Index');
			if(!$validate->scene('login')->check($data)){
				$this->error($validate->geterror());die;
			}
		$test=new Login();
		$num=$test->login($data);
		if($num==1)
		{
			return $this->error('用户不存在!!');
		}
		if($num==4)
		{
			return $this->error("角色选择错误！");
		}
		if($num==3)
		{
			if($data['ruleid']==1)
			{

//				$teach=Db::name('teachers')->where('teacherName','=',$data['username'])->find();
//				$t_id=$teach['teacherId'];
//				$list=Db::name('schedule')->where('teacherId','=',$t_id)->find();
//				$course_Name=Db::name('course')->where('courseId','=',$list['courseId'])->find();
//				$class_view=Db::name('class')->where('class','=',$list['class'])->find();
//				$de_name=Db::name('department')->where('departmentId','=',$class_view['departmentId'])->find();
//				$pr_name=Db::name('profession')->where('professionId','=',$class_view['professionId'])->find();
				$teach=Db::name('teachers')->where('teacherName','=',$data['username'])->find();
				$list=Db::name('schedule')->where('teacherId','=',$teach['teacherId'])->select();
				foreach($list as $k=>$val)//遍历教师ID  查询教师管理课程
				{
				$course_Name=Db::name('course')->where('courseId','=',$val['courseId'])->find();
				$class_view=Db::name('class')->where('class','=',$val['class'])->find();
				$de_name=Db::name('department')->where('departmentId','=',$class_view['departmentId'])->find();
				$pr_name=Db::name('profession')->where('professionId','=',$class_view['professionId'])->find();
				$this->assign('de_name',$de_name);
				$this->assign('pr_name',$pr_name);
				$this->assign('course_Name',$course_Name);
				$this->assign('list',$list);
				}
				return $this->fetch('teacher');
				
			}
			elseif($data['ruleid']==2)
			{
				return $this->fetch('admin');
			}
			elseif($data['ruleid']==3)
			{
				return $this->fetch('fadmin');
			}
			elseif($data['ruleid']==4)
			{
				return $this->fetch('student');
			}
		}
		elseif($num==2)
		{
			return $this->error('登陆失败，用户名或密码错误');
		}
		}
		return $this->fetch();
	}
	public function mistake()
	{
		return $this->fetch();
	}
	public function logout()
	{
		session(null);
        $this->success('退出成功！','index');
	}
	public function passwordEdit()
	{
		$name=input('id');
		$users=db('user')->where('name','=',$name)->find(); 
		$uid=$users['userId'];
		$this->assign('users',$users);
		if(request()->ispost())
		{
		$n_password=input('password');
		$pass=[
		'username'=>input('username'),
		'password'=>$n_password,
		];
			$validate=\think\Loader::validate('Index');
			if(!$validate->check($pass)){
				$this->error($validate->geterror());die;
			}
		$res=Db::table('user')->where('userId',$uid)->update(['password'=>$n_password]);
		if($res!==false)
		{
			return $this->success('修改成功!!返回重新登陆','index');
		}
		else{
			return $this->error('修改失败');
		}
		}
    	return $this->fetch();
	}
}
