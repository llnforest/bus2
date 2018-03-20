<?php
//员工控制器
namespace admin\persion\controller;

use admin\bus\model\BusModel;
use admin\index\controller\Upload;
use admin\persion\model\DepartmentModel;
use admin\persion\model\LevelModel;
use admin\persion\model\UserModel;
use admin\index\controller\BaseController;
use think\Config;
use think\Loader;
use think\Request;
use think\Validate;


class User extends BaseController{
    private static $obj;
    private static $maxNum;
    private static $userArr = [];
    private $roleValidate = ['num|员工编号'=>'require|number|length:6','name|员工姓名' => 'require','phone|手机号码' => 'require|mobile'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //员工列表页
    public function index(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['a.name'=>'like','a.phone','a.num'=>'like','a.department_id','a.level_id','a.is_partner','a.is_driver','a.create_time'=>['start','end']],$this->param);
        $where['status'] = 1;
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name as department_name,c.name as level_name';
        $data['list'] = UserModel::alias('a')
                            ->join('tp_hr_department b','a.department_id = b.id','left')
                            ->join('tp_hr_level c','a.level_id = c.id','left')
                            ->field($fields)
                            ->where($where)
                            ->order($orderBy)
                            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['department'] = DepartmentModel::where(['system_id'=>$this->system_id])->order('sort asc')->select();
        $data['level'] = LevelModel::where(['system_id'=>$this->system_id])->order('sort asc')->select();
        return view('index',$data);
    }

