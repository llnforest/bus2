<?php
//报销控制器
namespace admin\finance\controller;

use admin\finance\model\ReimburseModel;
use admin\index\controller\BaseController;
use admin\persion\model\DepartmentModel;
use admin\persion\model\UserModel;
use think\Request;
use think\Validate;


class Reimburse extends BaseController{

    private $roleValidate = ['title|报销项目'=>'require','user_id|员工'=>'require','reimburse_date|报销日期' => 'require','department_id|部门'=>'require','fee|报销金额'=>'require|digit'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //报销列表页
    public function index(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['a.title'=>'like','b.name'=>'like','a.department_id','a.reimburse_date'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name as user_name,c.name as department_name';
        $data['list'] = ReimburseModel::alias('a')
                            ->join('tp_hr_user b','a.user_id = b.id','left')
                            ->join('tp_hr_department c','a.department_id = c.id','left')
                            ->field($fields)
                            ->where($where)
                            ->order($orderBy)
                            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['department'] = DepartmentModel::all(['system_id'=>$this->system_id]);
        return view('index',$data);
    }

    //添加报销
    public function reimburseAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(ReimburseModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('reimburse/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        $data['department'] = DepartmentModel::all(['system_id'=>$this->system_id]);
        return view('reimburseAdd',$data);
    }

    //修改报销
    public function reimburseEdit(){
        $data['info'] = ReimburseModel::alias('a')->join('tp_hr_user b','a.user_id = b.id','left')->field('a.*,b.name as user_name')->where(['a.id'=>$this->id])->find();
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('reimburse/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        $data['department'] = DepartmentModel::all(['system_id'=>$this->system_id]);
        return view('reimburseEdit',$data);
    }

    // 删除报销
    public function reimburseDelete(){
        if($this->request->isPost()) {
            $result = ReimburseModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('reimburse/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //选择员工
    public function userSelect(){
        $data['userList'] = UserModel::where(['status' => 1,'system_id'=>$this->system_id])->select();
        $data['id'] = $this->id;
        return view('userSelect',$data);
    }

}