<?php
namespace admin\index\controller;


use admin\index\model\AdminModel;
use admin\index\model\SystemModel;


class System extends BaseController
{

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 列表
     */
    public function index()
    {
        $list = SystemModel::paginate($this->config_page,'',['query'=>$this->param]);
        $this->assign([
            'list'  => $list,
            'page'  => $list->render()
        ]);
        return $this->fetch();
    }

    /**
     * 增加
     */
    public function add()
    {
        if($this->request->isPost()){
            $post           = $this->param;
            //验证
            $result = $this->validate($post,[
                ['name|账户','require|unique:tp_system,name='.$post['name']],
                ['code|企业简称','require|unique:tp_system,code='.$post['code']]
            ]);

            if (true !== $result) {
                return ['code' =>0,'msg'=>$result];
            }
            $admin = AdminModel::get(['name'=>$post['code'].'_admin']);
            if(!empty($admin))  return ['code' =>0,'msg'=>'请更改企业简称'];
            $insert = SystemModel::create($post);//增加

            if($insert){
                AdminModel::create(['name'=>$post['code'].'_admin','password'=>md5('123456'),'system_id'=>$insert['id'],'role'=>'1','nick_name'=>'超级管理员']);
                return ['code' =>1,'msg'=>'添加成功','url' => url('system/index')];
            }else{
                return ['code' =>0,'msg'=>'添加失败'];
            }
        }
        return $this->fetch();
    }

    /**
     * 平台状态修改
     */
    public function status(){
        if($this->request->isPost()){
            $id     = isset($this->param['id'])?$this->param['id']:0;
            $param  = isset($this->param['data'])?$this->param['data']:0;
            $system = new SystemModel();
            $ratify = $system->allowField(['status'])->save(['status'=>$param],['id'=>$id]);
            if($ratify){
                return ['code' => 1,'msg' => '状态变更成功'];
            }else{
                return ['code' => 0,'msg' => '状态变更失败'];
            }
        }
        return ['code' => 0,'msg' => '请求方式错误'];
    }

}

?>