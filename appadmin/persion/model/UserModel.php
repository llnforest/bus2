<?php
namespace admin\persion\model;

class UserModel extends \think\Model
{
    // 设置完整的数据表（包含前缀）
    protected $name = 'tp_hr_user';
    protected $autoWriteTimestamp = 'datetime';
    //初始化属性
    protected function initialize()
    {
    }

}
?>