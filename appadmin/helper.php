<?php
    //搜索时的条件
    function getWhereParam($search,$param,$type = 1){
        if($type == 1) $where['a.system_id'] = $param['system_id'];
        elseif($type == 2) $where = [];
        else $where['system_id'] = $param['system_id'];
        foreach($search as $k => $v){
            if(is_numeric($k)){
                $true_name = getTrueName($v);
                if(!isset($param[$true_name]) || $param[$true_name] === '') continue;
                $where[$v] = $param[$true_name];
            }else{
                if(is_array($v)){//是数组：比较两者之间的大小
                    $start = getTrueName($v[0]);
                    $end = getTrueName($v[1]);
                    $is_time = strpos($k,'time');//判断是否是带有分秒的时间
                    if(!empty($param[$start])){
                        if(!empty($param[$end])){
                            if($is_time !== false) $end = date('Y-m-d H:i:s',strtotime($param[$end])+(24*3600)-1);
                            else $end = $param['end'];
                            $where[$k]  = array('between time',array($param[$start],$end));
                        }else{
                            $where[$k]  = array('>=',$param[$start]);
                        }
                    }else{
                        if(!empty($param[$end])){
                            if($is_time !== false) $end = date('Y-m-d H:i:s',strtotime($param[$end])+(24*3600)-1);
                            $where[$k]  = array('<=',$end);
                        }
                    }
                }else{//字符串
                    $true_name = getTrueName($k);
                    if(!isset($param[$true_name]) || $param[$true_name] === '') continue;
                    if(in_array($v,['like','NOT LIKE'])) $where[$k] = [$v,"%{$param[$true_name]}%"];
                    elseif(in_array($v,['in','not in'])) $where[$k] = [$v,$param[$true_name]];
                }
            }
        }
        return $where;
    }

    function getTrueName($name){
        if(strpos($name,'.') !== false){
            $name = explode('.',$name)[1];
        }
        return $name;
    }

    //获取使用年数
    function getYearNum($start_date){
        if(!$start_date) return '';
        $end_date = date('Y-m-d',time());
        $startArr = explode('-',$start_date);
        $endArr = explode('-',$end_date);
        if($endArr[2] - $startArr[2] <= 0) $startArr[1] ++;
        if($endArr[1] - $startArr[1] <= 0) $endArr[0] ++;
        $year = $endArr[0] - $startArr[0];
        return $year;
    }

    //转换excel时间
    function excelTime($date) {
        if (function_exists('GregorianToJD')) {
            if (is_numeric($date)) {
                $jd = GregorianToJD(1, 1, 1970);
                $gregorian = JDToGregorian($jd + intval($date) - 25569);
                $date = explode('/', $gregorian);
                $date_str = str_pad($date[2], 4, '0', STR_PAD_LEFT) . "-" . str_pad($date[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($date[1], 2, '0', STR_PAD_LEFT);
                return $date_str;
            }
        } else {
            $date = $date > 25568 ? $date + 1 : 25569; /*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/
            $ofs = (70 * 365 + 17 + 2) * 86400;
            $date = date("Y-m-d", ($date * 86400) - $ofs);
        }
        return $date;
    }
?>