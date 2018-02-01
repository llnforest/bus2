<?php
//订单控制器
namespace admin\reserve\controller;

use admin\bus\model\BusModel;
use admin\bus\model\BusOrderAddressModel;
use admin\bus\model\BusOrderFollowModel;
use admin\bus\model\BusRecordModel;
use admin\bus\model\CustomerModel;
use admin\bus\model\OrderModel;
use admin\bus\model\CorporationModel;
use admin\finance\model\CustomerFinanceModel;
use admin\persion\model\DepartmentModel;
use admin\persion\model\UserModel;
use admin\index\controller\BaseController;
use fanston\third\Makeid;
use think\Loader;
use think\Validate;


class Order extends BaseController{

    private $roleValidate = ['customer_id|客户名称' => 'require','xianshou|现收金额'=>'natural','duishou|队收金额'=>'natural','true_money|付款金额'=>'natural','return_money|返利金额'=>'natural','taxation|税款'=>'natural','start_date|开始日期' => 'require','end_date|结束日期' => 'require'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //订单列表页
    public function index(){
        $orderBy  = 'a.status asc,a.create_time desc';
        $where  = getWhereParam(['a.id','b.name','a.type','a.status','a.create_time'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name,b.type as customer_type,c.*,d.id as record_id';
        $data['list'] = OrderModel::alias('a')
            ->join('tp_bus_customer b','a.customer_id = b.id','left')
            ->join('tp_bus_order_address c','a.id = c.order_id','left')
            ->join('(select * from tp_bus_record where status != 3) d','a.id = d.order_id','left')
            ->field($fields)
            ->where($where)
            ->group('a.id')
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加订单
    public function orderAdd(){
        if($this->request->isPost()){
            if(in_array($this->param['order_type'],[2,3])){
                $this->param['num'] = 0;
                $this->param['total_money'] = 0;
            }else{
                $this->roleValidate['total_money|订单总额'] = 'require|digit';
                $this->roleValidate['num|乘车人数'] = 'require|digit';
            }
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            $this->param['id'] =Makeid::makeOrder();
            if(empty($this->param['is_air'])) $this->param['is_air'] = 0;
            if(empty($this->param['is_tv'])) $this->param['is_tv'] = 0;
            if($bus = OrderModel::create($this->param)){
                $this->saveOrderAddress($this->param,$bus['id']);
                return ['code' => 1,'msg' => '添加成功','url' => url('order/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('orderAdd');
    }

    //修改订单
    public function orderEdit(){
        $fields = 'a.*,b.name,b.type as customer_type,c.*';
        $data['info'] = OrderModel::alias('a')
            ->join('tp_bus_customer b','a.customer_id = b.id','left')
            ->join('tp_bus_order_address c','a.id = c.order_id','left')
            ->field($fields)
            ->where(['a.id'=>$this->id])
            ->find();

        if($this->request->isPost()){
            if($data['info']['status'] == 0){
                if(!in_array($this->param['order_type'],[2,3])){
                    $this->roleValidate['total_money|订单总额'] = 'require|digit';
                    $this->roleValidate['num|乘车人数'] = 'require|digit';
                }
                $validate = new Validate($this->roleValidate);
                if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
                if(empty($this->param['is_air'])) $this->param['is_air'] = 0;
                if(empty($this->param['is_tv'])) $this->param['is_tv'] = 0;
                $this->saveOrderAddress($this->param,$this->id);
            }

            if($data['info']['status'] == 2){
                $result['money'] = $data['info']['total_money'] - $this->param['xianshou']-$this->param['duishou'];
                if($result['money'] > 0){
                    $result['customer_id'] = $data['info']['customer_id'];
                    $result['order_id'] = $this->id;
                    $result['add_date'] = $data['info']['start_date'];
                    $result['system_id'] = $this->system_id;
                    CustomerFinanceModel::create($result);
                }
                $this->param['is_sure'] = 1;
            }
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('order/index')];
            }else{
                return ['code' => 1,'msg' => '修改成功','url' => url('order/index')];
            }
        }
        return view('orderEdit',$data);
    }

    //保存修改订单地址
    private function saveOrderAddress($address,$id = null){
        $data = [];
        //起始地址
        $prov = explode('_',$address['start_prov']);
        $data['start_prov'] = $prov[1];
        $data['start_provid'] = $prov[0];
        $city = explode('_',$address['start_city']);
        $data['start_city'] = $city[1];
        $data['start_cityid'] = $city[0];
        $area = explode('_',$address['start_area']);
        $data['start_area'] = $area[1];
        $data['start_areaid'] = $area[0];
        $data['start_address'] = $address['start_address'];

        //到达地址
        $prov = explode('_',$address['end_prov']);
        $data['end_prov'] = $prov[1];
        $data['end_provid'] = $prov[0];
        $city = explode('_',$address['end_city']);
        $data['end_city'] = $city[1];
        $data['end_cityid'] = $city[0];
        $area = explode('_',$address['end_area']);
        $data['end_area'] = $area[1];
        $data['end_areaid'] = $area[0];
        $data['end_address'] = $address['end_address'];

        $dbModel = BusOrderAddressModel::get(['order_id' => $id]);
        if(empty($dbModel)){
            $data['order_id'] = $id;
            BusOrderAddressModel::create($data);
        }else{
            $dbModel->save($data);
        }
    }

    //选择客户
    public function customerSelect(){
        $where = 'system_id = '.$this->system_id;
        if(!empty($this->param['text'])) $where .= ' and (name like "%'.$this->param['text'].'%" or user_name like "%'.$this->param['text'].'%" or phone = "'.$this->param['text'].'")';
        $data['customerList'] = CustomerModel::where(['status'=>1])->where($where)->order('create_time desc')->select();
        $data['id'] = explode(',',$this->id);
        return view('customerSelect',$data);
    }

    //	单次派车
    public function selectBus(){
        $data['order'] = OrderModel::get($this->id);
        if(empty($data['order']) || $data['order']['status'] != 0) $this->error('该订单不存在或已处理');
        if($this->request->isPost()){
            $result = ['order_id'=>$this->id,'bus_id'=>$this->param['bus_id'],'fir_user_id'=>$this->param['fir_user_id'],'sec_user_id'=>$this->param['sec_user_id']];
            if(BusRecordModel::create($result)){
                $data['order']->save(['status'=>1]);
                return ['code'=>1,'msg'=>'派单成功','url'=>url('order/index')];
            }
            return ['code'=>0,'msg'=>'派单失败'];
        }
        $where  = getWhereParam(['a.num'=>'like','a.type','a.color','a.corporation_id','a.department_id'],$this->param);
        $where['a.status'] = 1;
        if($data['order']['order_type'] == 1) $where['a.site_num'] = ['egt',$data['order']['num']];
        if($data['order']['is_tv'] == 1)  $where['a.is_tv'] = $data['order']['is_tv'];
        if($data['order']['is_microphone'] == 1)  $where['a.is_microphone'] = $data['order']['is_microphone'];
        if($data['order']['is_air'] == 1)  $where['a.is_air'] = $data['order']['is_air'];
        if($data['order']['is_bathroom'] == 1)  $where['a.is_bathroom'] = $data['order']['is_bathroom'];
        $orderBy  = 'a.type asc,g.total_money asc,g.num asc,a.site_num asc';

        $recordSql = BusRecordModel::alias('cc')
            ->field('cc.bus_id,count(1) as num,sum(cc.money) as total_money')
            ->group('cc.bus_id')
            ->buildSql();

        if($data['order']['order_type'] != 2)
            $time_where = " and ee.status not in (2,3) and ((ff.end_date > '{$data['order']['start_date']}' and ff.end_date < '{$data['order']['end_date']}') or (ff.start_date > '{$data['order']['start_date']}' and ff.start_date < '{$data['order']['end_date']}') or (ff.end_date > '{$data['order']['end_date']}' and ff.start_date < '{$data['order']['start_date']}') or (ff.end_date = '{$data['order']['end_date']}' and ff.start_date = '{$data['order']['start_date']}'))";
        else
            $time_where = '';
        $busy_bus = BusRecordModel::alias('ee')
            ->join('tp_bus_order ff','ee.order_id = ff.id','left')
            ->where("ee.system_id = {$this->system_id}".$time_where)
            ->group('ee.bus_id')
            ->column('ee.bus_id');
        if(!empty($busy_bus)) $where['a.id'] = ['not in',$busy_bus];
        $fields = 'a.*,b.name as fir_name,c.name as sec_name,d.name as corporation_name,e.name as department_name';
        $data['list'] = BusModel::alias('a')
            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->join('tp_bus_corporation d','a.corporation_id = d.id','left')
            ->join('tp_hr_department e','a.department_id = e.id','left')
            ->join([$recordSql=> 'g'],'a.id = g.bus_id','left')
            ->field($fields)
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['corporation'] = CorporationModel::where(['status'=>1,'system_id'=>$this->system_id])->order('sort')->select();
        $data['department'] = DepartmentModel::where(['system_id'=>$this->system_id])->order('sort')->select();
        return view('selectBus',$data);
    }

    //分批配载
    public function selectAnyBus(){
        $data['order'] = OrderModel::get($this->id);
        if(empty($data['order']) || $data['order']['status'] != 0) $this->error('该订单不存在或已处理');
        if($this->request->isPost()){
            $subList = json_decode($this->param['data'],true);
            foreach($subList as &$item){
                $item['order_id'] = $this->id;
                $item['create_time'] = date('Y-m-d H:i:s');
            }
            $busRecord = new BusRecordModel();
            if($busRecord->saveAll($subList)){
                $data['order']->save(['status'=>1]);
                return ['code'=>1,'msg'=>'派单成功','url'=>url('order/index')];
            }
            return ['code'=>0,'msg'=>'派单失败'];
        }
        $where  = getWhereParam(['a.num'=>'like','a.type','a.color','a.corporation_id','a.department_id','a.is_bathroom','a.is_tv','a.is_air','a.is_microphone'],$this->param);
        $where['a.status'] = 1;
        $orderBy  = 'a.type asc,g.total_money asc,g.num asc,a.site_num asc';

        $recordSql = BusRecordModel::alias('cc')
            ->field('cc.bus_id,count(1) as num,sum(cc.money) as total_money')
            ->group('cc.bus_id')
            ->buildSql();

        if($data['order']['order_type'] != 2)
            $time_where = " and ee.status not in (2,3) and ((ff.end_date > '{$data['order']['start_date']}' and ff.end_date < '{$data['order']['end_date']}') or (ff.start_date > '{$data['order']['start_date']}' and ff.start_date < '{$data['order']['end_date']}') or (ff.end_date > '{$data['order']['end_date']}' and ff.start_date < '{$data['order']['start_date']}') or (ff.end_date = '{$data['order']['end_date']}' and ff.start_date = '{$data['order']['start_date']}'))";
        else
            $time_where = '';

        $busy_bus = BusRecordModel::alias('ee')
            ->join('tp_bus_order ff','ee.order_id = ff.id','left')
            ->where("ee.system_id = {$this->system_id}".$time_where)
            ->group('ee.bus_id')
            ->column('ee.bus_id');
        if(!empty($busy_bus)) $where['a.id'] = ['not in',$busy_bus];
        $fields = 'a.*,b.name as fir_name,c.name as sec_name,d.name as corporation_name,e.name as department_name';
        $data['list'] = BusModel::alias('a')
            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->join('tp_bus_corporation d','a.corporation_id = d.id','left')
            ->join('tp_hr_department e','a.department_id = e.id','left')
            ->join([$recordSql=> 'g'],'a.id = g.bus_id','left')
            ->field($fields)
            ->where($where)
            ->order($orderBy)
            ->select();
        $data['corporation'] = CorporationModel::where(['status'=>1,'system_id'=>$this->system_id])->order('sort')->select();
        $data['department'] = DepartmentModel::where(['system_id'=>$this->system_id])->order('sort')->select();
        return view('selectAnyBus',$data);
    }

    //关闭订单
    public function editStatus(){
        if($this->request->isPost()){
            $data['info'] = orderModel::get($this->id);
            if(!$data['info'] || $data['info']['status'] != 0) return ['code' => 0,'msg' => '参数错误'];;
            if($data['info']->save(['status'=>3])){
                return ['code' => 1,'msg' => '订单已关闭','url' => url('order/index')];
            }else{
                return ['code' => 0,'msg' => '订单关闭失败'];
            }
        }
    }

    //确认派车
    public function orderSend(){
        if($this->request->isPost()){
            $data['info'] = orderModel::get($this->id);
            if(!$data['info'] || $data['info']['status'] != 0) return ['code' => 0,'msg' => '参数错误'];;
            if($data['info']->save(['status'=>1])){
                return ['code' => 1,'msg' => '确认派车成功','url' => url('order/index')];
            }else{
                return ['code' => 0,'msg' => '确认派车失败'];
            }
        }
    }

    //选择驾驶员
    public function userSelect(){
        $data['userList'] = UserModel::where(['is_driver' => 1,'status'=>1,'system_id'=>$this->system_id])->select();
        $data['fir'] = isset($this->param['fir'])?$this->param['fir']:'1';//1主驾驶 2为付驾驶
        $data['id'] = $this->id;
        return view('userSelect',$data);
    }

    //跟单备注
    function orderFollow(){
        if(empty($this->id)) $this->error('参数错误');
        $data['list'] = BusOrderFollowModel::alias('a')
            ->join('tp_admin b','a.admin_id = b.id','left')
            ->where(['a.order_id' => $this->id])
            ->field('a.id,a.order_id,a.remarks,a.create_time,b.nick_name')
            ->order('create_time desc')
            ->select();
        $data['info'] = OrderModel::get($this->id);
        return view('orderFollow',$data);
    }

    //添加备注
    function followAdd(){
        if($this->request->isPost()) {
            $remarks = isset($this->param['remarks']) ? $this->param['remarks'] : '';
            if (empty($remarks) || empty($this->id)) return ['code' => 0, 'msg' => '必须填写备注内容'];
            if (BusOrderFollowModel::create(['order_id' => $this->id, 'admin_id' => $this->uid, 'remarks' => $remarks])) {
                return ['code' => 1, 'msg' => '添加成功', 'url' => url('order/orderFollow',['id'=>$this->id])];
            } else {
                return ['code' => 0, 'msg' => '添加失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //删除备注
    function followDelete(){
        if($this->request->isPost()) {
            if (empty($this->id) || !isset($this->param['order_id'])) return ['code' => 0, 'msg' => '参数错误'];
            if (BusOrderFollowModel::destroy(['id' => $this->id])) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('order/orderFollow',['id'=>$this->param['order_id']])];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //订单信息
    public function orderInfo(){
        $data['info'] = OrderModel::alias('a')
            ->join('tp_bus_customer b','a.customer_id = b.id','left')
            ->join('tp_bus_order_address c','a.id = c.order_id','left')
            ->field('a.*,b.name,b.phone,c.*')
            ->where(['a.id' => $this->id])
            ->find();
        return view('orderInfo',$data);
    }

    //导出订单
    public function exportOut(){
        $orderBy  = 'a.status asc,a.create_time desc';
        $where  = getWhereParam(['b.name','a.type','a.status','a.create_time'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name,b.type as customer_type,c.*';
        $list = OrderModel::alias('a')
            ->join('tp_bus_customer b','a.customer_id = b.id','left')
            ->join('tp_bus_order_address c','a.id = c.order_id','left')
            ->field($fields)
            ->where($where)
            ->order($orderBy)
            ->select();
        Loader::import('PHPExcel.Classes.PHPExcel');
        Loader::import('PHPExcel.Classes.PHPExcel.IOFactory.PHPExcel_IOFactory');
        Loader::import('PHPExcel.Classes.PHPExcel.Reader.Excel2007');
        Loader::import('PHPExcel.Classes.PHPExcel.Writer.Excel2007');
        $objPHPExcel = new \PHPExcel();
        $name = '订单数据';
        $objPHPExcel->getProperties()->setCreator("汽车管理系统")
            ->setLastModifiedBy("汽车管理系统")
            ->setTitle($name."EXCEL导出")
            ->setSubject($name."EXCEL导出")
            ->setDescription("订单数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        $objPHPExcel->setActiveSheetIndex(0)
            //Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A1', '订单编号')
            ->setCellValue('B1', '客户名称')
            ->setCellValue('C1', '订单状态')
            ->setCellValue('D1', '订单类型')
            ->setCellValue('E1', '结账类型')
            ->setCellValue('F1', '乘用人数')
            ->setCellValue('G1', '设备要求')
            ->setCellValue('H1', '预付金额')
            ->setCellValue('I1', '订单总额')
            ->setCellValue('J1', '行车路线')
            ->setCellValue('K1', '行车时间');
        foreach ($list as $key => $v) {
            $type = $status = $order_type = $dev = '';
            if($v['status'] == 1) $status = '已派单';
            elseif($v['status'] == 2) $status = '交易成功';
            elseif($v['status'] == 3) $status = '交易取消';
            else $status = '待派单';

            if($v['order_type'] == 1) $order_type = '普通单次';
            elseif($v['order_type'] == 2) $order_type = '常规班次';

            if($v['type'] == 1) $type = '全包现收';
            elseif($v['type'] == 2) $type = '全包预收';
            elseif($v['type'] == 3) $type = '全包记账';
            elseif($v['type'] == 4) $type = '净价现收';
            elseif($v['type'] == 5) $type = '净价预收';
            elseif($v['type'] == 6) $type = '净价记账';

            if($v['is_air']) $dev .= '空凋,';
            if($v['is_tv']) $dev .= '电视,';
            if($v['is_microphone']) $dev .= '麦克风,';
            if($v['is_bathroom']) $dev .= '卫生间';
            $objPHPExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValueExplicit('A'.($key+2), $v['id'],\PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValue('B'.($key+2), $v['name'])
                ->setCellValue('C'.($key+2), $status)
                ->setCellValue('D'.($key+2), $order_type)
                ->setCellValue('E'.($key+2), $type)
                ->setCellValue('F'.($key+2), $v['num'])
                ->setCellValue('G'.($key+2), $dev)
                ->setCellValue('H'.($key+2), $v['true_money'])
                ->setCellValue('I'.($key+2), $v['total_money'])
                ->setCellValue('J'.($key+2), '起：'.$v['start_prov'].$v['start_city'].$v['start_area'].$v['start_address'].'。 终：'.$v['end_prov'].$v['end_city'].$v['end_area'].$v['end_address'])
                ->setCellValue('K'.($key+2), '出发:'.date_format(date_create($v['start_date']),'Y-m-d H:i').' 结束:'.date_format(date_create($v['end_date']),'Y-m-d H:i'))
            ;
        }
        $name = $name.time();

        $objPHPExcel->getActiveSheet()->setTitle('User');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}