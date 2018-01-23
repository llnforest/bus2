<?php
namespace admin\index\controller;

use admin\index\model\SystemAreaModel;
use admin\index\model\SystemCityModel;
use admin\index\model\SystemModel;
use think\Cache;
use think\Controller;
use think\Db;
use thinkcms\auth\Auth;
use admin\index\model\AdminModel;


class Publics extends Controller
{
    private $post;

    public function __construct(\think\Request $request)
    {
        parent::__construct($request);
        $this->post = $request->post();
        $this->request = $request;
    }

    /**
     * 登入
     */
    public function login()
    {
        if ($this->request->isPost()) {
            $post   = $this->post;

            $validate = [
                ['name|用户名','require|max:25'],
                ['login_password|密码','require']
            ];

            //验证
            $result = $this->validate($post,$validate);

            if (true !== $result) {
                return $this->error($result);
            }

            $data = [
                'name'      => $post['name'],
                'password'  => md5($post['login_password']),
            ];

            $list =  Db::name('tp_admin')->where($data)->find();
            if($list){
                $system = SystemModel::get($list['system_id']);
                if($list['id'] != 1 && empty($system)) $this->error('该平台不存在');
                if($list['id'] != 1 && $system['status'] == 0) $this->error('该平台已禁用');
                if($list['status'] != 1) return $this->error('账户暂时不能使用');
                Auth::login($list);
                //手动加入日志
                $auth = new Auth();
                $auth->createLog("管理员{$list['nick_name']}登录后台",'后台登录');
                AdminModel::where(['id'=>$list['id']])->update(['last_login_ip'=>$this->request->ip(),'last_login_time'=>date("Y-m-d H:i:s",time())]);
                return $this->redirect('index/index');
            }else{
                return $this->error('账户或密码错误');
            }
        }

        return $this->fetch();
    }
    /**
     * 退出视图
     */
    public function logout()
    {
        Auth::logout();
        $this->redirect('publics/login');
    }

    public function crontab(){
        Cache::set('a',date('Y-m-d H:i:s'));
    }

    /**
     * 清空缓存
     */
    public function clear(){
        Cache::clear();
        echo '缓存清除成功';
    }
}
