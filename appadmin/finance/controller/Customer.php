<?php
//客户账单控制器
namespace admin\finance\controller;

use admin\bus\model\AccidentModel;
use admin\bus\model\CheckModel;
use admin\bus\model\CustomerModel;
use admin\bus\model\OrderModel;
use admin\finance\model\CustomerFinanceModel;
use admin\index\controller\BaseController;
use think\Db;
use think\Request;
use think\Validate;


class Customer extends BaseController{
    private $roleValidate = ['customer_id|客户' => 'require','money|还款金额' => 'require|digit'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //客户总账列表页
    public function index(){
        $orderBy  = 'b.create_time desc';
        $where  = getWhereParam(['b.name'=>'like','b.phone','b.status','b.type'],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $lend_sql = CustomerFinanceModel::field('customer_id,sum(money) as lend_money,0 as back_money,system_id')->where(['type' => 1])->group('customer_id')->buildSql();
        $back_sql = CustomerFinanceModel::field('customer_id,0 as lend_money,sum(money) as back_money,system_id')->where(['type' => 2])->group('customer_id')->buildSql();

        $data['list'] = Db::table(["({$lend_sql} union {$back_sql})" => 'a'])
                        ->join('tp_bus_customer b','a.customer_id = b.id','left')
                        ->field('b.*,sum(a.lend_money) as lend_money,sum(a.back_money) as back_money,sum(a.lend_money - a.back_money) as total_money')
                        ->where($where)
                        ->group('customer_id')
                        ->order($orderBy)
                        ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //客户账单列表页
    public function customerList(){
        $orderBy  = 'create_time desc';
        $where  = getWhereParam(['b.name'=>'like','a.ustomer_id','a.type','a.add_date'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];

        $data['list'] = CustomerFinanceModel::alias('a')
            ->join('tp_bus_customer b','a.customer_id = b.id','left')
            ->field('a.*,b.name')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('customerList',$data);
    }

    //添加客户账单
    public function customerAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(CustomerFinanceModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('customer/customerList')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        if($this->id){
            $data['info'] = CustomerModel::get($this->id);
        }
        $data['info']['add_date'] = date('Y-m-d',time());
        return view('customerAdd',$data);
    }

    // 删除客户账单
    public function customerDelete(){
        if($this->request->isPost()) {
            $result = CustomerFinanceModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('customer/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //选择客户
    public function customerSelect(){
        $data['customerList'] = CustomerModel::where(['status' => 1,'system_id'=>$this->system_id])->select();
        return view('customerSelect',$data);
    }

}