<?php
/**
 * Created by PhpStorm.
 * User: 悦悦
 * Date: 2018/3/23 0023
 * Time: 15:18
 */

namespace app\home\controller;


use think\Db;

class Notice extends Home
{
    public function index(){

//        var_dump($count);exit;

        if (request()->isPost()){
            $page = request()->post('page');
            $len = 5;
            $offset = $page*$len;
            $count = Db::name('Notice')->count();
            $totalPage = ceil($count/$len);
            $add = Db::name('Notice')->where(['status'=>0])->limit($offset,$len)->select();
            $data = ['total'=>$totalPage,$add];
//            var_dump($data);exit;
            return $data;

        }

//        var_dump($totalPage);exit;
        $row = Db::name('Notice')->where(['status'=>0])->limit(0,5)->select();

//        $page = $row->render();
       $this->assign('row',$row);

//       $this->assign('page',$page);
//       var_dump($row);exit;
        return $this->fetch();
    }

    //活动详情页
    public function intro($id){
        $row = Db::name('Notice')->find($id);
//        var_dump($row);
        Db::name('Notice')->where(['id'=>$id])->setInc('read_view');

        $this->assign('row',$row);
        return $this->fetch();
    }
}