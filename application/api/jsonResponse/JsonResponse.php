<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/5/4
 * Time: 13:17
 */

namespace app\api\jsonResponse;

trait JsonResponse
{
    /**
     * 成功时返回的json
     * @param array $data
     * @return string
     */
    public function jsonSuccess($data=[]){
        return $this->jsonData(0,'success',$data);
    }

    /**
     * 出错时的返回，使用错误码常量
     * @param $ERR
     * @return string
     */
    public function jsonError(array $ERR){
        return $this->jsonData($ERR[0], $ERR[1]);
    }

    /**
     * 封装json返回
     * @param $code
     * @param $message
     * @param $data
     * @return string
     */
    public function jsonData($code, $message='', $data=[]){
        $content = [
            'code'  =>  $code,
            'msg'   =>  $message,
            'data'  =>  $data
        ];
        return json($content);
    }
}