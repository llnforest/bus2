<?php
//配件控制器
namespace admin\bus\controller;

use admin\bus\model\MachineInModel;
use admin\bus\model\MachineModel;
use admin\bus\model\BusModel;
use admin\bus\model\ContactModel;
use admin\bus\model\MachineOutModel;
use admin\index\controller\BaseController;
use admin\persion\model\UserModel;
use think\Request;
use think\Validate;


class Machine extends BaseController{

    private $roleValidate = ['name|配件名称' => 'require|unique:tp_bus_machine,name^system_id'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //---------------------------配件----------------
    //配件列表页
    public function index(){
        $orderBy  = 'a.id desc';
        $where  = getWhereParam(['a.name'],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $sql_in = MachineInModel::field('machine_id,sum(num) as in_num')->group('machine_id')->buildSql();
        $sql_out = MachineOutModel::field('machine_id,sum(num) as out_num')->group('machine_id')->buildSql();
        $data['list'] = MachineModel::alias('a')
            ->join([$sql_in => 'b'],'a.id = b.machine_id','left')
            ->join([$sql_out => 'c'],'a.id = c.machine_id','left')
            ->field('a.*,b.in_num,c.out_num,(ifnull(b.in_num,0)-ifnull(c.out_num,0)) as follow_num')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加配件
    public function machineAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(MachineModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('machine/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('machineAdd');
    }

    //修改配件
    public function machineEdit(){
        $data['info'] = MachineModel::get([$this->id]);
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('machine/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        return view('machineEdit',$data);
    }

    // 删除配件
    public function machineDelete(){
        if($this->request->isPost()) {
            $result = MachineModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                MachineInModel::where(['machine_id' => $this->id])->delete();
                MachineOutModel::where(['machine_id' => $this->id])->delete();
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('machine/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //选择用户
    public function userSelect(){
        $data['userList'] = UserModel::where(['is_driver' => 1,'status' => 1,'system_id'=>$this->system_id])->select();
        $data['id'] = $this->id;
        return view('userSelect',$data);
    }

    //选择车牌号
    public function busSelect(){
        $data['busList'] = BusModel::where(['status' => 1,'system_id'=>$this->system_id])->select();
        $data['id'] = $this->id;
        return view('busSelect',$data);
    }

    //配件采购列表页
    public function machineIn(){
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
        $data['machine'] = MachineModel::all(['system_id'=>$this->system_id]);
        return view('machineIn',$data);
    }

    // 删除进货配件记录
    public function machineInDelete(){
        if($this->request->isPost()) {
            $result = MachineInModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('machine/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //配件领取列表页
    public function machineOut(){
        $orderBy  = 'a.id desc';
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $where  = getWhereParam(['a.machine_id','c.user_name','a.out_date'=>['start','end']],$this->param);
        $data['list'] = MachineOutModel::alias('a')
            ->join('tp_bus_machine b','a.machine_id = b.id','left')
            ->join('tp_bus c','a.bus_id = c.id','left')
            ->field('a.*,b.name as machine_name,c.num as bus_num')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['machine'] = MachineModel::all(['system_id'=>$this->system_id]);
        return view('machineOut',$data);
    }

    // 删除进货配件记录
    public function machineOutDelete(){
        if($this->request->isPost()) {
            $result = MachineOutModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('machine/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //添加进出配件
    public function operateAdd(){
        $data['type'] = isset($this->param['type'])?$this->param['type']:0;
        if($this->request->isPost()){
            $validate = new Validate(['num|数量'=>'require|integer']);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if($data['type'] == 1){//type:1进货 2领用
                $result = MachineInModel::create($this->param);
                $url = 'machine/machineIn';
            }else{
                $result = MachineOutModel::create($this->param);
                $url = 'machine/machineOut';
            }
            if($result){
                return ['code' => 1,'msg' => '添加成功','url' => url($url)];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        $data['info'] = MachineModel::field('id as machine_id,name')->where(['id' => $this->id])->find();
        return view('operateAdd',$data);
    }

    //修改进出配件
    public function operateEdit(){
        $data['type'] = isset($this->param['type'])?$this->param['type']:0;
        if($data['type'] == 1){//type:1进货 2领用
            $data['info'] = MachineInModel::alias('a')
                ->join('tp_bus_machine b','a.machine_id = b.id','left')
                ->join('tp_hr_user c','a.user_id = c.id','left')
                ->field('a.*,b.name,c.name as user_name')
                ->where(['a.id' => $this->id])
                ->find();
            $url = 'machine/machineIn';
        }else{
            $data['info'] = MachineOutModel::alias('a')
                ->join('tp_bus_machine b','a.machine_id = b.id','left')
                ->join('tp_bus c','a.bus_id = c.id','left')
                ->field('a.*,b.name,c.num as bus_num')
                ->where(['a.id' => $this->id])
                ->find();
            $url = 'machine/machineOut';
        }
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate(['num|数量'=>'require|integer']);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url($url)];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        return view('operateEdit',$data);
    }
}