<?php
namespace app\home\controller;

class Wechat extends Home{

    public function oauth2(){

        $appid ="wxafc99f9fa69e174d";
        $redirect_uri = url('wechat/redi','',true,true);
        var_dump($redirect_uri);exit;
        $scope="snsapi_userinfo";

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state=STATE#wechat_redirect";

        $this->redirect($url);
    }

    public function redi(){

    }
}