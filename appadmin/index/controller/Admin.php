<?php
namespace admin\index\controller;


use admin\index\model\AdminModel;
use admin\index\model\SystemModel;
use think\Config;
use think\Db;
use think\Request;
use thinkcms\auth\model\AuthRole;
use thinkcms\auth\model\AuthRoleUser;
use thinkcms\auth\Auth;


class Admin extends BaseController
{

    protected $id,$post,$adminModel;
    protected $url  = 'admin/index';
    protected static $authRoleTable     = 'auth_role';
    protected static $authRoleUserTable = 'auth_role_user';


    public function __construct(\think\Request $request)
    {
        parent::__construct();
        $this->post         = $request->post();
        $this->adminModel   = new AdminModel();
        $this->id           = isset($this->param['id'])?intval($this->param['id']):'';

    }

    /**
     * 列表
     */
    public function index()
    {
        $list = AdminModel::where(['system_id'=>$this->system_id])->paginate($this->config_page,'',['query'=>$this->param]);
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
        $system = SystemModel::get($this->system_id);
        $info['code'] = $system['code'];
        if($this->request->isPost()){
            $post           = $this->post;
            $post['name'] = $system['code'].'_'.$post['name'];
            //验证
            $result = $this->validate($post,[
                ['name|账户','require|unique:tp_admin,name='.$post['name']],
                ['email|邮箱','require|email'],
                ['password|密码','require'],
                ['phone|手机','require|mobile'],
                ['role|角色','require'],
            ]);

            if (true !== $result) {
                return ['code' =>0,'msg'=>$result,'url' => url('admin/index')];
            }
            $role           = $post['role'];
            $post['password']  = md5($post['password']);
            $post['role']           = implode(',',$role);
            $post['system_id'] = $this->system_id;
            $insert = $this->adminModel->create($post);//增加

            if($insert){
                //加入角色
                $authRoleUser = new AuthRoleUser();
                $authRoleUser->authRoleUserAdd($role,$insert['id']);
                return ['code' =>1,'msg'=>'添加成功','url' => url('admin/index')];
            }else{
                return ['code' =>0,'msg'=>'添加失败','url' => url('admin/index')];
            }
        }
        $info['role'] = $this->role();
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 修改
     */
    public function edit()
    {
        $id = $this->id;
        $info = $this->adminModel->get($id);
        if($this->request->isPost()){
            $post           = $this->post;
            //验证
            $result = $this->validate($post,[
                ['email|邮箱','require|email'],
                ['phone|手机','require|mobile'],
                ['role|角色','require'],
            ]);
            if (true !== $result) {
                return ['code' =>0,'msg'=>$result,'url' => url('admin/index')];
            }
            $role = $post['role'];

            $password = $post['password'];
            if(!empty($password)){
                $post['password'] = md5($password);
            }else{
                unset($post['password']);
            }
            $post['role'] = implode(',',$role);
            if($info->save($post)){//修改
                //加入角色
                $authRoleUser = new AuthRoleUser();
                $authRoleUser->authRoleUserAdd($role,$id);
                return ['code' =>1,'msg'=>'修改成功','url' => url('admin/index')];
            }else{
                return ['code' =>0,'msg'=>'修改失败','url' => url('admin/index')];
            }
        }
        $info['role'] = $this->role($info['role']);
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function password(){
        if($this->request->isPost()){
            $post           = $this->post;
            $admin = AdminModel::get($this->uid);
            if(empty($admin)){
                return ['code'=>0,'msg'=>'数据错误'];
            }
            $result = $this->validate($post,[
                ['old_password|原密码','require'],
                ['password|新密码','require'],
                ['c_password|确认密码','require']
            ]);

            if (true !== $result) {
                return ['code'=>0,'msg'=>$result];
            }
            if(md5($post['c_password']) != md5($post['password'])){
                return ['code'=>0,'msg'=>'新密码与确认密码不一致'];
            }
            if(md5($post['old_password']) != $admin['password']){
                return ['code'=>0,'msg'=>'原密码不一致'];
            }
            $admin->save(['password'=>md5($post['password'])]);
            Auth::logout();
            return ['code'=>1,'msg'=>'修改成功','parents_url'=>url('publics/login')];
        }
        return view('password');
    }

    /**
     * 删除
     */
    public function delete($id)
    {
        if(!$this->request->isAjax()){
            return abort(404, lang('删除方式错误'));
        }else if($id==1){
            return $this->error('超级管理员不能删除');
        }

        if(AdminModel::where(['id'=>$id])->delete()){

            //删除角色权限
            $authRoleUser = new AuthRoleUser();
            $authRoleUser->authRoleUserDelete($id);

            return $this->success('删除成功',url($this->url));
        }else{
            return $this->error('删除失败');
        }

    }

    /**
     * 管理员状态修改
     */
    public function status(){
        if($this->request->isPost()){
            $id     = isset($this->param['id'])?$this->param['id']:0;
            $param  = isset($this->param['data'])?$this->param['data']:0;
            $ratify = $this->adminModel->allowField(['status'])->save(['status'=>$param],['id'=>$id]);
            if($ratify){
                return ['code' => 1,'msg' => '状态变更成功'];
            }else{
                return ['code' => 0,'msg' => '状态变更失败'];
            }
        }
        return ['code' => 0,'msg' => '请求方式错误'];
    }

    private function role($roleid = ''){
        $roleid = explode(',',$roleid);
        $role = AuthRole::where(['system_id'=>['in','0,'.$this->system_id]])->column('name','id');
        $html = '';
        foreach($role as $k=>$v){
            $selected = in_array($k, $roleid)?'selected':'';

            $html   .= ' <option '.$selected.' value="'.$k.'">'.$v.'</option>';
        }

        return $html;
    }

}

?>