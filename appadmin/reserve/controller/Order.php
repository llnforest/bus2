<?php
//订单控制器
namespace admin\reserve\controller;

use admin\bus\model\BusModel;
use admin\bus\model\BusOrderFollowModel;
use admin\bus\model\BusRecordModel;
use admin\bus\model\CustomerModel;
use admin\bus\model\OrderModel;
use admin\bus\model\CorporationModel;
use admin\persion\model\DepartmentModel;
use admin\persion\model\UserModel;
use admin\index\controller\BaseController;
use fanston\third\Makeid;
use think\Validate;


class Order extends BaseController{

    private $roleValidate = ['customer_id|客户名称' => 'require','start_date|开始日期' => 'require','end_date|结束日期' => 'require','start_address|起始地点'=>'require','end_address|到达地点'=>'require','num|乘车人数' => 'require|digit','total_money|订单总额' => 'require'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //订单列表页
    public function index(){
        $orderBy  = 'create_time desc';
        $where  = getWhereParam(['b.name','a.type','a.status','a.reserve_date'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name,b.type as customer_type';
        $data['list'] = OrderModel::alias('a')
            ->join('tp_bus_customer b','a.customer_id = b.id','left')
            ->field($fields)
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加订单
    public function orderAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(in_array($this->param['type'],[1,4])){
                $this->param['true_money'] = $this->param['total_money'];
            }elseif(in_array($this->param['type'],[6,3])){
                $this->param['true_money'] = 0;
            }
            $this->param['id'] =Makeid::makeOrder();
            if(empty($this->param['is_air'])) $this->param['is_air'] = 0;
            if(empty($this->param['is_tv'])) $this->param['is_tv'] = 0;
            if($bus = OrderModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('order/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('orderAdd');
    }

    //选择客户
    public function customerSelect(){
        $where = 'system_id = '.$this->system_id;
        if(!empty($this->param['text'])) $where .= ' and (name like "%'.$this->param['text'].'%" or user_name like "%'.$this->param['text'].'%" or phone = "'.$this->param['text'].'")';
        $data['customerList'] = CustomerModel::where(['status'=>1])->where($where)->order('create_time desc')->select();
        $data['id'] = explode(',',$this->id);
        return view('customerSelect',$data);
    }

    //	需求单派
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
        $where  = getWhereParam(['a.num','a.type','a.color','a.corporation_id','a.department_id'],$this->param);
        $where['a.status'] = 1;
        $where['a.site_num'] = ['egt',$data['order']['num']];
        if($data['order']['is_tv'] == 1)  $where['a.is_tv'] = $data['order']['is_tv'];
        if($data['order']['is_microphone'] == 1)  $where['a.is_microphone'] = $data['order']['is_microphone'];
        if($data['order']['is_air'] == 1)  $where['a.is_air'] = $data['order']['is_air'];
        if($data['order']['is_bathroom'] == 1)  $where['a.is_bathroom'] = $data['order']['is_bathroom'];
        $orderBy  = 'a.site_num asc';
        $fields = 'a.*,b.name as fir_name,c.name as sec_name,d.name as corporation_name,e.name as department_name';
        $data['list'] = BusModel::alias('a')
            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->join('tp_bus_corporation d','a.corporation_id = d.id','left')
            ->join('tp_hr_department e','a.department_id = e.id','left')
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
        $where  = getWhereParam(['a.num','a.type','a.color','a.corporation_id','a.department_id','a.is_bathroom','a.is_tv','a.is_air','a.is_microphone'],$this->param);
        $where['a.status'] = 1;
        $orderBy  = 'a.site_num asc';
        $fields = 'a.*,b.name as fir_name,c.name as sec_name,d.name as corporation_name,e.name as department_name';
        $data['list'] = BusModel::alias('a')
            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->join('tp_bus_corporation d','a.corporation_id = d.id','left')
            ->join('tp_hr_department e','a.department_id = e.id','left')
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
}