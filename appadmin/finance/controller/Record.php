<?php
//发车单管理
namespace admin\finance\controller;

use admin\bus\model\BusRecordModel;
use admin\bus\model\CorporationModel;
use admin\index\controller\BaseController;
use think\Loader;


class Record extends BaseController{

    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //发车单列表
    public function index(){
        $orderBy  = 'a.update_time desc';
        $where  = getWhereParam(['a.order_id','d.corporation_id','e.order_type','e.type','d.num'=>'like','a.update_time'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name as fir_name,c.name as sec_name,d.num,e.type as money_type,e.order_type,date_format(e.start_date,"%Y-%m-%d %H:%i") as start_time,date_format(e.end_date,"%Y-%m-%d %H:%i") as end_time,f.*,g.name as corporation_name';
        $where['a.status'] = 2;
        $data['corporation'] = CorporationModel::where(['system_id' => $this->system_id,'status'=>1])->order('sort asc')->select();
        $data['list'] = BusRecordModel::alias('a')
//            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
//            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->join('tp_bus d','a.bus_id = d.id','left')
            ->join('tp_bus_order e','a.order_id = e.id','left')
            ->join('tp_bus_order_address f','e.id = f.order_id','left')
            ->join('tp_bus_corporation g','d.corporation_id = g.id','left')
            ->field($fields)
            ->where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //导出发车单
    public function exportOut(){
        $where  = getWhereParam(['a.order_id','d.corporation_id','e.order_type','e.type','d.num'=>'like','a.update_time'=>['start','end']],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $fields = 'a.*,b.name as fir_name,c.name as sec_name,d.num,e.type as money_type,e.order_type,date_format(e.start_date,"%Y-%m-%d %H:%i") as start_time,date_format(e.end_date,"%Y-%m-%d %H:%i") as end_time,f.*,g.name as corporation_name';
        $where['a.status'] = 2;
        $list = BusRecordModel::alias('a')
//            ->join('tp_hr_user b','a.fir_user_id = b.id','left')
//            ->join('tp_hr_user c','a.sec_user_id = c.id','left')
            ->join('tp_bus d','a.bus_id = d.id','left')
            ->join('tp_bus_order e','a.order_id = e.id','left')
            ->join('tp_bus_order_address f','e.id = f.order_id','left')
            ->join('tp_bus_corporation g','d.corporation_id = g.id','left')
            ->field($fields)
            ->where($where)
            ->select();
        Loader::import('PHPExcel.Classes.PHPExcel');
        Loader::import('PHPExcel.Classes.PHPExcel.IOFactory.PHPExcel_IOFactory');
        Loader::import('PHPExcel.Classes.PHPExcel.Reader.Excel2007');
        Loader::import('PHPExcel.Classes.PHPExcel.Writer.Excel2007');
        $objPHPExcel = new \PHPExcel();
        $name = '发车单数据';
        $objPHPExcel->getProperties()->setCreator("汽车管理系统")
            ->setLastModifiedBy("汽车管理系统")
            ->setTitle($name."EXCEL导出")
            ->setSubject($name."EXCEL导出")
            ->setDescription("财务数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        $objPHPExcel->setActiveSheetIndex(0)
            //Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A1', '订单编号')
            ->setCellValue('B1', '车牌号码')
            ->setCellValue('C1', '主驾驶员')
            ->setCellValue('D1', '副驾驶员')
            ->setCellValue('E1', '金额')
            ->setCellValue('F1', '趟数')
            ->setCellValue('G1', '包车类型')
            ->setCellValue('H1', '包车方式')
            ->setCellValue('I1', '用车时间')
            ->setCellValue('J1', '用车线路')
            ->setCellValue('K1', '单位')
            ->setCellValue('L1', '回车时间')
        ;
        foreach ($list as $key => $v) {
            $order_type = '';

            if($v['order_type'] == 1) $order_type = '旅行社用车';
            elseif($v['order_type'] == 2) $order_type = '交通车';
            elseif($v['order_type'] == 3) $order_type = '团车';
            elseif($v['order_type'] == 4) $order_type = '社会用车';

            $objPHPExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValueExplicit('A'.($key+2), $v['order_id'],\PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValue('B'.($key+2), $v['num'])
                ->setCellValue('C'.($key+2), $v['corporation_name'])
//                ->setCellValue('D'.($key+2), $v['sec_name'])
                ->setCellValue('D'.($key+2), $v['money'])
                ->setCellValue('E'.($key+2), $v['times'])
                ->setCellValue('F'.($key+2), $order_type)
                ->setCellValue('G'.($key+2), ($v['money_type'] == 1?'全包':'净价'))
                ->setCellValue('H'.($key+2), $v['start_time'].'~'.$v['end_time'])
                ->setCellValue('I'.($key+2), '起：'.$v['start_prov'].$v['start_city'].$v['start_area'].$v['start_address'].'。 终：'.$v['end_prov'].$v['end_city'].$v['end_area'].$v['end_address'])
                ->setCellValue('J'.($key+2), $v['corporation_name'])
                ->setCellValue('K'.($key+2), $v['update_time'])
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