<?php
namespace  Admin\Model;

use Think\Model;

class CategoryModel extends Model
{
    protected $_validate = array(
        //默认情况使用正则
        array('category_name','require','分类名称必须,不能为空!')
    );
}