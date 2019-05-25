<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/5/3
 * Time: 18:38
 */

namespace app\admin\model;

use think\auth\Auth;

class Node extends Auth
{

    /**
     * 根据节点数据获取对应的菜单
     */
    public function getMenu($uid)
    {
        // 先获取用户组id
        $groups = $this->getGroups($uid);
        $rules = [];
        // 再通过用户组id获取权限id
        foreach ($groups as $k => $v){
            $rule = explode(',', $v['rules']);
            $rules = array_merge($rules, $rule);
        }
        // 去重
        $rules = array_unique($rules);
        $nodeStr = implode(',',$rules);

        //判断是否为超级管理员
        $where = $uid==1?'status = 1':'status = 1 and id in('.$nodeStr.')';
        $result = \think\Db::name('auth_rule')->where($where)->order('sort')->select();
        $menu = $this->prepareMenu($result);

        return $menu;
    }


    /**
     * 整理菜单树方法
     * @param $param
     * @return array
     */
    function prepareMenu($param)
    {
        $parent = []; //父类
        $child = [];  //子类

        foreach($param as $key=>$vo){

            if($vo['pid'] == 0){
                $vo['href'] = '#';
                $parent[] = $vo;
            }else{
                // $vo['href'] = $vo['name'].'.html'; //跳转地址

                $href = explode('/',$vo['name']);
                $vo['href'] = $href[1].'-'.$href[2].'.html';

                $child[] = $vo;
            }
        }

        foreach($parent as $key=>$vo){
            foreach($child as $k=>$v){

                if($v['pid'] == $vo['id']){
                    $parent[$key]['child'][] = $v;
                }
            }
        }
        unset($child);
        return $parent;
    }

    /**
     * 子孙树 用于菜单整理
     * @param $param
     * @param int $pid
     * @return array
     */
    function subTree($param, $pid = 0)
    {
        static $res = [];
        foreach($param as $key=>$vo){

            if( $pid == $vo['pid'] ){
                $res[] = $vo;
                $this->subTree($param, $vo['id']);
            }
        }
        return $res;
    }
}