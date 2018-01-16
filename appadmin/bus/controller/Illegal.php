<?php
//违章控制器
namespace admin\bus\controller;

use admin\bus\model\BusModel;
use admin\bus\model\IllegalModel;
use admin\index\controller\BaseController;
use admin\persion\model\UserModel;
use think\Request;
use think\Validate;


class Illegal extends BaseController{

    private $roleValidate = ['user_id|驾驶员' => 'require','bus_id|车辆' => 'require','illegal_date' => 'require'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //违章列表页
    public function index(){
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
        return view('index',$data);
    }

    //添加违章
    public function illegalAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(IllegalModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('illegal/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('illegalAdd');
    }

    //修改违章
    public function illegalEdit(){
        $data['info'] = IllegalModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->join('tp_hr_user c','a.user_id = c.id','left')
            ->field('a.*,b.num,c.name')
            ->where(['a.id' => $this->id])
            ->find();
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('illegal/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        return view('illegalEdit',$data);
    }

    // 删除违章
    public function illegalDelete(){
        if($this->request->isPost()) {
            $result = IllegalModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('illegal/index')];
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

}