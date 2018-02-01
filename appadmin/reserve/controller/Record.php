<?php
//调度控制器
namespace admin\reserve\controller;

use admin\bus\model\BusModel;
use admin\bus\model\BusRecordFollowModel;
use admin\bus\model\BusRecordModel;
use admin\bus\model\OrderModel;
use admin\finance\model\CustomerFinanceModel;
use admin\index\controller\BaseController;
use think\Loader;
use think\Request;
use think\Validate;


class Record extends BaseController{

    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //调度列表
    public function index(){
        $orderBy  = 'a.status asc,a.update_time desc';
        $where  = getWhereParam(['a.order_id','e.order_type','d.num'=>'like','a.status','a.create_time'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name as fir_name,c.name as sec_name,d.num,e.order_type';
        $data['list'] = BusRecordModel::alias('a')
            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->join('tp_bus d','a.bus_id = d.id','left')
            ->join('tp_bus_order e','a.order_id = e.id','left')
            ->field($fields)
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $this->param['style'] = isset($this->param['style'])?$this->param['style']:0;
        return view('index',$data);
    }

    //接单出发
    public function editReceive(){
        if($this->request->isPost()){
            $data['info'] = BusRecordModel::get($this->id);
            if(!$data['info']) return ['code' => 0,'msg' => '参数错误'];;
            if($data['info']->save(['status'=>1,'start_date'=>date('Y-m-d',time())])){
                return ['code' => 1,'msg' => '车辆已接单出发','url' => url('record/index',$this->param)];
            }else{
                return ['code' => 0,'msg' => '操作失败'];
            }
        }
    }

    //回车
    public function editBack(){
        if($this->request->isPost()){
            $data['info'] = BusRecordModel::get($this->id);
            if(!$data['info'] || $data['info']['status'] != 1) return ['code' => 0,'msg' => '参数错误'];;
            if($data['info']->save(['status'=>2])){
                if(empty(BusRecordModel::get(['order_id' => $data['info']['order_id'],'status' => ['neq',2]]))){
                    $info = OrderModel::alias('a')
                        ->join('tp_bus_customer b','a.customer_id = b.id','left')
                        ->field('a.*,b.type as customer_type')
                        ->where(['a.id'=>$data['info']['order_id']])
                        ->find();
                    $result = ['status' => 2];
                    if(in_array($info['order_type'],[2,3])){//团车、交通车统计价格
                        $money = BusRecordModel::field('sum(money) as total_money,sum(number) as total_number')->where(['order_id'=>$data['info']['order_id']])->find();
                        $result['num'] = $money['total_number'];
                        $result['total_money'] = $money['total_money'];
                    }
                    OrderModel::where(['id'=>$data['info']['order_id']])->update($result);
                    return ['code' => 1,'msg' => "已回车，交易完成",'url' => url('record/index',$this->param)];
                }
                return ['code' => 1,'msg' => "已回车",'url' => url('record/index',$this->param)];
            }else{
                return ['code' => 0,'msg' => '操作失败'];
            }
        }
    }

    //取消接单
    public function editOff(){
        if($this->request->isPost()){
            $data['info'] = BusRecordModel::get($this->id);
            if(!$data['info']) return ['code' => 0,'msg' => '参数错误'];;
            if($data['info']->save(['status'=>3])){
                OrderModel::where(['id' => $data['info']['order_id']])->update(['status' => 0]);
                return ['code' => 1,'msg' => '车辆已取消,订单请重新派单','url' => url('record/index',$this->param)];
            }else{
                return ['code' => 0,'msg' => '操作失败'];
            }
        }
    }

    // 删除调度
    public function recordDelete(){
        if($this->request->isPost()) {
            $result = BusRecordModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => '参数错误'];
            if ($result->delete()) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('record/index',$this->param)];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //调度统计
    public function recordStatistics(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['b.num'=>'like','a.status'=>'in','a.create_time'=>['start','end']],$this->param);
        if(empty($this->param['status'])) $where['a.status'] = ['in','0,1,2'];
        $fields = 'count(a.id) as total_times,sum(a.money) as total_money,a.create_time,b.num,a.bus_id';
        $data['list'] = BusRecordModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->field($fields)
            ->where($where)
            ->group('a.bus_id')
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('recordStatistics',$data);
    }

    //调度备注
    function recordFollow(){
        if(empty($this->id)) $this->error('参数错误');
        $data['list'] = BusRecordFollowModel::alias('a')
            ->join('tp_admin b','a.admin_id = b.id','left')
            ->where(['a.record_id' => $this->id])
            ->field('a.id,a.record_id,a.remarks,a.create_time,b.nick_name')
            ->order('create_time desc')
            ->select();
        $data['info'] = BusRecordModel::alias('a')->join('tp_bus b','a.bus_id = b.id','left')->field('a.*,b.num')->where(['a.id'=>$this->id])->find();
        return view('recordFollow',$data);
    }

    //添加备注
    function followAdd(){
        if($this->request->isPost()) {
            $remarks = isset($this->param['remarks']) ? $this->param['remarks'] : '';
            if (empty($remarks) || empty($this->id)) return ['code' => 0, 'msg' => '必须填写备注内容'];
            if (BusRecordFollowModel::create(['record_id' => $this->id, 'admin_id' => $this->uid, 'remarks' => $remarks])) {
                return ['code' => 1, 'msg' => '添加成功', 'url' => url('record/recordFollow',['id'=>$this->id])];
            } else {
                return ['code' => 0, 'msg' => '添加失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //删除备注
    function followDelete(){
        if($this->request->isPost()) {
            if (empty($this->id) || !isset($this->param['record_id'])) return ['code' => 0, 'msg' => '参数错误'];
            if (BusRecordFollowModel::destroy(['id' => $this->id])) {
                return ['code' => 1, 'msg' => '删除成功', 'url' => url('record/recordFollow',['id'=>$this->param['record_id']])];
            } else {
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //修改数据
    public function  editDatas(){
        if($this->request->isPost()) {
            $data  = isset($this->param['data'])?intval($this->param['data']):'';
            $result = BusRecordModel::get($this->id);
            if($this->param['type'] == 1){
                $old = $result['times'];
                $arr = ['times' => $data];
                $text = '趟数已更新';
            }elseif($this->param['type'] == 2){
                $old = $result['km'];
                $arr = ['km' => $data];
                $text = '公里数已更新';
            }elseif($this->param['type'] == 3){
                $old = $result['number'];
                $arr = ['number' => $data];
                $text = '人数已更新';
            }else{
                $old = $result['money'];
                $arr = ['money' => $data];
                $text = '金额已更新';
            }
            $roleValidate = ['data|数据' => 'require|digit'];
            $validate = new Validate($roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError(),'text'=>$old];
            if(empty($result)){
                return ['code'=>0,'msg'=>'没有数据'];
            }else if ($result) {
                if ($result->save($arr)) {
                    return ['code' => 1, 'msg' => $text];
                }
            }
            return ['code'=>0,'msg'=>'数据无变化'];
        }
        return ['code'=>0,'msg'=>'请求方式错误'];
    }

    //导出调度
    public function exportOut(){
        $where  = getWhereParam(['a.order_id','e.order_type','d.num'=>'like','a.status','a.create_time'=>['start','end']],$this->param);
        $fields = 'a.*,b.name as fir_name,c.name as sec_name,d.num,e.order_type';
        $list = BusRecordModel::alias('a')
            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->join('tp_bus d','a.bus_id = d.id','left')
            ->join('tp_bus_order e','a.order_id = e.id','left')
            ->field($fields)
            ->where($where)
            ->select();
        Loader::import('PHPExcel.Classes.PHPExcel');
        Loader::import('PHPExcel.Classes.PHPExcel.IOFactory.PHPExcel_IOFactory');
        Loader::import('PHPExcel.Classes.PHPExcel.Reader.Excel2007');
        Loader::import('PHPExcel.Classes.PHPExcel.Writer.Excel2007');
        $objPHPExcel = new \PHPExcel();
        $name = '调度数据';
        $objPHPExcel->getProperties()->setCreator("汽车管理系统")
            ->setLastModifiedBy("汽车管理系统")
            ->setTitle($name."EXCEL导出")
            ->setSubject($name."EXCEL导出")
            ->setDescription("订单数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        $objPHPExcel->setActiveSheetIndex(0)
            //Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A1', '订单编号')
            ->setCellValue('B1', '车牌号码')
            ->setCellValue('C1', '调度状态')
            ->setCellValue('D1', '订单类型')
            ->setCellValue('E1', '主驾驶员')
            ->setCellValue('F1', '副驾驶员')
            ->setCellValue('G1', '出发日期')
            ->setCellValue('H1', '回车日期')
            ->setCellValue('I1', '派车时间')
            ->setCellValue('J1', '调度时间')
            ->setCellValue('K1', '趟数')
            ->setCellValue('L1', '公里')
            ->setCellValue('M1', '人数')
            ->setCellValue('N1', '金额')
        ;
        foreach ($list as $key => $v) {
            $number = $km = $status = $order_type = '';
            if($v['status'] == 0) $status = '待接单';
            elseif($v['status'] == 1) $status = '租用途中';
            elseif($v['status'] == 2) $status = '已回车';
            elseif($v['status'] == 3) $status = '取消接单';

            if($v['order_type'] == 1) $order_type = '普通班次';
            elseif($v['order_type'] == 2) $order_type = '交通车';
            elseif($v['order_type'] == 3) $order_type = '团车';

            if($v['order_type'] != 2) $number = $v['number'];
            if($v['order_type'] == 3) $km = $v['km'];
            $objPHPExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValueExplicit('A'.($key+2), $v['order_id'],\PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValue('B'.($key+2), $v['num'])
                ->setCellValue('C'.($key+2), $status)
                ->setCellValue('D'.($key+2), $order_type)
                ->setCellValue('E'.($key+2), $v['fir_name'])
                ->setCellValue('F'.($key+2), $v['sec_name'])
                ->setCellValue('G'.($key+2), $v['start_date'])
                ->setCellValue('H'.($key+2), $v['end_date'])
                ->setCellValue('I'.($key+2), $v['create_time'])
                ->setCellValue('J'.($key+2), $v['update_time'])
                ->setCellValue('K'.($key+2), $v['times'])
                ->setCellValue('L'.($key+2), $km)
                ->setCellValue('M'.($key+2), $number)
                ->setCellValue('N'.($key+2), $v['money'])
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