    //添加员工
    public function userAdd(){
        $data['skip_type'] = empty($this->param['skip_type'])?'':$this->param['skip_type'];
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            $this->param['num'] = sprintf('%06s',$this->param['num']);
            if(UserModel::create($this->param)){
                if($data['skip_type'] == 'bus') return ['code' => 1,'msg' => '添加成功','url' => url('bus/bus/busAdd')];
                else return ['code' => 1,'msg' => '添加成功','url' => url('persion/user/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        $user = UserModel::field('max(num) as num')->find();
        if(empty($user['num'])){
            $data['info']['num'] = '000001';
        }else{
            $data['info']['num'] =  sprintf('%06s', $user['num'] + 1);
        }
        $data['department'] = DepartmentModel::where(['system_id'=>$this->system_id])->order('sort asc')->select();
        $data['level'] = LevelModel::where(['system_id'=>$this->system_id])->order('sort asc')->select();
        return view('userAdd',$data);
    }

    //修改员工
    public function userEdit(){
        $data['info'] = UserModel::get($this->id);
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('user/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        $data['department'] = DepartmentModel::where(['system_id'=>$this->system_id])->order('sort asc')->select();
        $data['level'] = LevelModel::where(['system_id'=>$this->system_id])->order('sort asc')->select();
        return view('userEdit',$data);
    }

    // 删除员工
    public function userDelete(){
        if($this->request->isPost()) {
            $result = UserModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            $is_driver = BusModel::whereOr(['fir_user_id' => $this->id,'sec_user_id' => $this->id])->find();
            if(!empty($is_driver)) return ['code' => 0,'msg' => '该用户已经是车的司机，不可删除'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('user/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //导入用户
    public function importUser(){
        set_time_limit(0);
        //post 数据处理
        if(!$this->request->isPost())  return view('index');
        $upload = new Upload();
        $fileArr = $upload->file();
        if($fileArr['code'] == 0) return $fileArr;
        $fileName = Config::get('upload.path').'/uploads'.$fileArr['url'];
        Loader::import('PHPExcel.Classes.PHPExcel');
        Loader::import('PHPExcel.Classes.PHPExcel.IOFactory.PHPExcel_IOFactory');
        $objPHPExcel = \PHPExcel_IOFactory::load($fileName);
        //获取sheet表数目
        $sheetCount = $objPHPExcel->getSheetCount();
        for ($i = 0;$i < $sheetCount;$i++) {
            self::getOneExcel($objPHPExcel,$i);
        }
        $msg = '导入成功,共导入'.count(self::$userArr).'条数据';
        return ['code'=>1,'msg'=>$msg];
    }
    private function getOneExcel($objPHPExcel,$sheetSelected){
        $objPHPExcel->setActiveSheetIndex($sheetSelected);
        //获取表格行数
        $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();
        //获取表格列数
        $columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
        for ($row = 3; $row <= $rowCount; $row++){
            //列数循环 , 列数是以A列开始
            self::$obj= [];
            for ($column = 'A'; $column <= $columnCount; $column++) {
                $value = $objPHPExcel->getActiveSheet()->getCell($column.$row)->getCalculatedValue();
                $this->handleColumn($column,trim($value));
            }
            $this->handleData();
        }
        //添加员工
        $user = new UserModel();
        $user->saveAll(self::$userArr);
    }

    //采集数据
    private function handleColumn($column,$value){
        switch($column){
            case 'A':
                self::$obj['name'] = $value;
                break;
            case 'B':
                self::$obj['phone'] = $value;
                break;
            case 'C':
                self::$obj['sex'] = $value == '男'?1:2;
                break;
            case 'D':
                if($value){
                    $department = DepartmentModel::get(['name'=>$value,'system_id'=>$this->system_id]);
                    if(empty($department)) $department = DepartmentModel::create(['name'=>$value,'sort'=>20,'system_id'=>$this->system_id]);
                    self::$obj['department_id'] = $department['id'];
                }
                break;
            case 'E':
                if($value){
                    $department = LevelModel::get(['name'=>$value,'system_id'=>$this->system_id]);
                    if(empty($department)) $department = LevelModel::create(['name'=>$value,'sort'=>20,'system_id'=>$this->system_id]);
                    self::$obj['level_id'] = $department['id'];
                }
                break;
            case 'F':
                self::$obj['is_driver'] = $value == '是'?1:0;
                break;
            case 'G':
                self::$obj['is_partner'] = $value == '是'?1:0;
                break;
            case 'H':
                if($value) self::$obj['join_date'] = excelTime($value);
                break;
            default:
                break;
        }
    }

    private function handleData(){
        self::$obj['system_id'] = $this->system_id;
        if(!empty(UserModel::get(self::$obj))) return false;
        self::$obj['create_time'] = date('Y-m-d H:i:s');
        if(empty(self::$maxNum)){
            $user = UserModel::field('max(num) as num')->find();
            if(empty($user['num'])){
                self::$maxNum = '000001';
            }else{
                self::$maxNum =  sprintf('%06s', $user['num'] + 1);
            }
        }else{
            self::$maxNum =  sprintf('%06s', self::$maxNum + 1);
        }
        self::$obj['num'] = self::$maxNum;

        self::$userArr[] = self::$obj;
    }

    //员工详情
    public function userInfo(){
        $data['info'] = UserModel::alias('a')
            ->join('tp_hr_department b','a.department_id = b.id','left')
            ->join('tp_hr_level c','a.level_id = c.id','left')
            ->field('a.*,b.name as department_name,c.name as level_name')
            ->where(['a.id' => $this->id])
            ->find();
        return view('userInfo',$data);
    }

    //渲染驾驶员列表
    public function busUserList(){
        if(empty($this->param['name'])) return ['code'=>0,'data'=>[]];
        $busUserList = UserModel::where(['status'=>1,'is_driver'=>1,'system_id' => $this->system_id,'name'=>['like','%'.$this->param['name'].'%']])->order('num asc')->select();
        if(count($busUserList) == 0) return ['code'=>2,'data'=>$busUserList];
        else return ['code'=>1,'data'=>$busUserList];
    }

    //渲染驾驶员列表
    public function busPartnerList(){
        if(empty($this->param['name'])) return ['code'=>0,'data'=>[]];
        $busPartnerList = UserModel::where(['status'=>1,'is_partner'=>1,'system_id' => $this->system_id,'name'=>['like','%'.$this->param['name'].'%']])->order('num asc')->select();
        if(count($busPartnerList) == 0) return ['code'=>2,'data'=>$busPartnerList];
        else return ['code'=>1,'data'=>$busPartnerList];
    }
}