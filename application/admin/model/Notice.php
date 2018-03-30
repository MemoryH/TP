<?php
/**
 * Created by PhpStorm.
 * User: 悦悦
 * Date: 2018/3/22 0022
 * Time: 13:08
 */

namespace app\admin\model;


use think\Model;

class Notice extends Model
{
    public function lists(){
        $map = array('status' => 1);
        return $this->field(true)->where($map)->select();
    }

}