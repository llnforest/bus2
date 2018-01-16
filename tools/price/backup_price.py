#!/usr/bin/env python
#coding=gb2312

import MySQLdb
import time,datetime
import ConfigParser

def get_cur_time():
    return time.strftime('%Y-%m-%d %H:%M:%S',time.localtime(time.time()))
class CPriceData:
    def __init__(self, date_str):
        self.model_id = 0
        self.price = 0
        self.store_price = 0
        self.date_str = date_str
        
    def getInsertParam(self):
        cur_time = get_cur_time();
        return [self.model_id, self.price, self.store_price, self.date_str]

class outLog:
    def printbegin(self):
        print "Begin Time :"+get_cur_time();
    def printend(self):
        print "End Time :"+get_cur_time();
        
class CStatManager:
    def __init__(self):
        self._log = outLog();
        cf = ConfigParser.ConfigParser()
        cf.read("shijia.conf")
        self._conn_order = MySQLdb.connect(host=cf.get("db","db_host"),
                                     port=int(cf.get("db","db_port")),
                                     user=cf.get("db","db_user"),
                                     passwd=cf.get("db","db_pass"),
                                     db=cf.get("db","db_database"))
        if(self._conn_order != None):
            print "Connect to log DB is ok!\n\r"
        else:
            print "Connect to log DB failed!\n\r"
        # self._test_uid = cf.get("test","uid")
        # self._remdup_extra_fields = cf.get("statistic", "remdup_extra_fields")
        # if "" != self._remdup_extra_fields:
        #     self._remdup_extra_fields = ","+self._remdup_extra_fields
        # self._imei_unique_lifecycle = cf.get("statistic", "imei_unique_lifecycle")
            
    def set_date(self, date,end_date,when):
        self._date = date
        self._when = when
        self._end_date = end_date
        self._profit = 0.05;

    def destory_conn(self):
        self._conn_order.close();
        
    def do_stat(self):
        print "Statistic date: %s" % self._date;
        print "Statistic end_date: %s" % self._end_date;
        # self.__do_operate_slave("stop")
        # self.__do_create_recevie_log()



        self.__do_handel_time()
        self.__do_phone_price_day()



        # self.__do_order_day_stat()
        # self.__do_operate_slave("start")
    
    def __do_handel_time(self):        
        self.tomorrow = time.strftime('%Y%m%d',time.localtime(time.time()+24*3600))
        self.yestoday = time.strftime('%Y%m%d',time.localtime(time.time()-self._when*24*3600))               
   
    def __do_operate_slave(self,operate):
        print "__do_operate_slave"
        sql = operate + " slave"
        cursor = self._conn_os.cursor()
        cursor.execute(sql)
        self._conn_os.commit()

   
    def __do_phone_price_day(self):
        print ("#PHONE DAY STAT begin...#")
        self._phone_day_stat_result_map = {}
        self.__calc_phone_day_price_data(self._date)
        ret = self.__save_phone_day_price_data()
        if(ret == None):
           ret=0
        print ("###PHONE DAY STAT ... SAVA DATE : %d" % (ret))      
    def __calc_phone_day_price_data(self,date_str):
        self.__calc_phone_day_price(date_str)
        self.__calc_phone_day_store_price(date_str)

    def __calc_phone_day_price(self, date_str):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_price:"
        sql ="select id,profit,store_profit,price,lowprice from tp_phone_model group by id"
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, "price")
        self._log.printend();
    def __calc_phone_day_store_price(self, date_str):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_store_price: "
        sql ="select a.id,b.profit,b.store_profit,a.price,b.lowprice from tp_phone_model b left join (select model_id as id,max(price) as price from tp_phone_store_price group by model_id) as a on b.id = a.id "
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, "store_price")
        self._log.printend();
   
    def __exec_phone_sql_and_get_multi_result(self, sql, date_str, tbl_name):
        print sql
        cursor = self._conn_order.cursor()
        cursor.execute(sql)
        cds = cursor.fetchall()
        for i in range(len(cds)):
            if(len(cds[i]) != 5):
                continue;
            model_id = cds[i][0]
            if(model_id == None):
                continue;
            profit = cds[i][1]
            store_profit = cds[i][2]
            price = cds[i][3]
            lowprice = cds[i][4]
            print model_id;
            key = str(date_str)+'-'+str(model_id);
            statData = self._phone_day_stat_result_map.get(key);
            if(statData == None):
                statData = CPriceData(date_str)
                statData.model_id = model_id
            if(tbl_name == "price"):
                statData.price = self.profitPrice(price,lowprice)
            elif(tbl_name == "store_price"):
                statData.store_price = price
            
            self._phone_day_stat_result_map.update({key:statData})
        cursor.close()
    def profitPrice(self,price,lowprice):
        profit = price*self._profit;
        if(profit > 50):
            price = price-50;
        elif(profit < 10):
            price = price-10;
        else:
            price = price-profit;
        if(price < lowprice):
            price = lowprice;
        return int(price);

    def __save_phone_day_price_data(self):
        print "Begin __save_phone_day_price_data"
        cursor = self._conn_order.cursor()
        for key in self._phone_day_stat_result_map.keys():
            # print key;
            statData = self._phone_day_stat_result_map[key]
            self.__save_single_phone_day_stat_data(statData, cursor);
        self._conn_order.commit()
        cursor.close()
        return 0    
    def __save_single_phone_day_stat_data(self, statData, cursor):
        sql = "select sum(1) from tp_statistics_phone_price where to_days(date)=to_days('%s')  and model_id = %s " % (statData.date_str,statData.model_id);
        print sql
        cursor.execute(sql)
        cds = cursor.fetchone()
        # print cds;
        if cds[0] <= 0:
            sql = "insert into tp_statistics_phone_price(model_id,price,store_price, date) values(%s,%s,%s,%s)"
            param = []
            print statData.getInsertParam()
            param.append(statData.getInsertParam())
            print sql, param
            ret = cursor.executemany(sql,param)
        else:
            sql = "update tp_statistics_phone_price set price=%s,store_price=%s where to_days(date)=to_days('%s') and model_id = %s " % (statData.price, statData.store_price,statData.date_str,statData.model_id);
            print sql
            ret = cursor.execute(sql)
        return ret
if __name__ == "__main__":
    date_str = datetime.date.today() - datetime.timedelta(days=1)
    stat = CStatManager(date_str)
    stat.do_stat()