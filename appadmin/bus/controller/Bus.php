<?php
//车辆档案控制器
namespace admin\bus\controller;

use admin\bus\model\BusModel;
use admin\bus\model\BusRecordModel;
use admin\bus\model\BusUserModel;
use admin\bus\model\CorporationModel;
use admin\index\controller\Upload;
use admin\persion\model\DepartmentModel;
use admin\persion\model\UserModel;
use admin\index\controller\BaseController;
use think\Config;
use think\Db;
use think\Loader;
use think\Validate;


class Bus extends BaseController{
    private static $obj;
    private static $busArr = [];
    private $roleValidate = ['num|车牌号码' => 'require','brand|厂牌型号' => 'require','site_num|座位数量' => 'require|digit','fir_user_id|主驾驶员' => 'require'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //车辆档案列表页
    public function index(){
        $orderBy  = 'create_time desc';
        $where  = getWhereParam(['a.num'=>'like','a.type','a.status','a.brand'=>'like','a.engine_code','b.name'=>'like','a.is_bathroom','a.is_tv','a.is_air','a.is_microphone','a.corporation_id','a.department_id','a.create_time'=>['start','end']],$this->param);
        if(!empty($this->param['sec_name'])) $where['c.name'] = ['like','%'.$this->param['sec_name'].'%'];
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name as fir_name,c.name as sec_name,d.name as corporation_name,e.name as department_name';
        $data['list'] = BusModel::alias('a')
                            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
                            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
                            ->join('tp_bus_corporation d','a.corporation_id = d.id','left')
                            ->join('tp_hr_department e','a.department_id = e.id','left')
                            ->field($fields)
                            ->where($where)
                            ->order($orderBy)
                            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['corporation'] = CorporationModel::where(['status'=>1])->order('sort')->select();
        $data['department'] = DepartmentModel::order('sort')->select();
        return view('index',$data);
    }

    //添加车辆档案
    public function busAdd(){
        $data['style'] = isset($this->param['style'])?$this->param['style']:'bus';
        $data['order_id'] = isset($this->param['order_id'])?$this->param['order_id']:'';
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(empty($this->param['is_air'])) $this->param['is_air'] = 0;
            if(empty($this->param['is_tv'])) $this->param['is_tv'] = 0;
            if($bus = BusModel::create($this->param)){
                if(!empty($this->param['bus_user_id'])){
                    $bus_user = explode(',',$this->param['bus_user_id']);
                    $arr = [];
                    foreach($bus_user as $v){
                        $arr[] = ['user_id'=>$v,'bus_id'=>$bus['id'],'system_id'=>$this->system_id];
                    }
                    $busUser = new BusUserModel();
                    $busUser->saveAll($arr);
                }
                if($data['style'] == 'bus') return ['code' => 1,'msg' => '添加成功','url' => url('bus/index')];
                if($data['style'] == 'order_one') return ['code' => 1,'msg' => '添加成功','url' => url('reserve/order/selectBus',['id'=>$this->param['order_id']])];
                if($data['style'] == 'order_any') return ['code' => 1,'msg' => '添加成功','url' => url('reserve/order/selectAnyBus',['id'=>$this->param['order_id']])];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        $data['corporation'] = CorporationModel::where(['status'=>1,'system_id'=>$this->system_id])->order('sort')->select();
        $data['department'] = DepartmentModel::where(['system_id'=>$this->system_id])->order('sort')->select();
        return view('busAdd',$data);
    }

    //修改车辆档案
    public function busEdit(){
        $data['info'] = BusModel::alias('a')
            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->field('a.*,b.name as fir_name,c.name as sec_name')
            ->where(['a.id' => $this->id])
            ->find();
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if(empty($this->param['is_air'])) $this->param['is_air'] = 0;
            if(empty($this->param['is_tv'])) $this->param['is_tv'] = 0;
            if($data['info']->save($this->param)){
                if($this->param['bus_user_id']){
                    $sql = 'select group_concat(user_id) as ids from tp_bus_user where bus_id = '.$this->id.' group by bus_id';
                    $user_arr = Db::query($sql);
                    if(isset($user_arr[0]['ids'])) $user_ids = explode(',',$user_arr[0]['ids']);
                    else $user_ids = [];
                    $new_ids = explode(',',$this->param['bus_user_id']);
                    $new_arr = array_diff($new_ids,$user_ids);
                    $busUser = new BusUserModel();
                    if($new_arr){
                        $arr = [];
                        foreach($new_arr as $v){
                            $arr[] = ['user_id'=>$v,'bus_id'=>$this->id,'system_id'=>$this->system_id];
                        }
                        $busUser->saveAll($arr);
                    }
                    $old_arr = array_diff($user_ids,$new_ids);
                    if($old_arr){
                        foreach($old_arr as $v){
                            BusUserModel::where(['user_id'=>$v,'bus_id'=>$this->id])->update(['status'=>2]);
                        }
                    }
                }
                return ['code' => 1,'msg' => '修改成功','url' => url('bus/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        $user_arr = BusUserModel::alias('a')
            ->join('tp_hr_user b','a.user_id = b.id','left')
            ->where(['a.bus_id' => $this->id,'a.status' => 1])
            ->column('b.name','a.user_id');
        $data['user_name'] = implode(',',$user_arr);
        $data['corporation'] = CorporationModel::where(['status'=>1,'system_id'=>$this->system_id])->order('sort')->select();
        $data['user_ids'] = implode(',',array_keys($user_arr));
        $data['department'] = DepartmentModel::where(['system_id'=>$this->system_id])->order('sort')->select();
        return view('busEdit',$data);
    }

    //选择驾驶员
    public function userSelect(){
        $data['userList'] = UserModel::where(['is_driver' => 1,'status'=>1,'system_id'=>$this->system_id])->select();
        $data['fir'] = isset($this->param['fir'])?$this->param['fir']:'1';//1主驾驶 2为付驾驶
        $data['id'] = $this->id;
        return view('userSelect',$data);
    }

    //选择合伙人
    public function busUserSelect(){
        $data['userList'] = UserModel::where(['is_partner' => 1,'status'=>1,'system_id'=>$this->system_id])->select();
        $data['id'] = explode(',',$this->id);
        return view('busUserSelect',$data);
    }

    //修改状态
    public function busStatus(){
        $data['info'] = BusModel::get($this->id);
        if($this->request->isPost()){
            $result['status'] = $this->param['status'];
            if($data['info']->save($result))
                return ['code'=>1,'msg'=>'状态变更成功'];
            else
                return ['code'=>0,'msg'=>'状态变更失败'];
        }
        return view('busStatus',$data);
    }

    //车辆信息
    public function busInfo(){
        $data['info'] = BusModel::alias('a')
            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->join('tp_bus_corporation d','a.corporation_id = d.id','left')
            ->join('tp_hr_department e','a.department_id = e.id','left')
            ->field('a.*,b.name as fir_name,c.name as sec_name,d.name as corporation_name,e.name as department_name')
            ->where(['a.id' => $this->id])
            ->find();
        $user_arr = BusUserModel::alias('a')
            ->join('tp_hr_user b','a.user_id = b.id','left')
            ->field('b.name')
            ->where(['a.bus_id' => $this->id,'a.status' => 1])
            ->column('b.name');
        $data['user_name'] = implode(',',$user_arr);
        return view('busInfo',$data);
    }

    //用车列表
    public function busList(){
        $orderBy  = 'a.update_time desc';
        $where  = getWhereParam(['a.order_id','d.num'=>'like','a.status','a.create_time'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name as fir_name,c.name as sec_name,d.num';
        $data['list'] = BusRecordModel::alias('a')
            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->join('tp_bus d','a.bus_id = d.id','left')
            ->field($fields)
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('busList',$data);
    }

    //股权列表
    public function busUser(){
        $orderBy  = 'a.bus_id desc';
        $where  = getWhereParam(['b.num'=>'like','c.name'=>'like'],$this->param);
        $where['a.status'] = 1;
        $fields = 'a.*,b.num,c.name';
        $data['list'] = BusUserModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->join('tp_hr_user c','a.user_id = c.id','left')
            ->field($fields)
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('busUser',$data);
    }

    //修改股份比例
    public function editRate(){
        if($this->request->isPost()) {
            $result = BusUserModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            $this->param['data'] = !empty($this->param['data']) ? $this->param['data'] : '';
            $roleValidate = ['data|股份比例' => 'require'];
            $validate = new Validate($roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError(),'text'=>$result['rate']];
            if ($result->save(['rate' => $this->param['data']])) {
                return ['code' => 1, 'msg' => '股份比例更新成功'];
            } else {
                return ['code' => 0, 'msg' => '股份比例更新失败','text'=>$result['rate']];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    // 删除股东
    public function busUserDelete(){
        if($this->request->isPost()) {
            $result = BusUserModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('bus/busUser',$this->param)];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //导入车辆
    public function importBus(){
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
        $msg = '导入成功,共导入'.count(self::$busArr).'条数据';
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
        $bus = new BusModel();
        $bus->saveAll(self::$busArr);
    }

    //采集数据
    private function handleColumn($column,$value){
        switch($column){
            case 'A':
                self::$obj['num'] = $value;
                break;
            case 'B':
                self::$obj['site_num'] = $value;
                break;
            case 'C':
                $corporation = CorporationModel::get(['name'=>$value,'system_id'=>$this->system_id]);
                if(empty($corporation)) $corporation = CorporationModel::create(['name'=>$value,'sort'=>20,'system_id'=>$this->system_id]);
                self::$obj['corporation_id'] = $corporation['id'];
                break;
            case 'D':
                self::$obj['name'] = $value;
                break;
            case 'E':
                self::$obj['phone'] = $value;
                break;
            case 'F':
                if($value == "加盟车")  self::$obj['type'] = 2;
                elseif($value == "外请车")  self::$obj['type'] = 3;
                else  self::$obj['type'] = 1;
                break;
            case 'G':
                if($value) self::$obj['is_air'] = $value == '有'?1:0;
                else self::$obj['is_air'] = 0;
                break;
            case 'H':
                if($value) self::$obj['is_tv'] = $value == '有'?1:0;
                else self::$obj['is_tv'] = 0;
                break;
            case 'I':
                if($value) self::$obj['is_microphone'] = $value == '有'?1:0;
                else self::$obj['is_microphone'] = 0;
                break;
            case 'J':
                if($value) self::$obj['is_bathroom'] = $value == '有'?1:0;
                else self::$obj['is_bathroom'] = 0;
                break;
            default:
                break;
        }
    }

    private function handleData(){
        $bus = BusModel::get(['num' => self::$obj['num'],'system_id'=>$this->system_id]);
        if(!empty($bus)) return false;
        $user = UserModel::get(['name'=>self::$obj['name'],'phone'=>self::$obj['phone'],'system_id'=>$this->system_id]);
        if(self::$obj['type'] == 1){
            if(empty($user)) return false;
        }else{
            $user = UserModel::create(['status'=>3,'name'=>self::$obj['name'],'phone'=>self::$obj['phone'],'system_id'=>$this->system_id]);
        }
        self::$obj['fir_user_id'] = $user['id'];
        self::$obj['create_time'] = date('Y-m-d H:i:s');
        self::$obj['system_id'] = $this->system_id;
        self::$busArr[] = self::$obj;
    }

    //导入股东
    public function importBusUser(){
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
            self::getUserExcel($objPHPExcel,$i);
        }
        $msg = '导入成功,共导入'.count(self::$busArr).'条数据';
        return ['code'=>1,'msg'=>$msg];
    }
    private function getUserExcel($objPHPExcel,$sheetSelected){
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
                $this->handleUserColumn($column,trim($value));
            }
            $this->handleUserData();
        }
        //添加员工
        $bus = new BusUserModel();
        $bus->saveAll(self::$busArr);
    }

    //采集数据
    private function handleUserColumn($column,$value){
        switch($column){
            case 'A':
                self::$obj['num'] = $value;
                break;
            case 'B':
                self::$obj['name'] = $value;
                break;
            case 'C':
                self::$obj['rate'] = $value;
                break;
            default:
                break;
        }
    }

    //处理股东数据
    private function handleUserData(){
        self::$obj['system_id'] = $this->system_id;
        $bus = BusModel::get(['num'=>self::$obj['num']]);
        $user = UserModel::get(['name'=>self::$obj['name']]);
        if(empty($user) || empty($bus)) return false;
        self::$obj['user_id'] = $user['id'];
        self::$obj['bus_id'] = $bus['id'];
        unset(self::$obj['num']);
        unset(self::$obj['name']);
        $bus_user = BusUserModel::get(['user_id' => $user['id'],'bus_id' => $bus['id'],'status' => 1]);
        if(!empty($bus_user)){
            $bus_user->save(['rate' => self::$obj['rate']]);
        }else{
            self::$busArr[] = self::$obj;
        }
    }
}