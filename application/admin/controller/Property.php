<?php
/**
 * Created by PhpStorm.
 * User: 悦悦
 * Date: 2018/3/22 0022
 * Time: 10:40
 */

namespace app\admin\controller;


use think\Db;

class Property extends Admin
{
    //物业管理首页
    public function index(){
        $nickname       =   input('nickname');
        $map['status']  =   array('egt',0);
        if(is_numeric($nickname)){
            $map['id|name']=   array('like','%'.$nickname.'%');
        }else{
            $map['name']    =   array('like', '%'.(string)$nickname.'%');
        }

        $list   = $this->lists('Property', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->assign('meta_title','用户信息');

        return $this->fetch();
    }

    //修改报修状态
    public function changeStatus($method=null){
        $data=input('id/a');
        $id = array_unique($data);


        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'forbiduser':
                $this->forbid('Property', $map );
                break;
            case 'resumeuser':
                $this->resume('Property', $map );
                break;
            case 'deleteuser':
                $this->delete('Property', $map );
                break;
            default:
                $this->error('参数非法');
        }
    }

    //添加报修
    public function add($name = '', $tel = '', $content = ''){
        if(request()->isPost()){
//            $num = rand(time());
//            var_dump($username);exit;
//            var_dump($_FILES);exit;
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

    //修改报修
    public function edit($id = 0 ){
        if(request()->isPost()){
            $Menu = model('Property');
            $property = Db::name('Property');
//            var_dump($Menu);exit;
            $post_data=$this->request->post();
//            var_dump($post_data);exit;
            $validate = validate('Property');
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
            $data = $property->update($post_data);
//            var_dump($data);exit;
            if($data){
                session('admin_Property_list',null);
                //记录行为
                action_log('update_Property', 'Property', $data->id, UID);
                $this->success('更新成功',url('index'));
            } else {
                $this->error($property->getError());
            }


        } else {
            $info = array();
            /* 获取数据 */
            $data = \think\Db::name('Property')->field(true)->find($id);

            $this->assign('data',$data);
//            $this->assign('meta_title', '编辑行为');
            $this->assign('meta_title','修改报修') ;
            return $this->fetch('add');
        }
    }
}