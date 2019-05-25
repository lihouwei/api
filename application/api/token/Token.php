<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/5/4
 * Time: 23:12
 */

namespace app\api\token;

use \Firebase\JWT\JWT;

class Token
{
    private static $instance;
    private $iss = 'api.test.com';  // 发布者
    private $aud = 'jiutian.com';   // 接收者
    private $uid;                   // 请求的用户id
    private $token;                 // JWT token
    // 私钥
    private $key = 'adaijidbasjbdkab';
    private $ip;                    // ip和token一起检验

    /**
     * 私有化构造函数
     * Token constructor.
     */
    private function __construct(){}

    /**
     * 私有化拷贝函数
     */
    private function __clone(){}

    /**
     * 获取token实例
     * @return mixed
     */
    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 先编码,然后再通过getToken方法获取token
     * @return $this
     */
    public function encode(){
        $time = time();
        $payload = [
            "iss" => $this->iss,
            "aud" => $this->aud,
            "iat" => $time,
            "nbf" => $time,
            "exp" => $time + 3600,
            "data" => [
                'uid' => $this->uid,
                'ip'  => $this->ip
            ]
        ];
        $this->token = JWT::encode($payload,$this->key);
        return $this;
    }

//    /**
//     *
//     * @return array
//     */
//    public function decode(){
//        $decoded = JWT::decode($this->token, $this->key, array('HS256'));
//        return (array)$decoded;
//    }

    /**
     * 设置token
     * @param $token
     * @return $this
     */
    public function setToken($token){
        $this->token = $token;
        return $this;
    }

    /**
     * 获取token
     * @return mixed
     */
    public function getToken(){
        if(isset($this->token)){
            return $this->token;
        }else{
            return null;
        }
    }

    /**
     * 设置uid
     * @param $uid
     * @return mixed
     */
    public function setUid($uid){
        $this->uid = $uid;
        return $this;
    }

    /**
     * 获取uid
     * @return mixed
     */
    public function getUid(){
        if(isset($this->uid)){
            return $this->uid;
        }else{
            return null;
        }
    }

    /**
     * 设置用户ip
     * @param $ip
     * @return $this
     */
    public function setIp($ip){
        $this->ip = $ip;
        return $this;
    }

    /**
     * 获取用户ip
     * @return null
     */
    public function getIp(){
        if(isset($this->ip)){
            return $this->ip;
        }else{
            return null;
        }
    }

    /**
     * 检验token，私钥是否正确
     * @return bool
     */
    public function check(){
        try{
            $decoded = JWT::decode($this->token, $this->key,array('HS256'));
            $this->uid = $decoded->data->uid;
            $this->ip  = $decoded->data->ip;
            return true;
        }catch(\Exception $exception){
            return false;
        }
    }

    /**
     * 检测ip
     * @param $ip
     * @return bool
     */
    public function verifyIp($ip){
        try{
            $decoded = JWT::decode($this->token, $this->key,array('HS256'));
            $this->ip  = $decoded->data->ip;
            return $this->ip == $ip;
        }catch(\Exception $exception){
            return false;
        }
    }
}