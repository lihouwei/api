<?php

// 改用tp5.1的中间件鉴权


///**
// * Created by PhpStorm.
// * User: lhw
// * Date: 2019/5/1
// * Time: 15:00
// */
//namespace app\admin\controller;
//use think\Controller;
//
//class Base extends Controller
//{
//    protected $uid;
//
//    public function _initialize()
//    {
//        header('Access-Control-Allow-Origin:*');
//        $module     = strtolower(request()->module());
//        $controller = strtolower(request()->controller());
//        $action     = strtolower(request()->action());
//        $url        = $module.'/'.$controller.'/'.$action;
//
//        // 检验token
//        $site  = \app\admin\model\Site::get(['name'=>'key']);
//        $key   = $site->value;
//        $token = request()->header('x-token');
//
//        if(!isset($token)){
//            die('请登录');
//        }
//
//        try{
//            $res  = \Firebase\JWT\JWT::decode($token, $key, array('HS256'));
//            $res  = (array)$res;
//            $data = $res['data'];
//            $this->uid  = $data->id;
//        } catch (\Exception $e) {
//            die('身份验证失败，请重新登陆');
//        }
//
//        // 不验证的规则
//        $expect = ['admin/index/index'];
//
//        if( !in_array($url, $expect) ){
//            if(isset($this->uid)){
//                $auth = new \think\auth\Auth();
//                if( !$auth->check($url,$this->uid) ){
//                    die('没有权限'.$url);
//                }
//            }
//        }
//    }
//}