#!/usr/bin/env python
#coding=gb2312

import MySQLdb
import time,datetime
import ConfigParser

def get_cur_time():
    return time.strftime('%Y-%m-%d %H:%M:%S',time.localtime(time.time()))
class CStatData:
    def __init__(self, date_str):
        self.user_id = 0
        self.assessment = 0
        self.recovery_assessment = 0
        self.order_assessment = 0
        self.express_phone = 0
        self.express_money = 0
        self.checking_phone = 0
        self.check_phone = 0
        self.deal_phone = 0
        self.deal_money = 0
        self.back_phone = 0
        self.date_str = date_str
        
    def getInsertParam(self):
        cur_time = get_cur_time();
        return [self.user_id, self.assessment, self.recovery_assessment, self.order_assessment ,self.express_phone, self.express_money, self.checking_phone ,self.check_phone ,self.deal_phone,self.deal_money, self.back_phone,  self.date_str, cur_time]
class OrderStatData:
    def __init__(self, date_str):
        self.user_id = 0
        self.creates = 0
        self.express = 0
        self.arrive = 0
        self.checks = 0
        self.over = 0
        self.close = 0
        self.date_str = date_str
        
    def getInsertParam(self):
        cur_time = get_cur_time();
        return [self.user_id, self.creates, self.express, self.arrive ,self.checks ,self.over, self.close,  self.date_str, cur_time]

class SellStatData:
    def __init__(self, date_str):
        self.sell_id = 0
        self.offer = 0
        self.deal = 0
        self.deal_money = 0
        self.date_str = date_str
        
    def getInsertParam(self):
        cur_time = get_cur_time();
        return [self.sell_id, self.offer, self.deal,self.deal_money, self.date_str , cur_time]
class TakeStatData:
    def __init__(self, date_str):
        self.user_id = 0
        self.take = 0
        self.take_out = 0
        self.date_str = date_str
        
    def getInsertParam(self):
        cur_time = get_cur_time();
        return [self.user_id, self.take, self.take_out, self.date_str , cur_time]
            
