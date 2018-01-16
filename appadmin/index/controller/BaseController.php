<?php
namespace admin\index\controller;



use think\Controller;
use think\Config;
use think\Request;
use thinkcms\auth\Auth;


class BaseController extends Controller
{

    public $uid;
    public $config_page = 50;
    public $other_uid = '';
    public $role;
    protected $param;
    protected $system_id;
    protected $id;
    public function __construct()
    {
        parent::__construct();
        $this->request      = Request::instance();
        $this->param        = $this->request->param();
        $this->id               = isset($this->param['id'])?$this->param['id']:'';
        $auth                   = new Auth();
        $auth->noNeedCheckRules = ['index/index/index','index/index/home'];
        $auth->log              = true;                 // v1.1版本  日志开关默认true
        $user                   = $auth::is_login();
        if($user){//用户登录状态
            $this->uid = $user['uid'];
            $this->param['system_id'] = $user['system_id'];
            $this->system_id = $user['system_id'];
            $this->role = $user['role'];
            if(!$auth->auth()){
                $this->error("你没有权限访问！");
            }
        }else{
            $this->redirect('index/publics/login');
        }
    }




}
