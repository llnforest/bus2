<?php
namespace admin\index\controller;

use think\Request;
use thinkcms\auth\model\AuthAccess;

class Auth extends BaseController
{
    public function _empty($name)
    {
        $auth =  new \thinkcms\auth\Auth();
        $auth = $auth->autoload($name);
        if($auth){
            if(isset($auth['code'])){
                return json($auth);
            }elseif(isset($auth['file'])){
                return $auth['file'];
            }
            $this->view->engine->layout(false);
            return $this->fetch($auth[0],$auth[1]);
        }
        return abort(404,'页面不存在');
    }



}

