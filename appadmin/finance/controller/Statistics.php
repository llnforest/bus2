<?php
//统计控制器
namespace admin\finance\controller;

use admin\bus\model\BusRecordModel;
use admin\bus\model\OrderModel;
use admin\index\controller\BaseController;
use think\Loader;


class Statistics extends BaseController{

    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //统计收款表
    public function inMoney(){
        $orderBy  = 'a.create_time desc';
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $where  = getWhereParam(['a.id','b.phone','b.name'=>'like','b.user_name'=>'like','a.create_time'=>['start','end']],$this->param);
        $data['list'] = OrderModel::alias('a')
            ->join('tp_bus_customer b','a.customer_id = b.id','left')
            ->join('tp_bus_order_address d','a.id = d.order_id','left')
            ->field('a.*,b.name,b.user_name,b.phone,d.start_prov,d.start_city,d.start_area,d.start_address,d.end_prov,d.end_area,d.end_city,d.end_address')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('inMoney',$data);
    }

    //统计付款表
    public function outMoney(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['a.id','b.num'=>'like','a.create_time'=>['start','end']],$this->param);
        $where = array_merge($where,['a.status'=>['neq',3]]);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $data['list'] = BusRecordModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->join('tp_bus_corporation c','b.corporation_id = c.id','left')
            ->join('tp_bus_order_address d','a.order_id = d.order_id','left')
            ->field('a.*,b.num,c.name,d.start_prov,d.start_city,d.start_area,d.start_address,d.end_prov,d.end_area,d.end_city,d.end_address')
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('outMoney',$data);
    }

    //导出收款记录
    public function exportInMoney(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['a.id','b.phone','b.name'=>'like','b.user_name'=>'like','a.create_time'=>['start','end']],$this->param);
        $list = OrderModel::alias('a')
            ->join('tp_bus_customer b','a.customer_id = b.id','left')
            ->join('tp_bus_order_address d','a.id = d.order_id','left')
            ->field('a.*,b.name,b.user_name,b.phone,d.start_prov,d.start_city,d.start_area,d.start_address,d.end_prov,d.end_area,d.end_city,d.end_address')
            ->where($where)
            ->order($orderBy)
            ->select();
        Loader::import('PHPExcel.Classes.PHPExcel');
        Loader::import('PHPExcel.Classes.PHPExcel.IOFactory.PHPExcel_IOFactory');
        Loader::import('PHPExcel.Classes.PHPExcel.Reader.Excel2007');
        Loader::import('PHPExcel.Classes.PHPExcel.Writer.Excel2007');
        $objPHPExcel = new \PHPExcel();
        $name = '收款统计数据';
        $objPHPExcel->getProperties()->setCreator("汽车管理系统")
            ->setLastModifiedBy("汽车管理系统")
            ->setTitle($name."EXCEL导出")
            ->setSubject($name."EXCEL导出")
            ->setDescription("收款统计数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        $objPHPExcel->setActiveSheetIndex(0)
            //Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A1', '系统编号')
            ->setCellValue('B1', '客户')
            ->setCellValue('C1', '行程')
            ->setCellValue('D1', '路线')
            ->setCellValue('E1', '合同金额')
            ->setCellValue('F1', '现收金额')
            ->setCellValue('G1', '队收金额')
            ->setCellValue('H1', '未收金额')
            ->setCellValue('I1', '备注')
        ;
        foreach ($list as $key => $v) {
            $weishou = $weishou = $v['total_money'] - $v['duishou'] - $v['xianshou'];
            $objPHPExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValueExplicit('A'.($key+2), $v['id'],\PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValue('B'.($key+2), $v['name'].'/'.$v['user_name'].'/'.$v['phone'])
                ->setCellValue('C'.($key+2), '出发:'.date_format(date_create($v['start_date']),'Y-m-d H:i').' 结束:'.date_format(date_create($v['end_date']),'Y-m-d H:i'))
                ->setCellValue('D'.($key+2), '起：'.$v['start_prov'].$v['start_city'].$v['start_area'].$v['start_address'].'。 终：'.$v['end_prov'].$v['end_city'].$v['end_area'].$v['end_address'])
                ->setCellValue('E'.($key+2), $v['total_money'])
                ->setCellValue('F'.($key+2), $v['xianshou'])
                ->setCellValue('G'.($key+2), $v['duishou'])
                ->setCellValue('H'.($key+2), $weishou)
                ->setCellValue('I'.($key+2), $v['remark'])
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
    //导出收款记录
    public function exportOutMoney(){
        $orderBy  = 'a.create_time desc';
        $where  = getWhereParam(['a.id','b.num'=>'like','a.create_time'=>['start','end']],$this->param);
        $where = array_merge($where,['a.status'=>['neq',3]]);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $list = BusRecordModel::alias('a')
            ->join('tp_bus b','a.bus_id = b.id','left')
            ->join('tp_bus_corporation c','b.corporation_id = c.id','left')
            ->join('tp_bus_order_address d','a.order_id = d.order_id','left')
            ->field('a.*,b.num,c.name,d.start_prov,d.start_city,d.start_area,d.start_address,d.end_prov,d.end_area,d.end_city,d.end_address')
            ->where($where)
            ->order($orderBy)
            ->select();
        Loader::import('PHPExcel.Classes.PHPExcel');
        Loader::import('PHPExcel.Classes.PHPExcel.IOFactory.PHPExcel_IOFactory');
        Loader::import('PHPExcel.Classes.PHPExcel.Reader.Excel2007');
        Loader::import('PHPExcel.Classes.PHPExcel.Writer.Excel2007');
        $objPHPExcel = new \PHPExcel();
        $name = '付款统计数据';
        $objPHPExcel->getProperties()->setCreator("汽车管理系统")
            ->setLastModifiedBy("汽车管理系统")
            ->setTitle($name."EXCEL导出")
            ->setSubject($name."EXCEL导出")
            ->setDescription("付款统计数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        $objPHPExcel->setActiveSheetIndex(0)
            //Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A1', '系统编号')
            ->setCellValue('B1', '车牌号码')
            ->setCellValue('C1', '车辆归属')
            ->setCellValue('D1', '路线')
            ->setCellValue('E1', '公里数')
            ->setCellValue('F1', '趟数')
            ->setCellValue('G1', '付款金额')
            ->setCellValue('H1', '现收金额')
            ->setCellValue('I1', '税款')
            ->setCellValue('J1', '未付')
        ;
        foreach ($list as $key => $v) {
            $weifu = $v['pay_money'] - $v['xianshou'] - $v['taxation'];
            $objPHPExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValueExplicit('A'.($key+2), $v['id'],\PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValue('B'.($key+2), $v['num'])
                ->setCellValue('C'.($key+2), $v['name'])
                ->setCellValue('D'.($key+2), '起：'.$v['start_prov'].$v['start_city'].$v['start_area'].$v['start_address'].'。 终：'.$v['end_prov'].$v['end_city'].$v['end_area'].$v['end_address'])
                ->setCellValue('E'.($key+2), $v['km'])
                ->setCellValue('F'.($key+2), $v['times'])
                ->setCellValue('G'.($key+2), $v['pay_money'])
                ->setCellValue('H'.($key+2), $v['xianshou'])
                ->setCellValue('I'.($key+2), $v['taxation'])
                ->setCellValue('J'.($key+2), $weifu)
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