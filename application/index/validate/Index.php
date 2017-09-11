<?php
namespace app\common\validate;
use think\Validate;
class Index extends Validate
{
	protected $rule =[
	'username'=>'require|max:25',
	'password'=>'require|max:25',
	];
	protected $message=[
	'username.require'=>'姓名必须填写',
	'username.max'=>'姓名过长，请检查',
	'username.unique'=>'姓名重复，请检查',
	'password.require'=>'密码必须填写',
	'password.between'=>'密码长度不符合规范',
	];
		
}

?>