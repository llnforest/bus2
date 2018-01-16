<?php
//工资控制器
namespace admin\finance\controller;

use admin\finance\model\WagesModel;
use admin\index\controller\BaseController;
use admin\index\controller\Upload;
use admin\persion\model\DepartmentModel;
use admin\persion\model\UserModel;
use think\Config;
use think\Loader;
use think\Request;
use think\Validate;


class Wages extends BaseController{
    private static $obj;
    private static $wagesArr = [];
    private $roleValidate = ['base_wages|基本工资'=>'require|digit','wages_date|发放日期' => 'require'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //工资列表页
    public function index(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['b.name'=>'like','a.wages_date'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name as user_name';
        $data['list'] = WagesModel::alias('a')
                            ->join('tp_hr_user b','a.user_id = b.id','left')
                            ->field($fields)
                            ->where($where)
                            ->order($orderBy)
                            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加工资
    public function wagesAdd(){
        if($this->request->isPost()){
            $param = $this->param;
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($param)) return ['code' => 0, 'msg' => $validate->getError()];
            $param['yingfa'] = $param['base_wages']+$param['jintie']+$param['shebaobutie']+$param['manqin']+$param['gongling']+$param['jiaban']+$param['youxiu']+$param['tuifuzhuang']+$param['qitafa'];
            $param['shifa'] = $param['yingfa']-($param['jiekuan']+$param['queqin']+$param['qingjia']+$param['kuanggong']+$param['chidao']+$param['shebao']+$param['suodeshui']+$param['yajin']+$param['guoshi']+$param['canju']+$param['qitakou']);

            if(WagesModel::create($param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('wages/index')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('wagesAdd');
    }

    //修改工资
    public function wagesEdit(){
        $data['info'] = WagesModel::alias('a')->join('tp_hr_user b','a.user_id = b.id','left')->field('a.*,b.name as user_name')->where(['a.id'=>$this->id])->find();
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $param = $this->param;
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($param)) return ['code' => 0,'msg' => $validate->getError()];
            $param['yingfa'] = $param['base_wages']+$param['jintie']+$param['shebaobutie']+$param['manqin']+$param['gongling']+$param['jiaban']+$param['youxiu']+$param['tuifuzhuang']+$param['qitafa'];
            $param['shifa'] = $param['yingfa']-($param['jiekuan']+$param['queqin']+$param['qingjia']+$param['kuanggong']+$param['chidao']+$param['shebao']+$param['suodeshui']+$param['yajin']+$param['guoshi']+$param['canju']+$param['qitakou']);
            if($data['info']->save($param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('wages/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        return view('wagesEdit',$data);
    }

    // 删除工资
    public function wagesDelete(){
        if($this->request->isPost()) {
            $result = WagesModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('wages/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //选择员工
    public function userSelect(){
        $data['userList'] = UserModel::where(['status' => 1,'system_id'=>$this->system_id])->select();
        $data['id'] = $this->id;
        return view('userSelect',$data);
    }

    //导入用户
    public function importWages(){
        $n = 0;
        for($i = 0;$i<100000000;$i++){
            $n++;
        }
        die;
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
        $msg = '导入成功,共导入'.count(self::$wagesArr).'条数据';
        return ['code'=>1,'msg'=>$msg];
    }
    private function getOneExcel($objPHPExcel,$sheetSelected){
        $objPHPExcel->setActiveSheetIndex($sheetSelected);
        //获取表格行数
        $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();
        //获取表格列数
        $columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
        for ($row = 4; $row <= $rowCount; $row++){
            //列数循环 , 列数是以A列开始
            self::$obj= [];
            for ($column = 'A'; $column <= $columnCount; $column++) {
                $value = $objPHPExcel->getActiveSheet()->getCell($column.$row)->getCalculatedValue();
                if($value) $this->handleColumn($column,trim($value));
            }
            if(empty(self::$obj['user_id'])) continue;
            $this->handleData();
        }
        //添加员工
        $wages = new WagesModel();
        $wages->saveAll(self::$wagesArr);
    }

    //采集数据
    private function handleColumn($column,$value){
        switch($column){
            case 'A':
                $user = UserModel::get(['name'=>$value]);
                if(!empty($user)) self::$obj['user_id'] = $user['id'];
                break;
            case 'B':
                self::$obj['base_wages'] = $value;
                break;
            case 'C':
                self::$obj['jintie'] = $value;
                break;
            case 'D':
                self::$obj['shebaobutie'] = $value;
                break;
            case 'E':
                self::$obj['manqin'] = $value;
                break;
            case 'F':
                self::$obj['gongling'] = $value;
                break;
            case 'G':
                self::$obj['jiaban'] = $value;
                break;
            case 'H':
                self::$obj['qitafa'] = $value;
                break;
            case 'I':
                self::$obj['yingfa'] = $value;
                break;
            case 'J':
                self::$obj['queqin'] = $value;
                break;
            case 'K':
                self::$obj['qingjia'] = $value;
                break;
            case 'L':
                self::$obj['kuanggong'] = $value;
                break;
            case 'M':
                self::$obj['chidao'] = $value;
                break;
            case 'N':
                self::$obj['shebao'] = $value;
                break;
            case 'O':
                self::$obj['suodeshui'] = $value;
                break;
            case 'P':
                self::$obj['jiekuan'] = $value;
                break;
            case 'Q':
                self::$obj['qitakou'] = $value;
                break;
            case 'R':
                self::$obj['shifa'] = $value;
                break;
            case 'S':
                if($value) self::$obj['wages_date'] = excelTime($value);
                else self::$obj['wages_date'] = date('Y-m-01',time());
                break;
            default:
                break;
        }
    }

    private function handleData(){
        self::$obj['system_id'] = $this->system_id;
        if(!empty(WagesModel::get(self::$obj))) return false;
        self::$obj['create_time'] = date('Y-m-d H:i:s',time());
        self::$wagesArr[] = self::$obj;
    }
}