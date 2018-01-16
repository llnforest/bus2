<?php
namespace admin\index\controller;


use admin\index\model\AdminModel;
use admin\order\model\ExpressModel;
use admin\order\model\MemberOrderModel;
use fanston\third\WeixinMember;

use think\Controller;
use think\Request;

use fanston\alidayu\AlidayuMember;


class SendMessage extends Controller
{
    //微信配置
    public static $AlidayuMember;
    public static $WeixinMember;

    public function __construct()
    {
        $this->request      = Request::instance();
        $this->param        = $this->request->param();
        $this->post     = $this->request->post();
        $this->id       = isset($this->param['id'])?intval($this->param['id']):'';
        self::$AlidayuMember = new AlidayuMember();
        self::$WeixinMember = new WeixinMember();
        parent::__construct();
    }

    //下单
    public static function sendCreateOrder($orderid = ''){
        if (empty($orderid)) return false;
        $order = self::getOrderData($orderid);
        if (empty($order)) return false;
        // 发送用户短信短信
        if(!empty($order['phone'])){
            if($order['recovery_type'] == 1) $tempid = 'SMS_85675016';
            elseif($order['express_type'] == 1) $tempid = 'SMS_71260805';
            else $tempid = 'SMS_71240951';
            self::$AlidayuMember->createOrder($order['phone'],$orderid,$tempid);
        }
        //发送管理员短信
        $phone = [];
        $adminList = AdminModel::all(['id' => ['in','1,28,29,48,57']]);
        foreach($adminList as $item){
            if($item['phone']) $phone[] = $item['phone'];
        }
        self::$AlidayuMember->taskDone(implode(',',$phone),'C端订单');
        //发送微信
        if(!empty($order['openid'])){
            $result = self::$WeixinMember->createOrder($order);
        }
        return true;
    }

    //C端派单短信
    public static function createSendOrder($user){
        $result = self::$AlidayuMember->createSendOrder($user);
        if(!empty($user['bopenid'])) $result = self::$WeixinMember->sendTemplateToB($user);//派单给B
        if(!empty($user['copenid'])) $result = self::$WeixinMember->sendTemplateToC($user);//派单给C
        return $result;
    }

    //提现成功短信
    public static function takeDone($take){
        $result = self::$AlidayuMember->takeDone($take);
        $result = self::$WeixinMember->takeDone($take);
        return $result;
    }

    //发送质检短信(管理员)
    public static function sendCheckSms($orderid,$status = 1){
        $phone = [];
        $adminList = AdminModel::all(['id' => ['in','1,29,42,48,57,52']]);
        foreach($adminList as $item){
            if($item['phone']) $phone[] = $item['phone'];
        }
        if($status == 1) $msg = '订单:'.$orderid.'已质检定价完成';
        else $msg = '订单:'.$orderid.'已部分质检定价完成';
        $result = self::$AlidayuMember->taskDone(implode(',',$phone),$msg);
        return $result;
    }

    //质检完成、部分完成
    public static function checkOrder($orderid,$status){
        $order = self::getOrderData($orderid);
        if(empty($order)) return false;
        if(!empty($order['phone'])) $result = self::$AlidayuMember->checkOrder($order['phone'],$orderid,$status);
        //发送微信
        if(!empty($order['openid'])) $result = self::$WeixinMember->checkOrder($order,$status);
        return $result;
    }

    //订单状态改变
    public static function changeOrder($orderid){
        if (empty($orderid)) return false;
        $order = self::getOrderData($orderid);
        if (empty($order)) return false;
        //到货短信
        if(!empty($order['phone']) && $order['status'] == 2) self::$AlidayuMember->arriveOrder($order['phone'],$orderid);
        //状态2,3,4,5发送模板消息
        if(!empty($order['openid'])){
            $result = self::$WeixinMember->changeOrder($order);
        }
        return true;
    }

    //退货短信
    public static function backOrder($orderid){
        $order = self::getOrderData($orderid);
        if(empty($order) || empty($order['back_express_id'])) return false;
        $express = ExpressModel::get(['id' => $order['back_express_id']]);
        $order['express'] = $express['express'];
        if(!empty($order['phone'])) $result = self::$AlidayuMember->backOrder($order);
        if(!empty($order['openid'])) $result = self::$WeixinMember->changeBackOrder($order);
        return true;
    }

    //获取订单和人员信息
    public static function getOrderData($orderid){
        if (empty($orderid)) return false;
        $order = MemberOrderModel::alias('a')
                            ->join('tp_member b','a.member_id = b.id ','left')
                            ->where(['a.id'=>$orderid])
                            ->field('a.id,b.phone,b.openid,a.status,a.express_type,a.recovery_type,a.back_express,a.back_express_id')
                            ->find();
        return $order;
    }

}