<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/5/3
 * Time: 20:19
 */

namespace app\admin\controller;
use app\admin\model\Node;

class Index extends Base
{
    // 返回权限菜单
    public function index(){
        $node = new Node();
        $menu = $node->getMenu($this->uid);
        $this->assign('menu', $menu);
        return json(['code'=>0, 'data'=>$menu]);
    }
}