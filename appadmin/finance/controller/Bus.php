<?php
//配件控制器
namespace admin\finance\controller;

use admin\bus\model\AccidentModel;
use admin\bus\model\CheckModel;
use admin\bus\model\IllegalModel;
use admin\bus\model\MachineInModel;
use admin\bus\model\MachineModel;
use admin\bus\model\ContactModel;
use admin\bus\model\ProtectModel;
use admin\index\controller\BaseController;
use think\Request;
use think\Validate;


class Bus extends BaseController{

    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //配件采购列表页
    public function index(){
        $orderBy  = 'a.id desc';
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $where  = getWhereParam(['a.machine_id','c.user_name','a.in_date'=>['start','end']],$this->param);
        $data['list'] = MachineInModel::alias('a')
            ->join('tp_bus_machine b','a.machine_id = b.id','left')
            ->join('tp_hr_user c','a.user_id = c.id','left')
            ->field('a.*,b.name as machine_name,c.name as user_name')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['machine'] = MachineModel::all();
        return view('index',$data);
    }

    //维修保养列表页
    public function protect(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['b.num'=>'like','a.contact_id','a.protect_date'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $data['list'] = ProtectModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->join('tp_bus_contact c','a.contact_id = c.id','left')
            ->field('a.*,b.num,c.name')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['contact'] = ContactModel::all(['type'=>['in','1,5'],'status'=>1,'system_id'=>$this->system_id]);
        return view('protect',$data);
    }

    //年检列表页
    public function check(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['b.num'=>'like','a.contact_id','a.check_date'=>['start','end'],'a.end_date'=>['start_date','end_date']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $data['list'] = CheckModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->join('tp_bus_contact c','a.contact_id = c.id','left')
            ->field('a.*,b.num,c.name')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['contact'] = ContactModel::all(['type'=>6,'status'=>1,'system_id'=>$this->system_id]);
        return view('check',$data);
    }

    //违章列表页
    public function illegal(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['b.num'=>'like','c.name'=>'like','a.illegal_date'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $data['list'] = IllegalModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->join('tp_hr_user c','a.user_id = c.id','left')
            ->field('a.*,b.num,c.name')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('illegal',$data);
    }

    //事故列表页
    public function accident(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['b.num'=>'like','c.name'=>'like','a.accident_date'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $data['list'] = AccidentModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->join('tp_hr_user c','a.user_id = c.id','left')
            ->join('tp_bus_contact d','a.repair_id = d.id','left')
            ->join('tp_bus_contact e','a.contact_id = e.id','left')
            ->field('a.*,b.num,c.name,d.name as repair_name,e.name as contact_name')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('accident',$data);
    }

    //修改进货款项
    public function  editMachineMoney(){
        if($this->request->isPost()) {
            $data  = isset($this->param['data'])?intval($this->param['data']):'';
            $result = MachineInModel::get($this->id);
            $roleValidate = ['data|金额' => 'require|digit'];
            $validate = new Validate($roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError(),'text'=>$result['money']];
            if(empty($result)){
                return ['code'=>0,'msg'=>'没有数据'];
            }else if ($result) {
                if ($result->save(['money' => $data])) {
                    return ['code' => 1, 'msg' => '进货费用更新'];
                }
            }
            return ['code'=>0,'msg'=>'数据无变化'];
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //修改事故款项
    public function  editAccidentMoney(){
        if($this->request->isPost()) {
            $data  = isset($this->param['data'])?intval($this->param['data']):'';
            $result = AccidentModel::get($this->id);
            if($this->param['type'] == 1){
                $money = $result['lose'];
                $arr = ['lose' => $data];
                $text = '损失金额已更新';
            }else{
                $money = $result['insurance_money'];
                $arr = ['insurance_money' => $data];
                $text = '保险理赔金额已更新';
            }
            $roleValidate = ['data|金额' => 'require|digit'];
            $validate = new Validate($roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError(),'text'=>$money];
            if(empty($result)){
                return ['code'=>0,'msg'=>'没有数据'];
            }else if ($result) {
                if ($result->save($arr)) {
                    return ['code' => 1, 'msg' => $text];
                }
            }
            return ['code'=>0,'msg'=>'数据无变化'];
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //修改年检款项
    public function  editCheckMoney(){
        if($this->request->isPost()) {
            $data  = isset($this->param['data'])?intval($this->param['data']):'';
            $result = CheckModel::get($this->id);
            $roleValidate = ['data|金额' => 'require|digit'];
            $validate = new Validate($roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError(),'text'=>$result['fee']];
            if(empty($result)){
                return ['code'=>0,'msg'=>'没有数据'];
            }else if ($result) {
                if ($result->save(['fee' => $data])) {
                    return ['code' => 1, 'msg' => '年检费用已更新'];
                }
            }
            return ['code'=>0,'msg'=>'数据无变化'];
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //修改违章款项
    public function  editIllegalMoney(){
        if($this->request->isPost()) {
            $data  = isset($this->param['data'])?intval($this->param['data']):'';
            $result = IllegalModel::get($this->id);
            $roleValidate = ['data|金额' => 'require|digit'];
            $validate = new Validate($roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError(),'text'=>$result['money']];
            if(empty($result)){
                return ['code'=>0,'msg'=>'没有数据'];
            }else if ($result) {
                if ($result->save(['money' => $data])) {
                    return ['code' => 1, 'msg' => '罚款费用已更新'];
                }
            }
            return ['code'=>0,'msg'=>'数据无变化'];
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //修改维修保养款项
    public function  editProtectMoney(){
        if($this->request->isPost()) {
            $data  = isset($this->param['data'])?intval($this->param['data']):'';
            $result = ProtectModel::get($this->id);
            $roleValidate = ['data|金额' => 'require|digit'];
            $validate = new Validate($roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError(),'text'=>$result['fee']];
            if(empty($result)){
                return ['code'=>0,'msg'=>'没有数据'];
            }else if ($result) {
                if ($result->save(['fee' => $data])) {
                    return ['code' => 1, 'msg' => '维保费用已更新'];
                }
            }
            return ['code'=>0,'msg'=>'数据无变化'];
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }
}