<?php
namespace app\index\controller;

use app\api\err\ApiErrCode;
use app\api\err\ApiException;
use app\api\jsonResponse\JsonResponse;
use app\api\token\Token;

class Index
{
    use JsonResponse;

    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    public function hello($name = 'ThinkPHP5')
    {
        // 获取从中间件传递的参数
        echo request()->msg.'<br>';
        echo request()->url.'<br>';
        return 'hello,' . $name;
    }


    public function hello2($name = 'ThinkPHP5')
    {
        // 获取从中间件传递的参数
        echo request()->msg.'<br>';
        return 'hello,' . $name;
    }

    /**
     * 测试自定义Api异常
     * @throws ApiException
     */
    public function expDemo(){
        throw new ApiException(ApiErrCode::ERR_BLANK);
    }

    /**
     * 签发tokenDemo
     * @return string
     */
    public function encodeDemo(){
        $jwt    =  Token::getInstance();
        $ip     =  request()->ip();
        $token  =  $jwt->setUid(1)->setIp($ip)->encode()->getToken();
        //$uid  = $jwt->getUid();

        return $this->jsonSuccess([
            'token' => $token
        ]);
    }

    /**
     * 校验tokenDemo, 获取uid
     */
    public function decodeDemo(){
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhcGkudGVzdC5jb20iLCJhdWQiOiJqaXV0aWFuLmNvbSIsImlhdCI6MTU1Njk4NTMwOCwibmJmIjoxNTU2OTg1MzA4LCJleHAiOjE1NTY5ODg5MDgsImRhdGEiOnsidWlkIjoxfX0.IoyWYVHbVk3_ZjqxFfzRMcTt24CBPjOz7yA4Xws10xE';
        $jwt   = Token::getInstance();
        $res   = $jwt->setToken($token)->check();
        $uid   = $jwt->getUid();
        if($res){
            echo 'ok----'.$uid;
        }else{
            echo 'no';
        }
    }
}
