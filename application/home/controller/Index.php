<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace app\home\controller;
use app\home\model\Document;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class Index extends Home{

	//系统首页
    public function index(){
//         return str_replace('[path]', $path, $html);
        $category = model('Category')->getTree();
        $document = new Document();
        $lists    = $document->lists(null);
        $this->assign('category',$category);//栏目
        $this->assign('lists',$lists);//列表
        $this->assign('page',model('Document')->page);//分页


        return $this->fetch();
    }
    public function property($name = '',$tel='',$content=''){
        if(request()->isPost()){
//            $num = rand(time());
//            var_dump($username);exit;
            $property = array('name' => $name, 'tel' => $tel, 'content' => $content,'status'=>0,'time'=>time(),'num'=>time());
            if(!db('Property',[],false)->insert($property)){
                $this->error('报修添加失败！');
            } else {
                $this->success('报修添加成功！',url('index'));
            }

        } else {
            $this->assign('meta_title','新增报修') ;
            return $this->fetch();
        }

    }

}
