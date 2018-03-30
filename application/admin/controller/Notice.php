<?php
/**
 * Created by PhpStorm.
 * User: 悦悦
 * Date: 2018/3/23 0023
 * Time: 15:25
 */

namespace app\admin\controller;


use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use think\Db;

class Notice extends Admin
{
    public function index(){

        $map['status']  =   array('egt',0);


        $list   = $this->lists('Notice', $map);
//        var_dump($list);exit;
        int_to_string($list);
        
        $this->assign('_list', $list);


        return $this->fetch();
    }

    public function add($name = '', $title = '', $content = '',$img=''){

        if(request()->isPost()){
//            $num = rand(time());
//            var_dump($username);exit;
//            var_dump($_FILES);exit;
            $property = array('name' => $name, 'title' => $title, 'content' => $content,'status'=>0,'create_time'=>time(),'img'=>$img);
            if(!db('notice',[],false)->insert($property)){
                $this->error('活动添加失败！');
            } else {
                $this->success('活动添加成功！',url('index'));
            }

        } else {

            return $this->fetch();
        }


    }

    //删除
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
                $this->forbid('Notice', $map );
                break;
            case 'resumeuser':
                $this->resume('Notice', $map );
                break;
            case 'deleteuser':
                $this->delete('Notice', $map );
                break;
            default:
                $this->error('参数非法');
        }
    }
//修改活动
    public function edit($id = 0 ){
        if(request()->isPost()){
            $Menu = model('Notice');
            $property = Db::name('Notice');
//            var_dump($Menu);exit;
            $post_data=$this->request->post();
//            var_dump($post_data);exit;
            $data = $property->update($post_data);
//            var_dump($data);exit;
            if($data){
                session('admin_Property_list',null);
                //记录行为
                action_log('update_Property', 'Notice', $data->id, UID);
                $this->success('更新成功',url('index'));
            } else {
                $this->error($property->getError());
            }


        } else {
            $info = array();
            /* 获取数据 */
            $data = \think\Db::name('Notice')->field(true)->find($id);

            $this->assign('data',$data);
            return $this->fetch('add');
        }
    }
//处理上传文件
    public function logo(){
        //实例化上传文件类
        $info = request()->file('file');

        $file = ROOT_PATH.'public/static/upload/';
//        var_dump($file);exit;

        $result = $info->move($file);
//        var_dump($result->getSaveName());exit;
//        var_dump($result);exit;
//        $result = $uploadFile->saveAs(\Yii::getAlias('@webroot') .'/'. $file, 0);
//        var_dump($result->getFilename());exit;

        if ($result){
            //文件保存成功 返回文件路径
            $accessKey ="TxMyeDQ095vC5DtBNrUmE_PqD-Ds6I1mz3i__KJk";
            $secretKey = "M69Cr5LgZCbmJrdmxqRfDl2qvdPYiZB8nZ6P9F7g";
            $bucket = "property";
            // 构建鉴权对象
            $auth = new Auth($accessKey, $secretKey);
            // 生成上传 Token
            $token = $auth->uploadToken($bucket);
            // 要上传文件的本地路径
            $filePath = $file.$result->getSaveName();
            // 上传到七牛后保存的文件名
            $key = '/'.$result->getFilename();
            // 初始化 UploadManager 对象并进行文件的上传。
            $uploadMgr = new UploadManager();
            // 调用 UploadManager 的 putFile 方法进行文件的上传。
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
//        echo "\n====> putFile result: \n";
            if ($err == null) {
                return json_encode([
                    'url'=>"http://p61el74ia.bkt.clouddn.com/{$key}"
                ]);
            } else {
                var_dump($err);
            }
//            return json_encode([
//                'url'=>$file
//            ]);
        }


    }
}