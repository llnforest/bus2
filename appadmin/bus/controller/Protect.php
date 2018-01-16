<?php
//维修保养控制器
namespace admin\bus\controller;

use admin\bus\model\BusModel;
use admin\bus\model\ProtectModel;
use admin\bus\model\ContactModel;
use admin\index\controller\BaseController;
use think\Request;
use think\Validate;


class Protect extends BaseController{

    private $roleValidate = ['bus_id|车辆' => 'require','contact_id|维保点','protect_date|维保日期' => 'require'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //维修保养列表页
    public function index(){
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
        return view('index',$data);
    }

    //添加维修保养
    public function protectAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(ProtectModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('protect/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('protectAdd');
    }

    //修改维修保养
    public function protectEdit(){
        $data['info'] = ProtectModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->join('tp_bus_contact c','a.contact_id = c.id','left')
            ->field('a.*,b.num,c.name')
            ->where(['a.id' => $this->id])
            ->find();
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('protect/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        return view('protectEdit',$data);
    }

    // 删除维修保养
    public function protectDelete(){
        if($this->request->isPost()) {
            $result = ProtectModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('protect/index')];
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

    //选择维修保养点
    public function contactSelect(){
        $data['contactList'] = ContactModel::where(['type' => ['in','1,5'],'status'=>1,'system_id'=>$this->system_id])->select();
        $data['id'] = $this->id;
        return view('contactSelect',$data);
    }

}