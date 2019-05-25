<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/5/6
 * Time: 16:21
 */

namespace app\http\middleware;


class Allow
{
    /**
     * 加上响应头，解决跨域问题
     * @param $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next){
        header('Access-Control-Allow-Origin:*');
        return $next($request);
    }
}