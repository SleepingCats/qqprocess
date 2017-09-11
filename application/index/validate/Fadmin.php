<?php
namespace app\common\validate;
use think\Validate;
class Fadmin extends Validate
{
    protected $rule =[
        'name'=>'require|max:25',
    ];
    protected $message=[
        'name.require'=>'名字必须填写',
    ];

}