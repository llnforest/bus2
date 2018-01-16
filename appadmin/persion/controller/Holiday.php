<?php
//请假控制器
namespace admin\persion\controller;

use admin\persion\model\HolidayModel;
use admin\index\controller\BaseController;
use admin\persion\model\UserModel;
use think\Request;
use think\Validate;


class Holiday extends BaseController{

    private $roleValidate = ['user_id|请假'=>'require','start_date|开始日期' => 'require','end_date|结束日期' => 'require','days|请假天数'=>'require|number'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //请假列表页
    public function index(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['b.name'=>'like','a.create_time'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name';
        $data['list'] = HolidayModel::alias('a')
                            ->join('tp_hr_user b','a.user_id = b.id','left')
                            ->field($fields)
                            ->where($where)
                            ->order($orderBy)
                            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加请假
    public function holidayAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(HolidayModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('holiday/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('holidayAdd');
    }

    //修改请假
    public function holidayEdit(){
        $data['info'] = HolidayModel::alias('a')->join('tp_hr_user b','a.user_id = b.id','left')->field('a.*,b.name')->where(['a.id'=>$this->id])->find();
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('holiday/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        return view('holidayEdit',$data);
    }

    // 删除请假
    public function holidayDelete(){
        if($this->request->isPost()) {
            $result = HolidayModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('holiday/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //选择请假
    public function userSelect(){
        $data['userList'] = UserModel::where(['status' => 1,'system_id'=>$this->system_id])->select();
        $data['id'] = $this->id;
        return view('userSelect',$data);
    }

}