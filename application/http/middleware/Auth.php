<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/5/4
 * Time: 18:25
 */
namespace app\http\middleware;

use app\api\err\ApiErrCode;
use app\api\err\ApiException;

class Auth
{
    /**
     * 检验用户权限，在token检验之后
     * @param $request
     * @param \Closure $next
     * @throws ApiException
     * @return mixed|\think\response\Json
     */
    public function handle($request, \Closure $next){

        $module     = strtolower(request()->module());
        $controller = strtolower(request()->controller());
        $action     = strtolower(request()->action());
        $url        = $module.'/'.$controller.'/'.$action;
        $request->url = $url;

        // 不验证的规则
        $expect = ['admin/index/index'];

        if( !in_array($url, $expect) ){
            if(isset($request->uid)){
                $auth = new \think\auth\Auth();
                if( !$auth->check($url,$request->uid) ){
                    //return json(['code'=>1009,'msg'=>'没有权限']);
                    throw new ApiException(ApiErrCode::NO_AUTH);
                }
            }
        }

        return $next($request);
    }
}