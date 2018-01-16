<?php
//事故控制器
namespace admin\bus\controller;

use admin\bus\model\AccidentModel;
use admin\bus\model\BusModel;
use admin\bus\model\ContactModel;
use admin\index\controller\BaseController;
use admin\persion\model\UserModel;
use think\Request;
use think\Validate;


class Accident extends BaseController{

    private $roleValidate = ['user_id|驾驶员' => 'require','bus_id|车辆' => 'require','accident_date' => 'require'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //事故列表页
    public function index(){
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
        return view('index',$data);
    }

    //添加事故
    public function accidentAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(AccidentModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('accident/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        $data['contact'] = ContactModel::all(['type'=>4,'status'=>1,'system_id'=>$this->system_id]);
        return view('accidentAdd',$data);
    }

    //修改事故
    public function accidentEdit(){
        $data['info'] = AccidentModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->join('tp_hr_user c','a.user_id = c.id','left')
            ->join('tp_bus_contact d','a.repair_id = d.id','left')
            ->join('tp_bus_contact e','a.contact_id = e.id','left')
            ->field('a.*,b.num,c.name,d.name as repair_name,e.name as contact_name')
            ->where(['a.id' => $this->id])
            ->find();
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('accident/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        $data['contact'] = ContactModel::all(['type'=>4,'status'=>1,'system_id'=>$this->system_id]);
        return view('accidentEdit',$data);
    }

    // 删除事故
    public function accidentDelete(){
        if($this->request->isPost()) {
            $result = AccidentModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('accident/index')];
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

    //选择驾驶员
    public function userSelect(){
        $data['userList'] = UserModel::where(['is_driver' => 1,'status'=>1,'system_id'=>$this->system_id])->select();
        $data['id'] = $this->id;
        return view('userSelect',$data);
    }

    //选择往来单位
    public function contactSelect(){
        $data['contactList'] = ContactModel::where(['type' => ['in','1,5'],'status'=>1,'system_id'=>$this->system_id])->select();
        $data['id'] = $this->id;
        return view('contactSelect',$data);
    }

}