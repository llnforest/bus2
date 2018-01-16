<?php
namespace admin\finance\model;

class OilModel extends \think\Model
{
    // 设置完整的数据表（包含前缀）
    protected $name = 'tp_fi_oil';
    protected $autoWriteTimestamp = 'datetime';

    //初始化属性
    protected function initialize()
    {
    }

}
?>