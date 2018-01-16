<?php
//车辆归属控制器
namespace admin\bus\controller;

use admin\bus\model\BusModel;
use admin\bus\model\CorporationModel;
use admin\index\controller\BaseController;
use think\Request;
use think\Validate;


class Corporation extends BaseController{

    private $roleValidate = ['name|归属名称' => 'require','phone|联系电话' => 'contact'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //车辆归属列表页
    public function index(){
        $orderBy  = 'sort asc,create_time desc';
        $where  = getWhereParam(['name'=>'like','phone','contact'=>'like','create_time'=>['start','end']],$this->param,0);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $data['list'] = CorporationModel::where($where)
                            ->order($orderBy)
                            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加车辆归属
    public function corporationAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(CorporationModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('corporation/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('corporationAdd');
    }

    //修改车辆归属
    public function corporationEdit(){
        $data['info'] = CorporationModel::get($this->id);
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('corporation/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        return view('corporationEdit',$data);
    }

    // 删除车辆归属
    public function corporationDelete(){
        if($this->request->isPost()) {
            $result = CorporationModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if(!empty(BusModel::get(['corporation_id'=>$this->id]))) return ['code' => 0, 'msg' => '删除失败,该车辆归属已被应用'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('corporation/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }


    // 修改归属公司状态
    public function editStatus(){
        if($this->request->isPost()){
            $id     = isset($this->param['id'])?$this->param['id']:0;
            $status  = isset($this->param['data'])?$this->param['data']:0;
            $info = new CorporationModel();
            if($info->update(['id'=>$id,'status'=>$status])){
                return ['code' => 1,'msg' => '状态变更成功'];
            }else{
                return ['code' => 0,'msg' => '状态变更失败'];
            }
        }
        return ['code' => 0,'msg' => '请求方式错误'];
    }

    // 修改排序
    public function orderSort(){
        if($this->request->isPost()) {
            $result = CorporationModel::get($this->id);
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