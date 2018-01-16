<?php
//油费控制器
namespace admin\finance\controller;

use admin\bus\model\ContactModel;
use admin\finance\model\OilOutModel;
use admin\finance\model\OilInModel;
use admin\finance\model\OilModel;
use admin\bus\model\BusModel;
use admin\index\controller\BaseController;
use think\Request;
use think\Validate;


class Oil extends BaseController{

    private $roleValidate = ['name|油卡名称' => 'require|unique:tp_fi_oil,name^system_id','money|油卡金额'=>'require|digit','true_money|购买金额'=>'require|digit'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //---------------------------油卡----------------
    //油卡列表页
    public function index(){
        $orderBy  = 'a.id desc';
        $where  = getWhereParam(['a.name'=>'like','a.buy_date'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $sql_in = OilInModel::field('oil_id,sum(true_money) as in_true,sum(money) as in_money')->group('oil_id')->buildSql();
        $sql_out = OilOutModel::field('oil_id,sum(fee) as out_money')->group('oil_id')->buildSql();
        $data['list'] = OilModel::alias('a')
            ->join([$sql_in => 'b'],'a.id = b.oil_id','left')
            ->join([$sql_out => 'c'],'a.id = c.oil_id','left')
            ->field('a.*,b.in_money,b.in_true,(a.money + ifnull(b.in_money,0)-ifnull(c.out_money,0)) as follow_money,c.out_money')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加油卡
    public function oilAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(OilModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('oil/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('oilAdd');
    }

    //修改油卡
    public function oilEdit(){
        $data['info'] = OilModel::get([$this->id]);
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('oil/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        return view('oilEdit',$data);
    }

    // 删除油卡
    public function oilDelete(){
        if($this->request->isPost()) {
            $result = OilModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                OilInModel::where(['oil_id' => $this->id])->delete();
                OilOutModel::where(['oil_id' => $this->id])->delete();
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('oil/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //选择车牌号
    public function busSelect(){
        $data['busList'] = BusModel::where(['status' => 1,'system_id'=>$this->system_id])->select();
        $data['id'] = $this->id;
        return view('busSelect',$data);
    }

    //油卡充值列表页
    public function oilIn(){
        $orderBy  = 'a.id desc';
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $where  = getWhereParam(['a.oil_id','a.in_date'=>['start','end']],$this->param);
        $data['list'] = OilInModel::alias('a')
            ->join('tp_fi_oil b','a.oil_id = b.id','left')
            ->field('a.*,b.name as oil_name')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['oil'] = OilModel::all(['system_id'=>$this->system_id]);
        return view('oilIn',$data);
    }

    // 删除进货油卡记录
    public function oilInDelete(){
        if($this->request->isPost()) {
            $result = OilInModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('oil/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //加油记录列表页
    public function oilOut(){
        $orderBy  = 'a.id desc';
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $where  = getWhereParam(['a.oil_id','c.num','a.out_date'=>['start','end']],$this->param);
        $data['list'] = OilOutModel::alias('a')
            ->join('tp_fi_oil b','a.oil_id = b.id','left')
            ->join('tp_bus c','a.bus_id = c.id','left')
            ->join('tp_bus_contact d','a.contact_id = d.id','left')
            ->field('a.*,b.name as oil_name,c.num as bus_num,d.name as contact_name')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['oil'] = OilModel::all(['system_id'=>$this->system_id]);
        return view('oilOut',$data);
    }

    // 删除加油记录
    public function oilOutDelete(){
        if($this->request->isPost()) {
            $result = OilOutModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('oil/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //充值油卡
    public function addOilIn(){
        if($this->request->isPost()){
            $validate = new Validate(['money|充值面值'=>'require|digit','true_money|充值金额'=>'require|digit']);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(OilInModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('oil/oilIn')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        $data['info'] = OilModel::field('id as oil_id,name')->where(['id' => $this->id])->find();
        return view('addOilIn',$data);
    }

    //加油
    public function addOilOut(){
        $data['type'] = isset($this->param['type'])?$this->param['type']:0;
        if($this->request->isPost()){
            $validate = new Validate(['bus_id|选择加油车辆'=>'require','contact_id|选择加油站'=>'require','fee|加油金额金额'=>'require|digit']);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(OilOutModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('oil/oilOut')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        $data['info'] = OilModel::field('id as oil_id,name')->where(['id' => $this->id])->find();
        return view('addOilOut',$data);
    }

    //选择维修保养点
    public function contactSelect(){
        $data['contactList'] = ContactModel::where(['type' => ['in','2'],'status'=>1,'system_id'=>$this->system_id])->select();
        $data['id'] = $this->id;
        return view('contactSelect',$data);
    }

}