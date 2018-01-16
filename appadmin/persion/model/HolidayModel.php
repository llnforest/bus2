<?php
namespace admin\persion\model;

class HolidayModel extends \think\Model
{
    // 设置完整的数据表（包含前缀）
    protected $name = 'tp_hr_holiday';
    protected $autoWriteTimestamp = 'datetime';
    //初始化属性
    protected function initialize()
    {
    }

}
?>