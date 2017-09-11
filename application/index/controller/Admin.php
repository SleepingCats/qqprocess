<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
class Admin extends Controller
{
	public function addteacher()
	{
		if(request()->ispost())
		{
			$data=[
			'name'=>input('username'),
			'password'=>input('password'),
			'rule'=>'1'
			];
			$validate=\think\Loader::validate('Admin');
			if(!$validate->check($data)){
				$this->error($validate->geterror());die;
			}
    		if(db('user')->insert($data)){
    			return $this->success('添加教师成功！');
    		}else{
    			return $this->error('添加教师失败！');
    		}
		}
		return $this->fetch();
	}
		public function addfadmin()
	{
		if(request()->ispost())
		{
			$data=[
			'name'=>input('username'),
			'password'=>input('password'),
			'rule'=>'3'
			];
			$validate=\think\Loader::validate('Admin');
			if(!$validate->check($data)){
				$this->error($validate->geterror());die;
			}
    		if(db('user')->insert($data)){
    			return $this->success('添加教辅管理员成功！');
    		}else{
    			return $this->error('添加教辅管理员失败！');
    		}
		}
		return $this->fetch();
	}
			public function addstudent()
	{
				if(request()->ispost())
		{
			$data=[
			'name'=>input('username'),
			'password'=>input('password'),
			'rule'=>'4'
			];
			$validate=\think\Loader::validate('Admin');
			if(!$validate->check($data)){
				$this->error($validate->geterror());die;
			}
    		if(db('user')->insert($data)){
    			return $this->success('添加学生成功！','admin');
    		}else{
    			return $this->error('添加学生失败！');
    		}
		}
		return $this->fetch();
	}

}
?>