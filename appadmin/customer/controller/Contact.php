<?php
//往来单位控制器
namespace admin\customer\controller;

use admin\bus\model\AccidentModel;
use admin\bus\model\CheckModel;
use admin\bus\model\ContactModel;
use admin\index\controller\BaseController;
use think\Request;
use think\Validate;


class Contact extends BaseController{

    private $roleValidate = ['name|单位名称' => 'require','phone|联系电话' => 'contact'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //往来单位列表页
    public function index(){
        $orderBy  = 'create_time desc';
        $where  = getWhereParam(['name'=>'like','phone','contact'=>'like','type','create_time'=>['start','end']],$this->param,0);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];

        $data['list'] = ContactModel::where($where)
                            ->order($orderBy)
                            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加往来单位
    public function contactAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(ContactModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('contact/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('contactAdd');
    }

    //修改往来单位
    public function contactEdit(){
        $data['info'] = ContactModel::get($this->id);
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('contact/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        return view('contactEdit',$data);
    }

    // 删除往来单位
    public function contactDelete(){
        if($this->request->isPost()) {
            $result = ContactModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if(!empty(AccidentModel::get(['contact_id'=>$this->id])) || !empty(CheckModel::get(['contact_id'=>$this->id]))) return ['code' => 0, 'msg' => '删除失败,该往来单位已被应用'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('contact/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    // 修改往来单位状态
    public function editStatus(){
        if($this->request->isPost()){
            $id     = isset($this->param['id'])?$this->param['id']:0;
            $status  = isset($this->param['data'])?$this->param['data']:0;
            $info = new ContactModel();
            if($info->update(['id'=>$id,'status'=>$status])){
                return ['code' => 1,'msg' => '状态变更成功'];
            }else{
                return ['code' => 0,'msg' => '状态变更失败'];
            }
        }
        return ['code' => 0,'msg' => '请求方式错误'];
    }
}