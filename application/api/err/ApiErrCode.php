<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/5/8
 * Time: 16:19
 */

namespace app\api\err;


/**
 * 定义错误码
 */
class ApiErrCode
{
    const SUCCESS       =   [0, 'success'];
    const ERR_UNKNOWN   =   [1, '未知错误'];

    /**
     * 登陆异常
     */
    const ERR_SUBMIT    =   [1001, '提交异常'];
    const USR_NOEXIST   =   [1002, '用户名不存在'];
    const ERR_PASSWORD  =   [1003, '密码错误'];
    const ERR_BLANK     =   [1004, '有项目未填写'];
    const USR_FORBID    =   [1005, '用户被禁用'];

    /**
     * Token检验异常
     */
    const ERR_EXPIRED   =   [1010, '登陆过期'];
    const ERR_NOTOKEN   =   [1011, '请登录'];
    const CHECK_FAILED  =   [1012, '身份验证失败，请重新登陆'];
    const NO_AUTH       =   [1013, '没有权限访问'];


    /**
     * 注册异常
     */
    const USR_EXISTED   =   [1020, '用户名已存在'];
    const ERR_PHONE     =   [1021, '手机号格式不正确'];
}