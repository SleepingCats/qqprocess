<?php
namespace app\common\validate;
use think\Validate;
class Admin extends Validate
{
	protected $rule =[
	'name'=>'require|max:25|unique:user',
	'password'=>'require|max:25',
	];
	protected $message=[
	'name.require'=>'姓名必须填写',
	'name.max'=>'姓名过长，请检查',
	'name.unique'=>'姓名重复，请检查',
	'password.require'=>'密码必须填写',
	'password.between'=>'密码长度不符合规范',
	];
		
}
?>