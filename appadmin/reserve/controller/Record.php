<?php
//调度控制器
namespace admin\reserve\controller;

use admin\bus\model\BusModel;
use admin\bus\model\BusRecordFollowModel;
use admin\bus\model\BusRecordModel;
use admin\bus\model\OrderModel;
use admin\finance\model\CustomerFinanceModel;
use admin\index\controller\BaseController;
use think\Request;


class Record extends BaseController{

    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //调度列表
    public function index(){
        $orderBy  = 'a.update_time desc';
        $where  = getWhereParam(['a.order_id','d.num','a.status','a.create_time'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name as fir_name,c.name as sec_name,d.num';
        $data['list'] = BusRecordModel::alias('a')
            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->join('tp_bus d','a.bus_id = d.id','left')
            ->field($fields)
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $this->param['style'] = isset($this->param['style'])?$this->param['style']:0;
        return view('index',$data);
    }

    //接单出发
    public function editReceive(){
        if($this->request->isPost()){
            $data['info'] = BusRecordModel::get($this->id);
            if(!$data['info']) return ['code' => 0,'msg' => '参数错误'];;
            if($data['info']->save(['status'=>1,'start_date'=>date('Y-m-d',time())])){
                return ['code' => 1,'msg' => '车辆已接单出发','url' => url('record/index',$this->param)];
            }else{
                return ['code' => 0,'msg' => '操作失败'];
            }
        }
    }

    //回车
    public function editBack(){
        if($this->request->isPost()){
            $data['info'] = BusRecordModel::get($this->id);
            if(!$data['info'] || $data['info']['status'] != 1) return ['code' => 0,'msg' => '参数错误'];;
            if($data['info']->save(['status'=>2])){
                if(empty(BusRecordModel::get(['order_id' => $data['info']['order_id'],'status' => ['neq',2]]))){
                    $info = OrderModel::alias('a')
                        ->join('tp_bus_customer b','a.customer_id = b.id','left')
                        ->field('a.*,b.type as customer_type')
                        ->where(['a.id'=>$data['info']['order_id']])
                        ->find();
                    if($info['customer_type'] == 1){
                        $result['money'] = $info['total_money'] - $info['true_money'];
                        if($result['money'] > 0){
                            $result['customer_id'] = $info['customer_id'];
                            $result['order_id'] = $info['id'];
                            $result['add_date'] = $info['start_date'];
                            CustomerFinanceModel::create($result);
                        }
                    }
                    OrderModel::where(['id'=>$data['info']['order_id']])->update(['status'=>2]);
                    return ['code' => 1,'msg' => "已回车，交易完成",'url' => url('record/index',$this->param)];
                }
                return ['code' => 1,'msg' => "已回车",'url' => url('record/index',$this->param)];
            }else{
                return ['code' => 0,'msg' => '操作失败'];
            }
        }
    }

    //关闭订单
    public function editOff(){
        if($this->request->isPost()){
            $data['info'] = BusRecordModel::get($this->id);
            if(!$data['info']) return ['code' => 0,'msg' => '参数错误'];;
            if($data['info']->save(['status'=>3])){
                return ['code' => 1,'msg' => '车辆已取消,订单请重新派单','url' => url('record/index',$this->param)];
            }else{
                return ['code' => 0,'msg' => '操作失败'];
            }
        }
    }

    // 删除调度
    public function recordDelete(){
        if($this->request->isPost()) {
            $result = BusRecordModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('record/index',$this->param)];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //调度统计
    public function recordStatistics(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['b.num'=>'like','a.status'=>'in','a.create_time'=>['start','end']],$this->param);
        if(empty($this->param['status'])) $where['a.status'] = ['in','0,1,2'];
        $fields = 'count(a.id) as total_times,sum(c.total_money) as total_money,a.create_time,b.num,a.bus_id';
        $data['list'] = BusRecordModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->join('tp_bus_order c','a.order_id = c.id','left')
            ->field($fields)
            ->where($where)
            ->group('a.bus_id')
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('recordStatistics',$data);
    }

    //调度备注
    function recordFollow(){
        if(empty($this->id)) $this->error('参数错误');
        $data['list'] = BusRecordFollowModel::alias('a')
            ->join('tp_admin b','a.admin_id = b.id','left')
            ->where(['a.record_id' => $this->id])
            ->field('a.id,a.record_id,a.remarks,a.create_time,b.nick_name')
            ->order('create_time desc')
            ->select();
        $data['info'] = BusRecordModel::alias('a')->join('tp_bus b','a.bus_id = b.id','left')->field('a.*,b.num')->where(['a.id'=>$this->id])->find();
        return view('recordFollow',$data);
    }

    //添加备注
    function followAdd(){
        if($this->request->isPost()) {
            $remarks = isset($this->param['remarks']) ? $this->param['remarks'] : '';
            if (empty($remarks) || empty($this->id)) return ['code' => 0, 'msg' => '必须填写备注内容'];
            if (BusRecordFollowModel::create(['record_id' => $this->id, 'admin_id' => $this->uid, 'remarks' => $remarks])) {
                return ['code' => 1, 'msg' => '添加成功', 'url' => url('record/recordFollow',['id'=>$this->id])];
            } else {
                return ['code' => 0, 'msg' => '添加失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //删除备注
    function followDelete(){
        if($this->request->isPost()) {
            if (empty($this->id) || !isset($this->param['record_id'])) return ['code' => 0, 'msg' => '参数错误'];
            if (BusRecordFollowModel::destroy(['id' => $this->id])) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('record/recordFollow',['id'=>$this->param['record_id']])];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }
}