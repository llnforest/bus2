<?php
//客户账单控制器
namespace admin\finance\controller;

use admin\bus\model\AccidentModel;
use admin\bus\model\CheckModel;
use admin\bus\model\CustomerModel;
use admin\bus\model\OrderModel;
use admin\finance\model\CustomerFinanceModel;
use admin\index\controller\BaseController;
use think\Db;
use think\Loader;
use think\Request;
use think\Validate;


class Customer extends BaseController{
    private $roleValidate = ['customer_id|客户' => 'require','money|还款金额' => 'require|digit'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //客户总账列表页
    public function index(){
        $orderBy  = 'b.create_time desc';
        $where  = getWhereParam(['b.name'=>'like','b.phone','b.status','b.type'],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $lend_sql = CustomerFinanceModel::field('customer_id,sum(money) as lend_money,0 as back_money,system_id')->where(['type' => 1])->group('customer_id')->buildSql();
        $back_sql = CustomerFinanceModel::field('customer_id,0 as lend_money,sum(money) as back_money,system_id')->where(['type' => 2])->group('customer_id')->buildSql();

        $data['list'] = Db::table(["({$lend_sql} union {$back_sql})" => 'a'])
                        ->join('tp_bus_customer b','a.customer_id = b.id','left')
                        ->field('b.*,sum(a.lend_money) as lend_money,sum(a.back_money) as back_money,sum(a.lend_money - a.back_money) as total_money')
                        ->where($where)
                        ->group('customer_id')
                        ->order($orderBy)
                        ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //客户账单列表页
    public function customerList(){
        $orderBy  = 'create_time desc';
        $where  = getWhereParam(['b.name'=>'like','a.ustomer_id','a.type','a.add_date'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];

        $data['list'] = CustomerFinanceModel::alias('a')
            ->join('tp_bus_customer b','a.customer_id = b.id','left')
            ->field('a.*,b.name')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('customerList',$data);
    }

    //添加客户账单
    public function customerAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            if(CustomerFinanceModel::create($this->param)){
                return ['code' => 1,'msg' => '添加成功','url' => url('customer/customerList')];
            }else{
                return ['code' => 0,'msg' => '添加失败'];
            }
        }
        if($this->id){
            $data['info'] = CustomerModel::get($this->id);
        }
        $data['info']['add_date'] = date('Y-m-d',time());
        return view('customerAdd',$data);
    }

    // 删除客户账单
    public function customerDelete(){
        if($this->request->isPost()) {
            $result = CustomerFinanceModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('customer/index')];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //选择客户
    public function customerSelect(){
        $data['customerList'] = CustomerModel::where(['status' => 1,'system_id'=>$this->system_id])->select();
        return view('customerSelect',$data);
    }

    //导出调度
    public function exportOut(){
        $where  = getWhereParam(['b.name'=>'like','b.phone','b.status','b.type'],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $lend_sql = CustomerFinanceModel::field('customer_id,sum(money) as lend_money,0 as back_money,system_id')->where(['type' => 1])->group('customer_id')->buildSql();
        $back_sql = CustomerFinanceModel::field('customer_id,0 as lend_money,sum(money) as back_money,system_id')->where(['type' => 2])->group('customer_id')->buildSql();

        $list = Db::table(["({$lend_sql} union {$back_sql})" => 'a'])
            ->join('tp_bus_customer b','a.customer_id = b.id','left')
            ->field('b.*,sum(a.lend_money) as lend_money,sum(a.back_money) as back_money,sum(a.lend_money - a.back_money) as total_money')
            ->where($where)
            ->group('customer_id')
            ->select();

        Loader::import('PHPExcel.Classes.PHPExcel');
        Loader::import('PHPExcel.Classes.PHPExcel.IOFactory.PHPExcel_IOFactory');
        Loader::import('PHPExcel.Classes.PHPExcel.Reader.Excel2007');
        Loader::import('PHPExcel.Classes.PHPExcel.Writer.Excel2007');
        $objPHPExcel = new \PHPExcel();
        $name = '客户账单数据';
        $objPHPExcel->getProperties()->setCreator("汽车管理系统")
            ->setLastModifiedBy("汽车管理系统")
            ->setTitle($name."EXCEL导出")
            ->setSubject($name."EXCEL导出")
            ->setDescription("订单数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        $objPHPExcel->setActiveSheetIndex(0)
            //Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A1', '客户名称')
            ->setCellValue('B1', '联系电话')
            ->setCellValue('C1', '状态')
            ->setCellValue('D1', '类型')
            ->setCellValue('E1', '欠账')
            ->setCellValue('F1', '还账')
            ->setCellValue('G1', '总账')
        ;
        foreach ($list as $key => $v) {
            $status = $order_type = '';
            if($v['status'] == 1) $status = '正常';
            else $status = '禁用';

            if($v['type'] == 1) $order_type = '合作客户';
            elseif($v['type'] == 2) $order_type = '临时客户';

            $objPHPExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValue('A'.($key+2), $v['name'])
                ->setCellValue('B'.($key+2), $v['phone'])
                ->setCellValue('C'.($key+2), $status)
                ->setCellValue('D'.($key+2), $order_type)
                ->setCellValue('E'.($key+2), $v['lend_money'])
                ->setCellValue('F'.($key+2), $v['back_money'])
                ->setCellValue('G'.($key+2), $v['total_money'])
            ;
        }
        $name = $name.time();

        $objPHPExcel->getActiveSheet()->setTitle('User');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}