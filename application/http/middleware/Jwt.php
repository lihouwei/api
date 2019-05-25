<?php

namespace app\http\middleware;
use app\api\token\Token;
use app\api\err\ApiErrCode;
use app\api\err\ApiException;

// 类名如果全部大写会报错，找不到类
class Jwt
{
    /**
     * 检验token，用户ip
     * @param $request
     * @param \Closure $next
     * @throws ApiException
     * @return mixed
     */
    public function handle($request, \Closure $next){

        $token = $request->header('x-token');
        $ip    = $request->ip();

        if(is_null($token)){
            throw new ApiException(ApiErrCode::ERR_NOTOKEN);
        }

        $jwt = Token::getInstance();
        $jwt->setToken($token)->setIp($ip);

        if( $jwt->check() && $jwt->verifyIp()){
            // 获取uid,为以后的方法服务
            // 可以通过request()->uid获取
            $request->uid = $jwt->getUid();
            return $next($request);
        }

        throw new ApiException(ApiErrCode::CHECK_FAILED);

    }
}