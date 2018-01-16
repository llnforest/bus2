<?php
namespace admin\bus\model;

class IllegalModel extends \think\Model
{
    // 设置完整的数据表（包含前缀）
    protected $name = 'tp_bus_illegal';
    protected $autoWriteTimestamp = 'datetime';
    //初始化属性
    protected function initialize()
    {
    }

}
?>