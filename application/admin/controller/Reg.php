<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/4/30
 * Time: 19:58
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
use \Firebase\JWT\JWT;

class Reg extends Controller
{

    /**
     * @return string|\think\response\Json
     * @throws \app\api\err\ApiException
     */
    public function login(){
        $usr = trim(input('post.uname'));
        $pwd = trim(input('post.pwd'));

        $user = new User();
        $res  = $user->login($usr, $pwd);
        return $res;
    }

    /**
     * @return string
     * @throws \app\api\err\ApiException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function sign(){
        $data = input('post.');
        $user = new User();
        return $user->sign($data);
    }

    // test
    public function testEncodeDecode()
    {
        $key = "adaijidbasjbdkab";
//        $now = time();
//
//        $token = array(
//            "iss" => "http://example.org",
//            "aud" => "http://example.com",
//            "sub" => "subject",
//            "iat" => $now,
//            "nbf" => $now,
//            "exp" => "-1",
//            "data" => [
//                'id' => 123
//            ]
//        );
//
//        $jwt = JWT::encode($token, $key);
//        echo 'jwt是<br>'.$jwt.'<br>';
//
        $jwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhcGkudGVzdC5jb20iLCJhdWQiOiJqaXV0aWFuLmNvbSIsImlhdCI6MTU1Njk4NTMwOCwibmJmIjoxNTU2OTg1MzA4LCJleHAiOjE1NTY5ODg5MDgsImRhdGEiOnsidWlkIjoxfX0.IoyWYVHbVk3_ZjqxFfzRMcTt24CBPjOz7yA4Xws10xE";

        try{
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            $uid = $decoded->data->uid;
            echo $uid;
//            $decoded_array = (array) $decoded;
//            print_r($decoded_array);
//            print_r((array)$decoded_array['data']);
        }catch (\Firebase\JWT\ExpiredException $e){
            echo "登陆信息过期";
        }catch (\Firebase\JWT\SignatureInvalidException $e){
            echo "身份验证失败";
        }catch (\Firebase\JWT\BeforeValidException $e){
            echo "请稍后再试";
        }


//        $decoded_array = (array) $decoded;
//        print_r($decoded_array);
//        echo "<br>";
//        print_r((array)$decoded_array['data']);

        /*
         NOTE: This will now be an object instead of an associative array. To get
         an associative array, you will need to cast it as such:
        */

//        $decoded_array = (array) $decoded;
//
//        /**
//         * You can add a leeway to account for when there is a clock skew times between
//         * the signing and verifying servers. It is recommended that this leeway should
//         * not be bigger than a few minutes.
//         *
//         * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
//         */
//        JWT::$leeway = 60; // $leeway in seconds
//        $decoded = JWT::decode($jwt, $key, array('HS256'));
    }
}