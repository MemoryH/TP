<?php
/**
 * Created by PhpStorm.
 * User: 悦悦
 * Date: 2018/3/22 0022
 * Time: 13:08
 */

namespace app\admin\model;


use think\Model;

class Property extends Model
{
    public function lists($status = 1, $order = 'uid DESC', $field = true){
        $map = array('status' => $status);
        return $this->field($field)->where($map)->order($order)->select();
    }

}