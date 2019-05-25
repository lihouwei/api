<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/5/3
 * Time: 12:26
 */

namespace app\admin\controller;

use app\admin\model\Node;
use think\Controller;

class Admin extends Controller
{
    public function add(){
        echo "add-admin";
    }

    public function edit(){

    }

    public function del(){

    }

    public function listAdmin(){

    }

    public function getAuthList(){
        $user = new Node();
        return json ($user->getMenu(1));
    }
}