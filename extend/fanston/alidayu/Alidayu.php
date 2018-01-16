<?php
namespace fanston\alidayu;
include "TopSdk.php";
use think\Config;
use TopClient;
use AlibabaAliqinFcSmsNumSendRequest;

class Alidayu{
	public static $appkey;
	public static $secretKey;
	public static $expresstel;
	public static $service;
	public static $blacklist;
	public $c;
	public $req;

	public function __construct(){
	    self::$appkey = Config::get('sms.appkey');
	    self::$secretKey = Config::get('sms.secretKey');
        self::$expresstel = '0551-66104389';
        self::$service = Config::get('service');
        self::$blacklist = ['15212998586', '13705680023', '18298116281', '15155466688', '18019966168', '13681773807'];

        $this->c = new TopClient;
        $this->c->appkey = self::$appkey;
        $this->c->secretKey = self::$secretKey;
        $this->req = new AlibabaAliqinFcSmsNumSendRequest;
        $this->req ->setSmsType("normal");
        $this->req ->setSmsFreeSignName("实价收合作商平台");
    }

    //发送验证码
	public function sendSms($phone,$val){
	    if(in_array($phone,self::$blacklist)) return false;
		$this->req->setSmsParam("{\"number\":\"".$val."\"}");
		$this->req->setRecNum($phone);
		$this->req->setSmsTemplateCode("SMS_71360978");
		$resp = $this->c->execute($this->req);
		return $resp;
	}

	//下单短信
	public function createOrder($phone = '',$orderid = '',$templete = ''){
        if (empty($phone) || empty($orderid) || empty($templete)) return false;
        if(in_array($phone,self::$blacklist)) return false;
		$data = array(
			'orderid' => $orderid,
			'expresstel'=>self::$expresstel,
			'service'   =>self::$service
			);
		$this->req->setSmsParam(json_encode($data));
		$this->req->setRecNum($phone);
		$this->req->setSmsTemplateCode($templete);
		$resp = $this->c->execute($this->req);
		return $resp;
	}

	//后台到货短信
	public function arriveOrder($phone,$orderid){
        if(in_array($phone,self::$blacklist)) return false;
		$data = array(
			'orderid' => $orderid,
			'service'   =>self::$service
			);
		$this->req->setSmsParam(json_encode($data));
		$this->req->setRecNum($phone);
		$this->req->setSmsTemplateCode("SMS_71265795");
		$resp = $this->c->execute($this->req);
		return $resp;
	}

    //退货短信
    public function backOrder($order){
        if(in_array($order['phone'],self::$blacklist)) return false;
        $data = array(
            'orderid' => (string)$order['id'],
            'express' => $order['express'].':'.$order['back_express'],
            'service' =>self::$service
        );
        $this->req->setSmsParam(json_encode($data));
        $this->req->setRecNum($order['phone']);
        $this->req->setSmsTemplateCode("SMS_90965014");
        $resp = $this->c->execute($this->req);
        return $resp;
    }

	//质检完成、部分完成
	public function checkOrder($phone,$orderid,$over = 1){
        if(in_array($phone,self::$blacklist)) return false;
		$data = array(
			'orderid' => $orderid,
			'service'   =>self::$service
			);
		$this->req->setSmsParam(json_encode($data));
		$this->req->setRecNum($phone);
		if($over)
			$this->req->setSmsTemplateCode("SMS_71310849");
		else
			$this->req->setSmsTemplateCode("SMS_71155999");
		$resp = $this->c->execute($this->req);
		return $resp;
	}

	//新注册短信
	public function storeReg($phone){
        if(in_array($phone,self::$blacklist)) return false;
		$data = array(
			'service'   =>self::$service
			);
		$this->req->setSmsParam(json_encode($data));
		$this->req->setRecNum($phone);
		// 不需要审核
		$this->req->setSmsTemplateCode("SMS_80100074");
		$resp = $this->c->execute($this->req);
		return $resp;
	}

	//审核不通过
	public function storeExamine($phone){
        if(in_array($phone,self::$blacklist)) return false;
		$data = array(
			'service'   =>self::$service
			);
		$this->req->setSmsParam(json_encode($data));
		$this->req->setRecNum($phone);
		$this->req->setSmsTemplateCode("SMS_71335971");
		$resp = $this->c->execute($this->req);
		return $resp;
	}

	//注册审核通过
	public function storeAun($phone){
        if(in_array($phone,self::$blacklist)) return false;
		$data = array(
			'service'   =>self::$service
			);
		$this->req->setSmsParam(json_encode($data));
		$this->req->setRecNum($phone);
		$this->req->setSmsTemplateCode("SMS_71265791");
		$resp = $this->c->execute($this->req);
		return $resp;
	}

	//提现完成
	public function takeDone($take){
		if(empty($take['phone'])) return false;
        if(in_array($take['phone'],self::$blacklist)) return false;
		$phone = $take['phone'];
		$data = array(
			'service'   =>self::$service,
			'take'   =>$take['money'].'',
			'serial' =>$take['serial_number'].'',
			);
		$this->req->setSmsParam(json_encode($data));
		$this->req->setRecNum($phone);
		$this->req->setSmsTemplateCode("SMS_71345932");
		$resp = $this->c->execute($this->req);
		return $resp;
	}

	//内部流转提示团新
	public function taskDone($phone,$info){
		if(empty($phone)) return false;
        if(in_array($phone,self::$blacklist)) return false;
		$data = array(
			'task'   =>$info
			);
		$this->req->setSmsParam(json_encode($data));
		$this->req->setRecNum($phone);
		$this->req->setSmsTemplateCode("SMS_71340960");
		$resp = $this->c->execute($this->req);
		return $resp;
	}
}
// $httpdns = new HttpdnsGetRequest;
// $this->client = new ClusterTopClient("4272","0ebbcccfee18d7ad1aebc5b135ffa906");
// $this->client->gatewayUrl = "http://api.daily.taobao.net/router/rest";
// var_dump($this->client->execute($httpdns,"6100e23657fb0b2d0c78568e55a3031134be9a3a5d4b3a365753805"));

?>