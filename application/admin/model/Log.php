<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/5/3
 * Time: 21:05
 */

namespace app\admin\model;


use think\Model;

class Log extends Model
{
    public function writeLog($uid, $username, $description){
        $data['admin_id'] = $uid;
        $data['admin_name'] = $username;
        $data['desc'] = $description;
        $data['ip'] = request()->ip();
        $data['add_time'] = time();
        $this->save($data);
    }
}