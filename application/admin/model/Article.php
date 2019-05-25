<?php
/**
 * Created by PhpStorm.
 * User: lhw
 * Date: 2019/5/3
 * Time: 21:23
 */

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;


class Article extends Model
{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';

    public function addArticle(){

    }

    public function delArticle(){

    }

    public function editArticle(){

    }



}