class UserStatData:
    def __init__(self, date_str):
        self.p_id = 0
        self.c_id = 0
        self.a_id = 0
        self.login = 0
        self.newuser = 0
        self.date_str = date_str
        
    def getInsertParam(self):
        cur_time = get_cur_time();
        return [self.p_id, self.c_id, self.a_id, self.login, self.newuser, self.date_str , cur_time]


        
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
        self._conn_order = MySQLdb.connect(host=cf.get("db_order","db_host"),
                                     port=int(cf.get("db_order","db_port")),
                                     user=cf.get("db_order","db_user"),
                                     passwd=cf.get("db_order","db_pass"),
                                     db=cf.get("db_order","db_database"),
                                     unix_socket=cf.get("db_order","db_unix_socket"))
        if(self._conn_order != None):
            print "Connect to log DB is ok!\n\r"
        else:
            print "Connect to log DB failed!\n\r"
        self._test_uid = cf.get("test","uid")
        # self._remdup_extra_fields = cf.get("statistic", "remdup_extra_fields")
        # if "" != self._remdup_extra_fields:
        #     self._remdup_extra_fields = ","+self._remdup_extra_fields
        # self._imei_unique_lifecycle = cf.get("statistic", "imei_unique_lifecycle")
            
    def set_date(self, date,end_date,when):
        self._date = date
        self._when = when
        self._end_date = end_date

    def destory_conn(self):
        self._conn_order.close();
        
    def do_stat(self):
        print "Statistic date: %s" % self._date;
        print "Statistic end_date: %s" % self._end_date;
        # self.__do_operate_slave("stop")
        # self.__do_create_recevie_log()



        self.__do_handel_time()
        self.__do_phone_day_stat()
        self.__do_sell_day_stat()
        self.__do_take_day_stat()
        self.__do_user_day_stat()



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

   
    def __do_phone_day_stat(self):
        print ("#PHONE DAY STAT begin...#")
        self._phone_day_stat_result_map = {}
        self.__calc_phone_day_stat_data(self._date)
        ret = self.__save_phone_day_stat_data()
        if(ret == None):
           ret=0
        print ("###PHONE DAY STAT ... SAVA DATE : %d" % (ret))      
    def __calc_phone_day_stat_data(self,date_str):
        self.__calc_phone_day_assessment(date_str,"tp_user_assessment")
        self.__calc_phone_day_recovery_assessment(date_str,"tp_user_recovery")
        self.__calc_phone_day_order_assessment(date_str,"tp_user_order_assessment")
        self.__calc_phone_day_express_phone(date_str,"tp_user_order")
        self.__calc_phone_day_checking_phone(date_str,"tp_user_order")
        self.__calc_phone_day_check_phone(date_str,"tp_user_order_testing")
        self.__calc_phone_day_deal_phone(date_str,"tp_user_order_assessment")
        self.__calc_phone_day_deal_money(date_str,"tp_user_order_assessment")
        self.__calc_phone_day_back_phone(date_str,"tp_user_order_assessment")
        self.__calc_phone_day_express_money(date_str,"tp_user_order")
        # self.__calc_res_day_log_need_groupby(date_str,self.res_requestlog_table_name)
        # self.__calc_res_day_receive_log(date_str)
        # self.__calc_res_day_pushshow_log(date_str)
    def __calc_phone_day_assessment(self, date_str, tbl_name):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_assessment: (table: %s)" % (tbl_name)
        sql ="select sum(1),user_id from %s where create_time between \'%s\' and \'%s\' and user_id not in (%s) group by user_id" % (tbl_name, date_str,self._end_date,self._test_uid)
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, tbl_name)
        self._log.printend();
    def __calc_phone_day_recovery_assessment(self, date_str, tbl_name):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_recovery_assessment: (table: %s)" % (tbl_name)
        sql ="select sum(1),user_id from %s where create_time between \'%s\' and \'%s\' and user_id not in (%s) group by user_id " % (tbl_name, date_str,self._end_date,self._test_uid)
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, tbl_name)
        self._log.printend();
    def __calc_phone_day_order_assessment(self, date_str, tbl_name):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_order_assessment: (table: %s)" % (tbl_name)
        sql ="select sum(1),user_id from %s where create_time between \'%s\' and \'%s\' and user_id not in (%s) group by user_id " % (tbl_name, date_str,self._end_date,self._test_uid)
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, tbl_name)
        self._log.printend();
    def __calc_phone_day_express_phone(self, date_str, tbl_name):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_express_phone: (table: %s)" % (tbl_name)
        sql ="select sum(1),user_id from (select b.id,a.user_id from %s a left join tp_user_order_assessment b on a.id = b.order_id where a.express_time between \'%s\' and \'%s\' and a.user_id not in (%s) group by b.id) as tmp group by user_id " % (tbl_name, date_str,self._end_date,self._test_uid)
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, 'express')
        self._log.printend();
    def __calc_phone_day_checking_phone(self, date_str, tbl_name):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_checking_phone: (table: %s)" % (tbl_name)
        sql ="select sum(1),user_id from (select b.id,a.user_id from %s a left join tp_user_order_assessment b on a.id = b.order_id where a.arrive_time between \'%s\' and \'%s\' and a.user_id not in (%s) group by b.id) as tmp group by user_id " % (tbl_name, date_str,self._end_date,self._test_uid)
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, 'checking')
        self._log.printend();
    def __calc_phone_day_check_phone(self, date_str, tbl_name):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_check_phone: (table: %s)" % (tbl_name)
        sql ="select sum(1),user_id from (select b.id,b.user_id from %s a left join tp_user_order_assessment b on a.order_a_id = b.id where a.create_time between \'%s\' and \'%s\' and b.user_id not in (%s) group by b.id) as tmp group by user_id " % (tbl_name, date_str,self._end_date,self._test_uid)
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, 'check')
        self._log.printend();
    def __calc_phone_day_deal_phone(self, date_str, tbl_name):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_deal_phone: (table: %s)" % (tbl_name)
        sql ="select sum(1),user_id from %s where status in (1,3) and deal_time between \'%s\' and \'%s\' and user_id not in (%s) group by user_id " % (tbl_name, date_str,self._end_date,self._test_uid)
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, 'deal_phone')
        self._log.printend();
    def __calc_phone_day_deal_money(self, date_str, tbl_name):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_deal_money: (table: %s)" % (tbl_name)
        sql ="select sum(recovery_price),user_id from %s where status = 1 and deal_time between \'%s\' and \'%s\' and user_id not in (%s) group by user_id " % (tbl_name, date_str,self._end_date,self._test_uid)
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, 'deal_money')
        self._log.printend();
    def __calc_phone_day_back_phone(self, date_str, tbl_name):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_back_phone: (table: %s)" % (tbl_name)
        sql ="select sum(1),user_id from %s where status = 2 and deal_time between \'%s\' and \'%s\' and user_id not in (%s) group by user_id " % (tbl_name, date_str,self._end_date,self._test_uid)
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, 'back_phone')
        self._log.printend();
    def __calc_phone_day_express_money(self, date_str, tbl_name):
        self._log.printbegin();
        print ">>> Begin __calc_phone_day_express_money: (table: %s)" % (tbl_name)
        sql ="select sum(a.express_money),a.user_id from (select sum(back_express_price)as express_money,user_id from %s where back_time between \'%s\' and \'%s\' and user_id not in (%s) group by user_id Union all select sum(express_price) as express_money,user_id from %s where arrive_time between \'%s\' and \'%s\' and user_id not in (%s) group by user_id) as a where a.express_money > 0 group by a.user_id " % (tbl_name, date_str,self._end_date,self._test_uid,tbl_name, date_str,self._end_date,self._test_uid)
        self.__exec_phone_sql_and_get_multi_result(sql, date_str, 'express_money')
        self._log.printend();
    
    def __exec_phone_sql_and_get_multi_result(self, sql, date_str, tbl_name):
        print sql
        cursor = self._conn_order.cursor()
        cursor.execute(sql)
        cds = cursor.fetchall()
        for i in range(len(cds)):
            if(len(cds[i]) != 2):
                continue;
            count = cds[i][0]
            user_id = cds[i][1]
            print user_id;
            key = str(date_str)+'-'+str(user_id);
            statData = self._phone_day_stat_result_map.get(key);
            if(statData == None):
                statData = CStatData(date_str)
                statData.user_id = user_id
            if(tbl_name == "tp_user_assessment"):
                statData.assessment = count
            elif(tbl_name == "tp_user_recovery"):
                statData.recovery_assessment = count
                # statData.assessment = statData.assessment + count
            elif(tbl_name == "tp_user_order_assessment"):
                statData.order_assessment = count
                # statData.assessment = statData.assessment + count
                statData.recovery_assessment = statData.recovery_assessment + count
            elif(tbl_name == "express"):
                statData.express_phone = count
            elif(tbl_name == "checking"):
                statData.checking_phone = count
            elif(tbl_name == "check"):
                statData.check_phone = count
            elif(tbl_name == "deal_phone"):
                statData.deal_phone = count
            elif(tbl_name == "deal_money"):
                statData.deal_money = count
            elif(tbl_name == "back_phone"):
                statData.back_phone = count
            elif(tbl_name == "express_money"):
                statData.express_money = count
            self._phone_day_stat_result_map.update({key:statData})
        cursor.close() 
    def __save_phone_day_stat_data(self):
        print "Begin save_phone_day_stat_data"
        cursor = self._conn_order.cursor()
        for key in self._phone_day_stat_result_map.keys():
            # print key;
            statData = self._phone_day_stat_result_map[key]
            self.__save_single_phone_day_stat_data(statData, cursor);
        self._conn_order.commit()
        cursor.close()
        return 0    
    def __save_single_phone_day_stat_data(self, statData, cursor):
        sql = "select sum(1) from tp_statistics_assessment where to_days(date)=to_days('%s')  and user_id = %s " % (statData.date_str,statData.user_id);
        print sql
        cursor.execute(sql)
        cds = cursor.fetchone()
        # print cds;
        if cds[0] <= 0:
            sql = "insert into tp_statistics_assessment(user_id,assessment,recovery_assessment,order_assessment,express_phone,express_money, checking_phone,check_phone,deal_phone,deal_money,back_phone,date, create_time) values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
            param = []
            print statData.getInsertParam()
            param.append(statData.getInsertParam())
            print sql, param
            ret = cursor.executemany(sql,param)
        else:
            sql = "update tp_statistics_assessment set assessment=%s,recovery_assessment=%s,order_assessment=%s,express_phone=%s,express_money=%s,checking_phone=%s,check_phone=%s,deal_phone=%s,deal_money=%s,back_phone=%s,create_time='%s'  where to_days(date)=to_days('%s') and user_id = %s " % (statData.assessment, statData.recovery_assessment, statData.order_assessment, statData.express_phone,statData.express_money, statData.checking_phone, statData.check_phone, statData.deal_phone, statData.deal_money, statData.back_phone, get_cur_time(),statData.date_str,statData.user_id);
            print sql
            ret = cursor.execute(sql)
        return ret

    def __do_order_day_stat(self):
        print ("#ORDER DAY STAT begin...#")
        self._order_day_stat_result_map = {}
        self.__calc_order_day_stat_data(self._date)
        ret = self.__save_order_day_stat_data()
        if(ret == None):
           ret=0
        print ("###ORDER DAY STAT ... SAVA DATE : %d" % (ret))      
    def __calc_order_day_stat_data(self,date_str):
        self.__calc_order_day(date_str,"create_time")
        self.__calc_order_day(date_str,"express_time")
        self.__calc_order_day(date_str,"arrive_time")
        self.__calc_order_day(date_str,"check_time")
        self.__calc_order_day(date_str,"deal_time")
        self.__calc_order_day(date_str,"close_time")

    def __calc_order_day(self, date_str, time_name):
        self._log.printbegin();
        print ">>> Begin __calc_order_day: (field: %s)" % (time_name)
        sql ="select sum(1),user_id from tp_user_order where %s between \'%s\' and \'%s\' and user_id not in (%s) group by user_id" % (time_name, date_str,self._end_date,self._test_uid)
        self.__exec_order_sql_and_get_multi_result(sql, date_str, time_name)
        self._log.printend();
    def __exec_order_sql_and_get_multi_result(self, sql, date_str, time_name):
        print sql
        cursor = self._conn_order.cursor()
        cursor.execute(sql)
        cds = cursor.fetchall()
        for i in range(len(cds)):
            if(len(cds[i]) != 2):
                continue;
            count = cds[i][0]
            user_id = cds[i][1]
            key = str(date_str)+'-'+str(user_id);
            statData = self._order_day_stat_result_map.get(key);
            if(statData == None):
                statData = OrderStatData(date_str)
                statData.user_id = user_id
            if(time_name == "create_time"):
                statData.creates = count
            elif(time_name == "express_time"):
                statData.express = count
            elif(time_name == "arrive_time"):
                statData.arrive = count
            elif(time_name == "check_time"):
                statData.checks = count
            elif(time_name == "deal_time"):
                statData.over = count
            elif(time_name == "close_time"):
                statData.close = count
            self._order_day_stat_result_map.update({key:statData})
        cursor.close() 
    def __save_order_day_stat_data(self):
        print "Begin __save_order_day_stat_data"
        cursor = self._conn_order.cursor()
        for key in self._order_day_stat_result_map.keys():
            # print key;
            statData = self._order_day_stat_result_map[key]
            self.__save_single_order_day_stat_data(statData, cursor);
        self._conn_order.commit()
        cursor.close()
        return 0    
    def __save_single_order_day_stat_data(self, statData, cursor):
        sql = "select sum(1) from tp_statistics_order where to_days(date)=to_days('%s') and user_id = %s " % (statData.date_str,statData.user_id);
        # print sql
        cursor.execute(sql)
        cds = cursor.fetchone()
        # print cds;
        if cds[0] <= 0:
            sql = "insert into tp_statistics_order(user_id,creates,express,arrive,checks,over,close,date, create_time) values(%s,%s,%s,%s,%s,%s,%s,%s,%s)"
            param = []
            print statData.getInsertParam()
            param.append(statData.getInsertParam())
            print sql, param
            ret = cursor.executemany(sql,param)
        else:
            sql = "update tp_statistics_order set creates=%s,express=%s,arrive=%s,checks=%s,over=%s,close=%s,create_time='%s'  where to_days(date)=to_days('%s') and user_id = %s " % (statData.creates, statData.express, statData.arrive, statData.checks, statData.over, statData.close, get_cur_time(),statData.date_str,statData.user_id);
            print sql
            ret = cursor.execute(sql)
        return ret




    def __do_sell_day_stat(self):
        print ("#SELL DAY STAT begin...#")
        self._sell_day_stat_result_map = {}
        self.__calc_sell_day_stat_data(self._date)
        ret = self.__save_sell_day_stat_data()
        if(ret == None):
           ret=0
        print ("###ORDER DAY STAT ... SAVA DATE : %d" % (ret))      
    def __calc_sell_day_stat_data(self,date_str):
        self.__calc_sell_day(date_str)
        self.__calc_sell_day_deal(date_str)
        self.__calc_sell_day_deal_money(date_str)

    def __calc_sell_day(self, date_str):
        self._log.printbegin();
        print ">>> Begin __calc_sell_day: (table: tp_user_phone_sell)"
        sql ="select sum(1),channel_id from tp_user_phone_sell where create_time between \'%s\' and \'%s\' group by channel_id" % (date_str,self._end_date)
        self.__exec_sell_sql_and_get_multi_result(sql, date_str, 'offer')
        self._log.printend();
    def __calc_sell_day_deal(self, date_str):
        self._log.printbegin();
        print ">>> Begin __calc_sell_day_deal: (table: tp_user_order_assessment)"
        sql ="select sum(1),sell_channel from tp_user_order_assessment where sell_time between \'%s\' and \'%s\' and user_id not in (%s) group by sell_channel" % (date_str,self._end_date,self._test_uid)
        self.__exec_sell_sql_and_get_multi_result(sql, date_str, 'deal')
        self._log.printend();
    def __calc_sell_day_deal_money(self, date_str):
        self._log.printbegin();
        print ">>> Begin __calc_sell_day_deal_money: (table: tp_user_order_assessment)"
        sql ="select sum(sell_price),sell_channel from tp_user_order_assessment where sell_time between \'%s\' and \'%s\' and user_id not in (%s) group by sell_channel" % (date_str,self._end_date,self._test_uid)
        self.__exec_sell_sql_and_get_multi_result(sql, date_str, 'deal_money')
        self._log.printend();
    def __exec_sell_sql_and_get_multi_result(self, sql, date_str, field):
        print sql
        cursor = self._conn_order.cursor()
        cursor.execute(sql)
        cds = cursor.fetchall()
        for i in range(len(cds)):
            if(len(cds[i]) != 2):
                continue;
            count = cds[i][0]
            sell_id = cds[i][1]
            key = str(date_str)+'-'+str(sell_id);
            statData = self._sell_day_stat_result_map.get(key);
            if(statData == None):
                statData = SellStatData(date_str)
                statData.sell_id = sell_id
            if(field == "offer"):
                statData.offer = count
            elif(field == "deal"):
                statData.deal = count
            elif(field == "deal_money"):
                statData.deal_money = count
            self._sell_day_stat_result_map.update({key:statData})
        cursor.close() 
    def __save_sell_day_stat_data(self):
        print "Begin __save_sell_day_stat_data"
        cursor = self._conn_order.cursor()
        for key in self._sell_day_stat_result_map.keys():
            # print key;
            statData = self._sell_day_stat_result_map[key]
            self.__save_single_sell_day_stat_data(statData, cursor);
        self._conn_order.commit()
        cursor.close()
        return 0    
    def __save_single_sell_day_stat_data(self, statData, cursor):
        sql = "select sum(1) from tp_statistics_phone_sell where to_days(date)=to_days('%s') and sell_id = %s " % (statData.date_str,statData.sell_id);
        # print sql
        cursor.execute(sql)
        cds = cursor.fetchone()
        # print cds;
        if cds[0] <= 0:
            sql = "insert into tp_statistics_phone_sell(sell_id,offer,deal,deal_money, date, create_time) values(%s,%s,%s,%s,%s,%s)"
            param = []
            print statData.getInsertParam()
            param.append(statData.getInsertParam())
            print sql, param
            ret = cursor.executemany(sql,param)
        else:
            sql = "update tp_statistics_phone_sell set sell_id=%s,offer=%s,deal=%s,deal_money=%s,create_time='%s'  where to_days(date)=to_days('%s') and sell_id = %s " % (statData.sell_id, statData.offer, statData.deal,statData.deal_money, get_cur_time(),statData.date_str,statData.sell_id);
            print sql
            ret = cursor.execute(sql)
        return ret



    def __do_take_day_stat(self):
        print ("#TAKE DAY STAT begin...#")
        self._take_day_stat_result_map = {}
        self.__calc_take_day_stat_data(self._date)
        ret = self.__save_take_day_stat_data()
        if(ret == None):
           ret=0
        print ("###ORDER DAY STAT ... SAVA DATE : %d" % (ret))      
    def __calc_take_day_stat_data(self,date_str):
        self.__calc_take_day(date_str)
        self.__calc_take_out_day(date_str)

    def __calc_take_day(self, date_str):
        self._log.printbegin();
        print ">>> Begin __calc_take_day: (table: tp_user_phone_sell)"
        sql ="select sum(money),user_id from tp_user_take where status !=3 and  create_time between \'%s\' and \'%s\'  and user_id not in (%s)  group by user_id" % (date_str,self._end_date,self._test_uid)
        self.__exec_take_sql_and_get_multi_result(sql, date_str, 'take')
        self._log.printend();
    def __calc_take_out_day(self, date_str):
        self._log.printbegin();
        print ">>> Begin __calc_take_out_day: (table: tp_user_phone_sell)"
        sql ="select sum(money),user_id from tp_user_take where status = 2 and create_time between \'%s\' and \'%s\'  and user_id not in (%s) group by user_id" % (date_str,self._end_date,self._test_uid)
        self.__exec_take_sql_and_get_multi_result(sql, date_str, 'take_out')
        self._log.printend();
    
    def __exec_take_sql_and_get_multi_result(self, sql, date_str, field):
        print sql
        cursor = self._conn_order.cursor()
        cursor.execute(sql)
        cds = cursor.fetchall()
        for i in range(len(cds)):
            if(len(cds[i]) != 2):
                continue;
            count = cds[i][0]
            user_id = cds[i][1]
            key = str(date_str)+'-'+str(user_id);
            statData = self._take_day_stat_result_map.get(key);
            if(statData == None):
                statData = TakeStatData(date_str)
                statData.user_id = user_id
            if(field == "take"):
                statData.take = count
            if(field == "take_out"):
                statData.take_out = count
            self._take_day_stat_result_map.update({key:statData})
        cursor.close() 
    def __save_take_day_stat_data(self):
        print "Begin __save_take_day_stat_data"
        cursor = self._conn_order.cursor()
        for key in self._take_day_stat_result_map.keys():
            # print key;
            statData = self._take_day_stat_result_map[key]
            self.__save_single_take_day_stat_data(statData, cursor);
        self._conn_order.commit()
        cursor.close()
        return 0    
    def __save_single_take_day_stat_data(self, statData, cursor):
        sql = "select sum(1) from tp_statistics_money where to_days(date)=to_days('%s') and user_id = %s " % (statData.date_str,statData.user_id);
        # print sql
        cursor.execute(sql)
        cds = cursor.fetchone()
        # print cds;
        if cds[0] <= 0:
            sql = "insert into tp_statistics_money(user_id,take,take_out, date, create_time) values(%s,%s,%s,%s,%s)"
            param = []
            print statData.getInsertParam()
            param.append(statData.getInsertParam())
            print sql, param
            ret = cursor.executemany(sql,param)
        else:
            sql = "update tp_statistics_money set take='%s',take_out=%s  where to_days(date)=to_days('%s') and user_id = %s " % (statData.take,statData.take_out, statData.date_str,statData.user_id);
            print sql
            ret = cursor.execute(sql)
        return ret

    def __do_user_day_stat(self):
        print ("#USER DAY STAT begin...#")
        self._user_day_stat_result_map = {}
        self.__calc_user_day_stat_data(self._date)
        ret = self.__save_user_day_stat_data()
        if(ret == None):
           ret=0
        print ("###USER DAY STAT ... SAVA DATE : %d" % (ret))      
    def __calc_user_day_stat_data(self,date_str):
        self.__calc_user_login_day(date_str)
        self.__calc_new_user_day(date_str)

    def __calc_user_login_day(self, date_str):
        self._log.printbegin();
        print ">>> Begin __calc_user_login_day: (table: tp_user_phone_sell)"
        sql ="select sum(1),b.p_id,b.c_id,b.a_id from tp_user a left join (select * from tp_user_address order by id asc) as b on b.user_id = a.id where a.create_time between \'%s\' and \'%s\' and user_id not in (%s)  group by b.p_id,b.c_id,b.a_id" % (date_str,self._end_date,self._test_uid)
        self.__exec_user_sql_and_get_multi_result(sql, date_str, 'newuser')
        self._log.printend();
    def __calc_new_user_day(self, date_str):
        self._log.printbegin();
        print ">>> Begin __calc_newuser_day: (table: tp_user_phone_sell)"
        sql ="select sum(1),b.p_id,b.c_id,b.a_id from (select user_id from tbl_log_user_login where create_time between \'%s\' and \'%s\'  and user_id not in (%s)  group by user_id) as a left join (select * from tp_user_address order by id asc) as b on b.user_id = a.user_id group by b.p_id,b.c_id,b.a_id" % (date_str,self._end_date,self._test_uid)
        self.__exec_user_sql_and_get_multi_result(sql, date_str, 'login')
        self._log.printend();
    
    def __exec_user_sql_and_get_multi_result(self, sql, date_str, field):
        print sql
        cursor = self._conn_order.cursor()
        cursor.execute(sql)
        cds = cursor.fetchall()
        for i in range(len(cds)):
            if(len(cds[i]) != 4):
                continue;
            count = cds[i][0]
            p_id = cds[i][1]
            c_id = cds[i][2]
            a_id = cds[i][3]
            if(p_id == None):
                p_id = c_id = a_id = 0;
            key = str(date_str)+'-'+str(p_id)+'-'+str(c_id)+'-'+str(a_id);
            statData = self._user_day_stat_result_map.get(key);
            if(statData == None):
                statData = UserStatData(date_str)
                statData.p_id = p_id
                statData.c_id = c_id
                statData.a_id = a_id
            if(field == "login"):
                statData.login = count
            if(field == "newuser"):
                statData.newuser = count
            self._user_day_stat_result_map.update({key:statData})
        cursor.close() 
    def __save_user_day_stat_data(self):
        print "Begin __save_user_day_stat_data"
        cursor = self._conn_order.cursor()
        for key in self._user_day_stat_result_map.keys():
            # print key;
            statData = self._user_day_stat_result_map[key]
            self.__save_single_user_day_stat_data(statData, cursor);
        self._conn_order.commit()
        cursor.close()
        return 0    
    def __save_single_user_day_stat_data(self, statData, cursor):
        sql = "select sum(1) from tp_statistics_user where to_days(date)=to_days('%s') and p_id = %s and c_id = %s and a_id = %s " % (statData.date_str,statData.p_id,statData.c_id,statData.a_id);
        print sql
        cursor.execute(sql)
        cds = cursor.fetchone()
        print cds;
        if cds[0] <= 0:
            sql = "insert into tp_statistics_user(p_id,c_id,a_id,login,newuser, date, create_time) values(%s,%s,%s,%s,%s,%s,%s)"
            param = []
            print statData.getInsertParam()
            param.append(statData.getInsertParam())
            print sql, param
            ret = cursor.executemany(sql,param)
        else:
            sql = "update tp_statistics_user set login='%s',newuser= '%s'  where to_days(date)=to_days('%s') and p_id = %s and c_id = %s and a_id = %s " % (statData.login,statData.newuser, statData.date_str,statData.p_id,statData.c_id,statData.a_id);
            print sql
            ret = cursor.execute(sql)
        return ret
    # def __do_create_recevie_log(self):
    #     table_name = "tbl_res_receive%s_log" % self.tomorrow
    #     self.receive_log_table_name = "tbl_res_receive%s_log" % self.yestoday
    #     sql = "CREATE TABLE IF NOT EXISTS `%s` (`id` int(10) unsigned NOT NULL auto_increment,`res_id` int(11) NOT NULL,`push_id` int(10) unsigned NOT NULL,`app_vercode` varchar(30) NOT NULL,`sdk_vercode` varchar(30) NOT NULL,`user_type` int(11) NOT NULL,`package_name` varchar(100) NOT NULL,`client_id` varchar(100) NOT NULL,`channel_id` int(11) NOT NULL,`action_through` tinyint(3) unsigned NOT NULL COMMENT '1-Market, 2-Push3-Silence',`action_time` timestamp NOT NULL default CURRENT_TIMESTAMP,PRIMARY KEY  (`id`),KEY `res_id` (`push_id`),KEY `client_id` (`client_id`),KEY `user_type` (`user_type`),KEY `channel_id` (`channel_id`),KEY `package_name` (`package_name`),KEY `action_time` (`action_time`),KEY `push_id` (`push_id`),KEY `action_through` (`action_through`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;" % table_name
    #     cursor = self._conn_os.cursor();
    #     print "show tables like '%s';" % table_name
    #     cursor.execute("show tables like '%s';" % table_name)
    #     cds = cursor.fetchall()
    #     if(len(cds) == 0):
    #         cursor.execute(sql)
    #         self._conn_os.commit()
    #         cursor.close()
    #         print "Create table %s success" % table_name
    #     else:
    #         print "Create table %s error" % table_name     

    # def __calc_order_day_receive_log(self,date_str):
    #     self._log.printbegin();
    #     sql_get_today_count ="select c.res_id,CASE a.channel_id WHEN '0' THEN b.channel_id ELSE a.channel_id END as channel_id,a.action_through,CASE c.type WHEN 1 THEN 1 WHEN 2 THEN 2 WHEN 3 THEN 3 ELSE 0 END as type from %s a left join tbl_airpush_info c on a.push_id = c.id , tbl_mobile_client b  where a.action_time between \'%s\' and \'%s\' and a.client_id = b.client_gen_id and a.action_through =2 union all select c.res_id,CASE a.channel_id WHEN '0' THEN b.channel_id ELSE a.channel_id END as channel_id,a.action_through,CASE c.category WHEN 1 THEN 4 WHEN 2 THEN 5 WHEN 3 THEN 6 WHEN 4 THEN 7 WHEN 10 THEN 8 ELSE 0 END as type from %s a left join tbl_adsdk_ad c on a.push_id = c.id , tbl_mobile_client b  where a.action_time between \'%s\' and \'%s\' and a.client_id = b.client_gen_id and a.action_through IN (5,6) union all select a.res_id,CASE a.channel_id WHEN '0' THEN b.channel_id ELSE a.channel_id END as channel_id,a.action_through,CASE a.action_through WHEN 3 THEN 9 WHEN 7 THEN 10 END as type from %s a , tbl_mobile_client b  where a.action_time between \'%s\' and \'%s\' and a.client_id = b.client_gen_id and a.action_through IN (3,7)" % (self.receive_log_table_name, date_str,self._end_date,self.receive_log_table_name, date_str,self._end_date,self.receive_log_table_name, date_str,self._end_date)
    #     sql = "select res_id,sum(1) as count,type,channel_id from (%s) a, tbl_resource b where a.res_id = b.id GROUP by a.type,a.action_through,a.res_id,a.channel_id" % (sql_get_today_count)
    #     self.__exec_res_sql_and_get_multi_result(sql, date_str, self.receive_log_table_name)
    #     self._log.printend();
        
if __name__ == "__main__":
    date_str = datetime.date.today() - datetime.timedelta(days=1)
    stat = CStatManager(date_str)
    stat.do_stat()
    
