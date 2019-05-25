<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/4/30
 * Time: 19:58
 */

namespace app\admin\model;
use app\api\err\ApiErrCode;
use app\api\err\ApiException;
use app\api\jsonResponse\JsonResponse;
use think\Model;
use app\api\token\Token;

class User extends Model
{
   use JsonResponse;

    /**
     * 登陆
     * @param $name
     * @param $pwd
     * @return string
     * @throws ApiException
     */
    public function login($name, $pwd)
    {
        $user = $this->get(['uname' => $name]);
        if ($user == null) {
            throw new ApiException(ApiErrCode::USR_NOEXIST);
        }

        // 检验密码
        if ( !($user->pwd == $pwd) ) {
            throw new ApiException(ApiErrCode::ERR_PASSWORD);
        }
        // 检验是否被禁用
        if ($user->status == 1){
            throw new ApiException(ApiErrCode::USR_FORBID);
        }

        // 签发token
        $id    = $user->id;
        $ip    = request()->ip();
        $jwt   = Token::getInstance();
        $token = $jwt->setUid($id)->setIp($ip)->encode()->getToken();

        return $this->jsonSuccess(['token'=>$token]);
    }

    /**
     * 注册
     * @param $data
     * @return string
     * @throws ApiException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function sign($data)
    {
        $keys = ['uname', 'pwd', 'phone', 'email'];
        foreach ($keys as $val) {
            if ( !array_key_exists($val, $data) ) {
                throw new ApiException(ApiErrCode::ERR_BLANK);
            }
        }
        foreach ($data as $k => $v) {
            $data[$k] = trim($v);
        }

        if ( !( $data['uname'] && $data['pwd'] && $data['phone'] && $data['email']) ) {
            throw new ApiException(ApiErrCode::ERR_BLANK);
        }
        if (strlen($data['phone']) != 11) {
            throw new ApiException(ApiErrCode::ERR_PHONE);
        }

        // 判断用户名是否存在
        $res = $this->where('uname', $data['uname'])->find();
        if ($res != null) {
            throw new ApiException(ApiErrCode::USR_EXISTED);
        }

        // 插入创建时间
        $data['c_time'] = date('Y-m-d H:i:s', time());
        $this->allowField(true)->save($data);
        return $this->jsonSuccess();
    }
}