<?php
//客户控制器
namespace admin\customer\controller;

use admin\bus\model\AccidentModel;
use admin\bus\model\CheckModel;
use admin\bus\model\CustomerModel;
use admin\bus\model\OrderModel;
use admin\finance\model\CustomerFinanceModel;
use admin\index\controller\BaseController;
use admin\index\controller\Upload;
use think\Config;
use think\Loader;
use think\Request;
use think\Validate;


class Customer extends BaseController{
    private static $obj;
    private static $customerArr = [];
    private $roleValidate = ['name|客户名称' => 'require','user_name|客户姓名'=>'require','type|客户类型' => 'require'];//,'phone|联系电话' => 'contact'
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //客户列表页
    public function index(){
        $orderBy  = 'create_time desc';
        $where  = getWhereParam(['name'=>'like','user_type','phone','status','type','create_time'=>['start','end']],$this->param,0);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];

        $data['list'] = CustomerModel::where($where)
                            ->order($orderBy)
                            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加客户
    public function customerAdd(){
        $data['skip_type'] = isset($this->param['skip_type'])?$this->param['skip_type']:'';
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(CustomerModel::create($this->param)){
                $url = $data['skip_type'] == 'order'?'reserve/order/orderAdd':'customer/index';
                return ['code' => 1,'msg' => '添加成功','url' => url($url)];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        return view('customerAdd',$data);
    }

    //修改客户
    public function customerEdit(){
        $data['info'] = CustomerModel::get($this->id);
        if(!$data['info']) $this->error('参数错误');
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            if($data['info']->save($this->param)){
                return ['code' => 1,'msg' => '修改成功','url' => url('customer/index')];
            }else{
                return ['code' => 0,'msg' => '修改失败'];
            }
        }
        return view('customerEdit',$data);
    }

    // 删除客户
    public function customerDelete(){
        if($this->request->isPost()) {
            $result = CustomerModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if(!empty(OrderModel::get(['customer_id'=>$this->id])) || !empty(CustomerFinanceModel::get(['customer_id'=>$this->id]))) return ['code' => 0, 'msg' => '删除失败,该客户已被应用'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('customer/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    // 修改客户状态
    public function editStatus(){
        if($this->request->isPost()){
            $id     = isset($this->param['id'])?$this->param['id']:0;
            $status  = isset($this->param['data'])?$this->param['data']:0;
            $info = new CustomerModel();
            if($info->update(['id'=>$id,'status'=>$status])){
                return ['code' => 1,'msg' => '状态变更成功'];
            }else{
                return ['code' => 0,'msg' => '状态变更失败'];
            }
        }
        return ['code' => 0,'msg' => '请求方式错误'];
    }

    //导入客户
    public function importCustomer(){
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
        $msg = '导入成功,共导入'.count(self::$customerArr).'条数据';
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
        $customer = new CustomerModel();
        $customer->saveAll(self::$customerArr);
    }

    //采集数据
    private function handleColumn($column,$value){
        switch($column){
            case 'A':
                self::$obj['name'] = $value;
                break;
            case 'B':
                self::$obj['user_name'] = $value;
                break;
            case 'C':
                self::$obj['phone'] = $value;
                break;
            case 'D':
                self::$obj['user_type'] = $value == '公司'?1:2;
                break;
            case 'E':
                self::$obj['type'] = str_replace(['合作客户','临时客户','同行'],[1,2,3],$value);
                break;
            default:
                break;
        }
    }

    private function handleData(){
        self::$obj['system_id'] = $this->system_id;
        if(!empty(CustomerModel::get(self::$obj))) return false;
        self::$obj['create_time'] = date('Y-m-d H:i:s');

        self::$customerArr[] = self::$obj;
    }
}