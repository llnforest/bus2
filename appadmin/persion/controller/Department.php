<?php
//部门控制器
namespace admin\persion\controller;

use admin\persion\model\DepartmentModel;
use admin\bus\model\BusModel;
use admin\index\controller\BaseController;
use admin\persion\model\UserModel;
use think\Request;
use think\Validate;


class Department extends BaseController{

    private $roleValidate = ['name|部门名称' => 'require','sort|排序' => 'integer'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //部门列表页
    public function index(){
        $orderBy  = 'sort asc';
        $where  = getWhereParam(['name'=>'like','is_bus'],$this->param,0);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $data['list'] = DepartmentModel::where($where)
                            ->order($orderBy)
                            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加部门
    public function departmentAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(DepartmentModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('department/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('departmentAdd');
    }

    //修改部门
    public function departmentEdit(){
        $data['info'] = DepartmentModel::get($this->id);
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('department/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        return view('departmentEdit',$data);
    }

    // 删除部门
    public function departmentDelete(){
        if($this->request->isPost()) {
            $result = DepartmentModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if(!empty(BusModel::get(['department_id'=>$this->id])) || !empty(UserModel::get(['department_id'=>$this->id]))) return ['code' => 0, 'msg' => '删除失败,该部门已被应用'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('department/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    // 修改排序
    public function orderSort(){
        if($this->request->isPost()) {
            $result = DepartmentModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            $this->param['data'] = !empty($this->param['data']) ? $this->param['data'] : '';
            $roleValidate = ['data|排序' => 'require|integer'];
            $validate = new Validate($roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError(),'text'=>$result['sort']];
            if ($result->save(['sort' => $this->param['data']])) {
                return ['code' => 1, 'msg' => '排序更新成功'];
            } else {
                return ['code' => 0, 'msg' => '排序更新失败','text'=>$result['sort']];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }
}