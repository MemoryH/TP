<?php
namespace app\admin\validate;


use think\Validate;

class Property extends Validate{
    protected $rule = [
        ['name', 'require', '用户名必须填写'],
        ['tel', 'require', '电话必须填写'],
        ['content', 'require', '报修内容必须填写'],

    ];
}