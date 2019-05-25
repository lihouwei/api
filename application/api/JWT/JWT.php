<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/5/4
 * Time: 13:39
 */

namespace app\api\JWT;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;


/**
 * 对JWT进行封装
 * 单例模式 一次请求中出现jwt的地方都是一个用户
 *
 * Class JWT
 * @package app\api\controller
 */
class JWT
{
    /**
     * 单例模式 JWT句柄
     * @var
     */
    private static $instance;

    /**
     * 获取 JWT句柄
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 私有化构造函数
     * JWT constructor.
     */
    private function __construct(){}

    /**
     * 私有化拷贝函数
     */
    private function __clone(){}


    private $iss = 'api.test.com';  // 发布者
    private $aud = 'jiutian.com';   // 接收者
    private $uid;                   // 请求的用户id
    private $token;                 // JWT token
    // 私钥
    private $key = 'adaijidbasjbdkab';
    private $decodeToken;

    /**
     * 获取token
     * @return string
     */
    public function getToken(){
        return (string)$this->token;
    }

    /**
     * 设置token
     * @param $token
     * @return mixed
     */
    public function setToken($token){
        return $this->token = $token;
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
     * 编码JWT token
     * @return $this
     */
    public function encode(){
        $time = time();
        $this->token = (new Builder())->setHeader('alg', 'HS256')
            ->setIssuer($this->iss)
            ->setAudience($this->aud)
            ->setIssuedAt($time)
            ->setExpiration($time + 3600)
            ->set('uid', $this->uid)
            ->sign(new Sha256(), $this->key)
            ->getToken();

        return $this;
    }

    /**
     * 解析token
     * @return \Lcobucci\JWT\Token
     */
    public function decode(){
        if( !isset($this->decodeToken) ){
            $this->decodeToken = (new Parser())->parse((string)$this->token);
            $this->uid = $this->decodeToken->getClaim('uid');
        }
        return $this->decodeToken;
    }

    /**
     * 获取uid
     * @return null
     */
    public function getUid(){
        if(isset($this->uid)){
            return $this->uid;
        }else{
            return null;
        }
    }

    /**
     * 验证私钥
     * @return bool
     */
    public function verify(){
        $result = $this->decode()->verify(new Sha256(), $this->key);
        return $result;
    }

    /**
     * 校验token的iss和aud
     * @return bool
     */
    public function validate(){
        $data = new ValidationData();
        $data->setIssuer($this->iss);
        $data->setAudience($this->aud);
        return $this->decode()->validate($data);
    }

}