<?php
//年检控制器
namespace admin\bus\controller;

use admin\bus\model\BusModel;
use admin\bus\model\CheckModel;
use admin\bus\model\ContactModel;
use admin\index\controller\BaseController;
use think\Request;
use think\Validate;


class Check extends BaseController{

    private $roleValidate = ['bus_id|车辆' => 'require','contact_id|检测站','check_date|年检日期' => 'require','end_date|到期日期' => 'require'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //年检列表页
    public function index(){
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
        return view('index',$data);
    }

    //添加年检
    public function checkAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(CheckModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('check/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        $data['contact'] = ContactModel::all(['type'=>6,'status'=>1,'system_id'=>$this->system_id]);
        return view('checkAdd',$data);
    }

    //修改年检
    public function checkEdit(){
        $data['info'] = CheckModel::alias('a')
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
                return ['code' => 1,'msg' => '修改成功','url' => url('check/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        $data['contact'] = ContactModel::all(['type'=>6,'status'=>1,'system_id'=>$this->system_id]);
        return view('checkEdit',$data);
    }

    // 删除年检
    public function checkDelete(){
        if($this->request->isPost()) {
            $result = CheckModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('check/index')];
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


}